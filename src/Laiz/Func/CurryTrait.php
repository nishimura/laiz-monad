<?php

namespace Laiz\Func;

trait CurryTrait
{
    protected $value;

    public static function curry(callable $f)
    {
        $ref = new \ReflectionFunction($f);
        $count = $ref->getNumberOfParameters();

        if ($count === 0)
            throw new \InvalidArgumentException('Cannot curry none arguments function');

        $args = array_fill(0, $count, null);
        $prev = function($a) use ($f, &$args, $count){
            $args[$count - 1] = $a;
            return call_user_func_array($f, $args);
        };
        for ($i = $count - 2; $i >= 0; $i--){
            $prev = new static(function($a) use ($prev, &$args, $i){
                $args[$i] = $a;
                return $prev;
            });
        }
        return $prev;
    }

    public function __invoke($a)
    {
        if ($this->value instanceof Curry){
            $count = 1;
        }else if (is_callable($this->value)){
            $ref = new \ReflectionFunction($this->value);
            $count = $ref->getNumberOfParameters();
        }

        $args = func_get_args();
        $params = [];
        for ($i = 0; $i < $count; $i ++){
            $params[] = array_shift($args);
        }
        $ret = call_user_func_array($this->value, $params);

        if ($args){
            return call_user_func_array($ret, $args);
        }else{
            if (is_callable($ret) && !($ret instanceof Curry))
                return new static($ret);
            else
                return $ret;
        }
    }

    /*
     * alias of __invoke
     */
    public function apply()
    {
        return call_user_func_array($this, func_get_args());
    }

    public function compose(callable $f)
    {
        return new static(function ($a) use ($f){
            if (!($f instanceof static))
                $f = new static($f);
            return call_user_func($this, $f($a));
        });
    }
}

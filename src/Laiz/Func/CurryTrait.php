<?php

namespace Laiz\Func;

trait CurryTrait
{
    protected $value;

    private static function getReflection(callable $f)
    {
        if (is_array($f)){
            return new \ReflectionMethod($f[0], $f[1]);
        }else if (is_string($f) &&
                  preg_match('/^([^:]+)::(.*)$/', $f, $m)){
            return new \ReflectionMethod($m[1], $m[2]);
        }else{
            return new \ReflectionFunction($f);
        }
    }

    public static function curry(callable $f)
    {
        $ref = self::getReflection($f);
        $count = $ref->getNumberOfParameters();

        if ($count === 0)
            throw new \InvalidArgumentException('Cannot curry none arguments function');

        $makeCurry = function($count, $args) use ($f, &$makeCurry){
            $count--;
            if ($count > 0){
                return new static(function($a) use (&$makeCurry, $count, $args){
                    $args[] = $a;
                    return $makeCurry($count, $args);
                });
            }else{
                return function($a) use ($args, $f){
                    $args[] = $a;
                    $anys = [];

                    foreach ($args as $k => $v){
                        if ($v instanceof Any)
                            $anys[$k] = $v;
                    }
                    if ($anys){
                        $ref = new \ReflectionFunction($f);
                        $params = $ref->getParameters();
                        foreach ($anys as $k => $v){
                            $type = $params[$k]->getClass();
                            if ($type){
                                $args[$k] = $v->castByName($type->getName());
                            }
                        }
                    }
                    return $f(...$args);
                };
            }
        };
        return $makeCurry($count, []);
    }

    public function __invoke($a)
    {
        if ($this->value instanceof Curry){
            $count = 1;
        }else if (is_object($this->value) && is_callable($this->value)){
            $ref = self::getReflection($this->value);
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
            if (is_object($ret) &&
                is_callable($ret) && !($ret instanceof Curry))
                return new static($ret);
            else
                return $ret;
        }
    }

    /*
     * alias of __invoke
     */
    public function apply(...$args)
    {
        return $this(...$args);
    }
}

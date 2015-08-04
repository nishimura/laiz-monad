<?php

namespace Laiz\Monad\DataList;

use Laiz\Monad\MonadPlus;

class Cons extends \Laiz\Monad\DataList
{
    protected $value;
    public function __construct($value)
    {
        if ($value === null)
            throw new \InvalidArgumentException('null is invalid');

        $this->value = [$value];
    }

    /**
     * @return Laiz\Monad\DataList
     */
    public function bind(callable $f)
    {
        $foldl = function($f, $b, $a){
            return array_reduce($a->toArray(), $f, $b);
        };
        $concat = function ($arr) use ($foldl){
            $f = function($carry, $item){
                return self::fromArray(array_merge($carry->toArray(), $item->toArray()));
            };
            return $foldl($f, Nil::getInstance(), $arr);
        };

        return $concat($this->map($f));
    }

    /**
     * @return Laiz\Monad\DataList
     */
    public function mplus(MonadPlus $m)
    {
        if (!($m instanceof \Laiz\Monad\DataList))
            $this->fail();

        if ($m instanceof Nil)
            return $this;

        return $this::fromArray(array_merge($this->value, $m->value));
    }

    public function toArray()
    {
        return $this->value;
    }

    public function map(callable $f)
    {
        return $this::fromArray(array_map($f, $this->value));
    }
}

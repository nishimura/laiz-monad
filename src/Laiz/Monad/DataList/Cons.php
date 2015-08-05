<?php

namespace Laiz\Monad\DataList;

use Laiz\Monad\MonadPlus;

class Cons extends \Laiz\Monad\DataList
{
    public function __construct($value)
    {
        if ($value === null)
            throw new \InvalidArgumentException('null is invalid');

        if ($value instanceof \Laiz\Monad\Monad)
            $this->value = $value;
        else
            $this->value = [$value];
    }

    /**
     * @return Laiz\Monad\DataList
     */
    protected function bindInternal(callable $f)
    {
        $foldl = function($f, $b, $a){
            if ($a instanceof \Laiz\Monad\DataList)
                $a = $a->toArray();
            return array_reduce($a, $f, $b);
        };
        $concat = function ($arr) use ($foldl){
            $f = function($carry, $item){
                if ($carry instanceof \Laiz\Monad\DataList)
                    $carry = $carry->toArray();
                if ($item instanceof \Laiz\Monad\DataList)
                    $item = $item->toArray();

                return self::fromArray(array_merge($carry, $item));
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
        assert($m instanceof \Laiz\Monad\DataList);

        if ($m instanceof Nil)
            return $this;

        if ($this->value instanceof \Laiz\Monad\DataList &&
            $m->value  instanceof \Laiz\Monad\DataList)
            return self::fromArray([$this->value, $m->value]);
        else
            return self::fromArray(array_merge($this->value, $m->value));
    }

    public function toArray()
    {
        if ($this->value instanceof \Laiz\Monad\DataList)
            return [$this->value];
        else
            return $this->value;
    }

    public function map(callable $f)
    {
        if ($this->value instanceof \Laiz\Monad\DataList)
            return new self($this->value->map($f));
        else
            return self::fromArray(array_map($f, $this->value));
    }
}

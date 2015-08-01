<?php

namespace Laiz\Monad\DataList;

use Laiz\Monad\MonadPlus;

class Cons extends \Laiz\Monad\DataList
{
    private $value;
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
        $ret = [];

        foreach ($this->value as $v){
            $inner = $f($v);

            if ($inner instanceof Nil)
                continue;

            foreach ($inner->value as $v2){
                $ret[] = $v2;
            }
        }

        if (count($ret) === 0)
            return $this::mzero();
        else
            return $this::fromArray($ret);
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

        return Cons::fromArray(array_merge($this->value, $m->value));
    }

    public static function fromArray(array $a)
    {
        if (count($a) === 0)
            return Nil::getInstance();

        $cons = new Cons($a);
        $cons->value = $a;
        return $cons;
    }

    public function toArray()
    {
        return $this->value;
    }
}

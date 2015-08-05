<?php

namespace Laiz\Monad;

abstract class DataList implements Monad, MonadPlus,
\IteratorAggregate // FIXME: bad impl (DataList <=> php array <=> Iterator)
{
    use MonadTrait;
    use DataListTrait;

    abstract public function map(callable $f);
    abstract public function toArray();

    public static function fromArray(array $a)
    {
        if (count($a) === 0)
            return DataList\Nil::getInstance();

        $cons = new DataList\Cons($a);
        $cons->value = $a;
        return $cons;
    }

    public function getIterator()
    {
        if ($this->value instanceof DataList)
            return $this->value;
        else
            return new \ArrayIterator($this->value);
    }
}

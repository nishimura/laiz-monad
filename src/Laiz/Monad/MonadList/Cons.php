<?php

namespace Laiz\Monad\MonadList;

use Laiz\Monad\MonadPlus;

class Cons extends \Laiz\Monad\MonadList
{
    protected function __construct($value)
    {
        if ($value === null)
            throw new \InvalidArgumentException('null is invalid');

        $this->value = $value;
    }

    /**
     * @return Laiz\Monad\DataList
     */
    public function mplus(MonadPlus $m)
    {
        assert($m instanceof \Laiz\Monad\MonadList,
               'mplus argument must be MonadList instance');

        if ($m instanceof Nil)
            return $this;

        $value = new \AppendIterator();
        $value->append($this->value);
        $value->append($m->value);
        return new Cons($value);
    }

    public function map(callable $f)
    {
        return new Cons(new MapIterator($this->value, $f));
    }
}

class MapIterator extends \IteratorIterator
{
    private $f;
    public function __construct(\Traversable $iterator, callable $f)
    {
        parent::__construct($iterator);
        $this->f = $f;
    }
    public function current()
    {
        $f = $this->f;
        return $f(parent::current());
    }
}

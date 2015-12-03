<?php

namespace Laiz\Monad;

abstract class MonadList implements Monad, MonadPlus, \IteratorAggregate, \Countable
{
    use MonadTrait;

    public static function ret($a)
    {
        if ($a === null)
            throw new \InvalidArgumentException('null is invalid');

        return MonadList::cast(new \ArrayIterator([$a]));
    }

    public static function fail($a = null)
    {
        return MonadList\Nil::getInstance();
    }

    public static function mzero()
    {
        return self::fail();
    }

    /**
     * @return Laiz\Monad\DataList
     */
    protected function bindInternal(callable $f)
    {
        return $this->map($f)->concat();
    }

    // (Monad m) => m (m a) -> m a
    public function join()
    {
        $hit = false;
        // can not check Traversable
        $ret = $this->bind(function($a) use (&$hit){
                assert($a instanceof self, 'join instance must be m (m a)');
                $hit = true;
                return $a;
            });
        assert($hit, 'join instance must be m (m a)');
        return $ret;
    }

    abstract public function map(callable $f);

    public static function cast($a)
    {
        if (is_array($a))
            $value = new \ArrayIterator($a);
        else if ($a instanceof MonadList)
            $value = $a;
        else if ($a instanceof \Traversable)
            $value = $a;
        else
            throw new \InvalidArgumentException('not supported type');

        if ($value instanceof \Countable)
            $count = count($value);
        else
            $count = iterator_count($value);
        if ($count === 0)
            return MonadList\Nil::getInstance();

        $cons = new MonadList\Cons($value);
        return $cons;
    }

    public function count()
    {
        if ($this->value instanceof \Countable)
            return count($this->value);
        else
            return iterator_count($this->value);
    }

    public function getIterator()
    {
        return $this->value;
    }

    public function concat()
    {
        $ret = [];
        $hit = false;
        foreach ($this as $arr){
            $hit = true;
            assert($arr instanceof self, 'concat instance must be [[]]');
            foreach ($arr as $v){
                $ret[] = $v;
            }
        }
        return self::cast($ret);
    }

    public function toArray($ite = null)
    {
        if ($ite === null)
            $ite = $this;
        $ret = [];
        foreach ($ite as $v){
            if (is_array($v) || $v instanceof \Traversable)
                $ret[] = $this->toArray($v);
            else
                $ret[] = $v;
        }
        return $ret;
    }
}

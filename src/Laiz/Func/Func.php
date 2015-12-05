<?php

namespace Laiz\Func;

use Laiz\Monad;

class Func extends Curry implements Monad\Monad
{
    use Monad\MonadTrait;

    public function __construct(callable $f)
    {
        $this->value = static::curry($f);
    }

    // Functor
    public function fmap(callable $f)
    {
        return $this->compose($f);
    }

    // Applicative
    public static function pure($a)
    {
        return new static($a);
    }

    // Applicative
    public function ap(Applicative $f)
    {
        assert($f instanceof static);

        return $this->fmap($f);
    }

    // ret
    public static function ret($value)
    {
        // const
        return new static(function($_) use ($value){
            return $value;
        });
    }

    // Monad
    public static function fail($msg = null)
    {
        throw new \RuntimeException($msg);
    }

    /**
     * @override
     */
    protected function bindInternal(callable $f)
    {
        return new static(function($a) use ($f){
            if (!($f instanceof self))
                $f = new self($f);
            return $f($this($a), $a);
        });
        return $f($this->fromJust());
    }
}

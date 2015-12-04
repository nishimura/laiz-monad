<?php

namespace Laiz\Func;

class Func extends Curry implements Functor, Applicative
{
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
}

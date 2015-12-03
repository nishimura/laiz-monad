<?php

namespace Laiz\Monad;

use Laiz\Func\Applicative;

trait MonadTrait
{
    use ControlTrait;

    public function bind(callable $f)
    {
        $ret = $this->bindInternal($f);
        assert($ret instanceof self, 'bind callback must return monad instance');
        return $ret;
    }

    // Functor
    public function fmap(callable $f)
    {
        return $this->bind(function($value) use ($f){
            return static::ret($f($value));
        });
    }

    // Applicative
    public static function pure($a)
    {
        return static::ret($a);
    }

    // Applicative
    public function ap(Applicative $f)
    {
        assert($f instanceof static);

        return $this->fmap($f);
    }

    abstract protected function bindInternal(callable $f);
}

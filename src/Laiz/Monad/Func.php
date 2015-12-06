<?php

namespace Laiz\Monad;

use Laiz\Func as F;

class Func extends F\Curry implements Monad
{
    use MonadTrait;

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
    public function ap(F\Applicative $f)
    {
        assert($f instanceof static);

        return $this->fmap($f);
    }

    // Monad
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
    }

    public static function importUtil()
    {
        require_once dirname(dirname(dirname(__DIR__))) . '/lib/func.php';
    }
}

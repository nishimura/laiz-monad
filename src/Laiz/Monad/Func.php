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
        return $f->compose($this);
    }

    // Applicative
    public static function pure($a)
    {
        return new static($a);
    }

    // Applicative # <*> (sub class method required), Monad # ap
    public function ap(F\Applicative $a)
    {
        assert($a instanceof static);

        if (!($this instanceof Monad)){
            trigger_error('Not Supported ' . get_class($this));
        }
        if (!($a instanceof Monad)){
            trigger_error('Not Supported ' . get_class($this));
        }

        return $this->bind(function($f) use ($a){
            return $a->bind(function($v) use ($f){
                return $this->ret($f($v));
            });
        });
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

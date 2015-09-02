<?php

namespace Laiz\Monad;

abstract class Maybe implements Monad, MonadPlus
{
    use MonadTrait;

    public static function ret($a)
    {
        if ($a === null)
            throw new \InvalidArgumentException('null is invalid');

        return new Maybe\Just($a);
    }

    /**
     * @param $a string
     */
    public static function fail($a = null)
    {
        return Maybe\Nothing::getInstance();
    }

    /**
     * @return Laiz\Monad\Maybe
     */
    public static function mzero()
    {
        return self::fail();
    }

    /**
     * @param $a mixed
     * @return mixed
     */
    abstract public function fromMaybe($a);

    /**
     * @param $a mixed
     * @return mixed
     */
    abstract public function maybe($a, callable $f);
}

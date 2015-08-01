<?php

namespace Laiz\Monad;

use Laiz\Monad\MonadPlus;

trait MaybeTrait
{
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
}

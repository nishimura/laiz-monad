<?php

namespace Laiz\Monad;

trait DataListTrait
{
    public static function ret($a)
    {
        if ($a === null)
            throw new \InvalidArgumentException('null is invalid');

        return new DataList\Cons($a);
    }

    public static function fail($a = null)
    {
        return DataList\Nil::getInstance();
    }

    public static function mzero()
    {
        return self::fail();
    }
}

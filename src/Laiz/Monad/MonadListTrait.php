<?php

namespace Laiz\Monad;

trait MonadListTrait
{
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
}

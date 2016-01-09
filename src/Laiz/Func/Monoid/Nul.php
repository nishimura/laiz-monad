<?php

namespace Laiz\Func\Monoid;

use Laiz\Func\Monoid;

class Nul implements Monoid
{
    public static function mempty()
    {
        return null;
    }

    public static function mappend($m1, $m2)
    {
        assert(is_null($m1), 'First argument must be null');

        return $m2;
    }
}

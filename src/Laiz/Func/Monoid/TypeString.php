<?php

namespace Laiz\Func\Monoid;

use Laiz\Func\Monoid;

class TypeString implements Monoid
{
    public static function mempty()
    {
        return '';
    }

    public static function mappend($m1, $m2)
    {
        assert(is_string($m1), 'First argument must be string');
        assert(is_string($m2), 'Second argument must be string');

        return $m1 . $m2;
    }
}

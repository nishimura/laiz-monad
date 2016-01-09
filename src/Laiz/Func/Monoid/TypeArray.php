<?php

namespace Laiz\Func\Monoid;

use Laiz\Func\Monoid;

class TypeArray implements Monoid
{
    public static function mempty()
    {
        return [];
    }

    public static function mappend($m1, $m2)
    {
        assert(is_array($m1), 'First argument must be array');
        assert(is_array($m2), 'Second argument must be array');

        $ret = [];
        foreach ($m1 as $a) $ret[] = $a;
        foreach ($m2 as $a) $ret[] = $a;

        return $ret;
    }
}

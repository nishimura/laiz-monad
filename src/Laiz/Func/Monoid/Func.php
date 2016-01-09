<?php

namespace Laiz\Func\Monoid;

use Laiz\Func\Monoid;
use Laiz\Func\Func as Instance;

class Func implements Monoid
{
    public static function mempty()
    {
        return f(function($_){ return mempty(); });
    }

    public static function mappend($m1, $m2)
    {
        assert($m1 instanceof Instance, 'First argument must be Func');
        assert($m2 instanceof Instance, 'Second argument must be Func');

        return f(function($f, $g, $a){
            return mappend($f($a), $g($a));
        }, $m1, $m2);
    }
}

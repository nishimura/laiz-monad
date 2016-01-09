<?php

namespace Laiz\Func\Monoid;

use Laiz\Func\Monoid;
use Laiz\Func\Unit as Instance;

class Unit implements Monoid
{
    public static function mempty()
    {
        return new Instance();
    }

    public static function mappend($m1, $m2)
    {
        assert($m1 instanceof Instance, 'First argument must be Unit');
        assert($m2 instanceof Instance ||
               $m2 instanceof \Laiz\Func\Any, 'Second argument must be Unit');

        return $m1;
    }
}

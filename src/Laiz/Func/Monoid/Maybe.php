<?php

namespace Laiz\Func\Monoid;

use Laiz\Func\Monoid;
use Laiz\Func\Maybe as Instance;

class Maybe implements Monoid
{
    public static function mempty()
    {
        return new Instance\Nothing();
    }

    public static function mappend($m1, $m2)
    {
        assert($m1 instanceof Instance, 'First argument must be Maybe');
        assert($m2 instanceof Instance, 'Second argument must be Maybe');

        if ($m1 instanceof Instance\Nothing)
            return $m2;

        if ($m2 instanceof Instance\Nothing)
            return $m1;

        $v1 = $m1->fromJust();
        $v2 = $m2->fromJust();

        return new Instance\Just(mappend($v1, $v2));
    }
}

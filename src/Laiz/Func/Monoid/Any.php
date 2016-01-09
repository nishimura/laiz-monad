<?php

namespace Laiz\Func\Monoid;

use Laiz\Func\Monoid;
use Laiz\Func\Any as Instance;

class Any implements Monoid
{
    public static function mempty()
    {
        return new Instance();
    }

    public static function mappend($m1, $m2)
    {
        assert($m1 instanceof Instance, 'First argument must be Any');
        assert($m2 instanceof Instance, 'Second argument must be Any');

        return Instance::op($m1, 'mappend', $m2);
    }
}

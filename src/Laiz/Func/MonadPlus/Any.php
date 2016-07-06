<?php

namespace Laiz\Func\MonadPlus;

use Laiz\Func\Monad;
use Laiz\Func\MonadPlus;
use Laiz\Func\Any as Instance;

class Any extends Monad\Any implements MonadPlus
{
    public static function mplus($m1, $m2)
    {
        assert($m1 instanceof Instance, 'First argument must be Any');
        assert($m2 instanceof Instance, 'Second argument must be Any');

        return Instance::op($m1, 'mplus', $m2);
    }
}

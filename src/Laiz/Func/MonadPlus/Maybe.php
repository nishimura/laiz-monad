<?php

namespace Laiz\Func\MonadPlus;

use Laiz\Func\Monad;
use Laiz\Func\MonadPlus;
use Laiz\Func\Maybe as Instance;

class Maybe extends Monad\Maybe implements MonadPlus
{
    public static function mzero()
    {
        return new Instance\Nothing();
    }
    public static function mplus($m1, $m2)
    {
        if ($m1 instanceof Instance\Just)
            return $m1;
        else
            return $m2;
    }
}

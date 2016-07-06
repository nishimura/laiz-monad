<?php

namespace Laiz\Func\MonadZero;

use Laiz\Func\Monad;
use Laiz\Func\MonadZero;
use Laiz\Func\Any as Instance;

class Any extends Monad\Any implements MonadZero
{
    public static function mzero()
    {
        return new Instance('mzero');
    }
}

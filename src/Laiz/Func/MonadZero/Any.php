<?php

namespace Laiz\Func\MonadZero;

use Laiz\Func\Applicative;
use Laiz\Func\MonadZero;
use Laiz\Func\Any as Instance;

class Any extends Applicative\Any implements MonadZero
{
    public static function mzero()
    {
        return new Instance('mzero');
    }
}

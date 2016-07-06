<?php

namespace Laiz\Func\MonadZero;

use Laiz\Func\Monad;
use Laiz\Func\MonadZero;
use Laiz\Func\Maybe as Instance;

class Maybe extends Monad\Maybe implements MonadZero
{
    public static function mzero()
    {
        return new Instance\Nothing();
    }
}

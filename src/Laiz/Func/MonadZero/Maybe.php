<?php

namespace Laiz\Func\MonadZero;

use Laiz\Func\Applicative;
use Laiz\Func\MonadZero;
use Laiz\Func\Maybe as Instance;

class Maybe extends Applicative\Maybe implements MonadZero
{
    public static function mzero()
    {
        return new Instance\Nothing();
    }
}

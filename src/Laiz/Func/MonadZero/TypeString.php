<?php

namespace Laiz\Func\MonadZero;

use Laiz\Func\MonadZero;
use Laiz\Func\Monad;
use Laiz\Func\Monoid;

class TypeString extends Monad\TypeString implements MonadZero
{
    public static function mzero()
    {
        return Monoid\TypeString::mempty();
    }
}

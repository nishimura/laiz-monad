<?php

namespace Laiz\Func\MonadZero;

use Laiz\Func\MonadZero;
use Laiz\Func\Monoid;

class TypeString extends Monoid\TypeString implements MonadZero
{
    public static function mzero()
    {
        return self::mempty();
    }
}

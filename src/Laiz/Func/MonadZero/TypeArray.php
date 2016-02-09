<?php

namespace Laiz\Func\MonadZero;

use Laiz\Func\Applicative;
use Laiz\Func\MonadZero;
use Laiz\Func\Monoid;

class TypeArray extends Applicative\TypeArray implements MonadZero
{
    public static function mzero()
    {
        return Monoid\TypeArray::mempty();
    }
}

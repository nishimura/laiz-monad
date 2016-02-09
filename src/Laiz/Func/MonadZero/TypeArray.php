<?php

namespace Laiz\Func\MonadZero;

use Laiz\Func\Monad;
use Laiz\Func\MonadZero;
use Laiz\Func\Monoid;

class TypeArray extends Monad\TypeArray implements MonadZero
{
    public static function mzero()
    {
        return Monoid\TypeArray::mempty();
    }
}

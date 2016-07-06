<?php

namespace Laiz\Func\MonadPlus;

use Laiz\Func\Monad;
use Laiz\Func\MonadPlus;
use Laiz\Func\Monoid;

class TypeArray extends Monad\TypeArray implements MonadPlus
{
    public static function mplus($m1, $m2)
    {
        return Monoid\TypeArray::mappend($m1, $m2);
    }
}

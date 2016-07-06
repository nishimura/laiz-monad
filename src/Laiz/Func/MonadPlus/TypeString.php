<?php

namespace Laiz\Func\MonadPlus;

use Laiz\Func\MonadPlus;
use Laiz\Func\Monoid;

class TypeString extends Monoid\TypeString implements MonadPlus
{
    public static function mplus($m1, $m2)
    {
        return self::mappend($m1, $m2);
    }
}

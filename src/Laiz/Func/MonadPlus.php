<?php

namespace Laiz\Func;

interface MonadPlus extends Monad
{
    public static function mzero();
    public static function mplus($m1, $m2);
}

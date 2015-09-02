<?php

namespace Laiz\Func;

interface MonadPlus extends Monad
{
    public static function mzero();
    public function mplus(MonadPlus $m);
}

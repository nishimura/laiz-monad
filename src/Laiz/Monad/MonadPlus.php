<?php

namespace Laiz\Monad;

interface MonadPlus extends Monad
{
    /**
     * @return Laiz\MonadPlus
     */
    public static function mzero();

    /**
     * @return Laiz\MonadPlus
     */
    public function mplus(MonadPlus $m);
}

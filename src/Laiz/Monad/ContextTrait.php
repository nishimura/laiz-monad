<?php

namespace Laiz\Monad;

trait ContextTrait
{
    /**
     * @param callable $f (a -> m b)
     * @return Laiz\Monad\Monad
     */
    public function bind(callable $f)
    {
        return new \BadMethodCallException('unsupported');
    }

    /**
     * @return Laiz\Monad\MonadPlus
     */
    public function mplus(MonadPlus $m)
    {
        return new \BadMethodCallException('unsupported');
    }
}

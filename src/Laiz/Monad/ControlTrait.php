<?php

namespace Laiz\Monad;

trait ControlTrait
{
    // (Monad m) => m (m a) -> m a
    public function join()
    {
        assert($this->value instanceof self, 'join instance must be m (m a)');
        return $this->bind(function($a){ return $a; });
    }
}

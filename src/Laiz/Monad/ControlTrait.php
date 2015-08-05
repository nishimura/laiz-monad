<?php

namespace Laiz\Monad;

trait ControlTrait
{
    // (Monad m) => m (m a) -> m a
    public function join()
    {
        assert($this->value instanceof self);
        return $this->bind(function($a){ return $a; });
    }
}

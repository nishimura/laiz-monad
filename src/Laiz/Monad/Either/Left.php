<?php

namespace Laiz\Monad\Either;

class Left extends \Laiz\Monad\Either
{
    protected function bindInternal(callable $f)
    {
        return $this;
    }

    /**
     * @return mixed
     */
    public function either(callable $left, callable $right)
    {
        return $left($this->value);
    }
}

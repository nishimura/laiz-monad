<?php

namespace Laiz\Monad\Either;

class Left extends \Laiz\Monad\Either
{
    public function bind(callable $f)
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

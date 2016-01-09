<?php

namespace Laiz\Func\Either;

class Left extends \Laiz\Func\Either
{
    /**
     * @return mixed
     */
    public function either(callable $left, callable $right)
    {
        return $left($this->value);
    }
}

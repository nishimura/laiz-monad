<?php

namespace Laiz\Func\Either;

class Right extends \Laiz\Func\Either
{
    /**
     * @return mixed
     */
    public function either(callable $left, callable $right)
    {
        return $right($this->value);
    }
}

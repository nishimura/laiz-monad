<?php

namespace Laiz\Monad\Either;

class Right extends \Laiz\Monad\Either
{
    /**
     * @param mixed
     */
    public function __construct($value)
    {
        if ($value === null)
            throw new \InvalidArgumentException('null is invalid');
        parent::__construct($value);
    }

    protected function bindInternal(callable $f)
    {
        return $f($this->value);
    }

    /**
     * @return mixed
     */
    public function either(callable $left, callable $right)
    {
        return $right($this->value);
    }
}

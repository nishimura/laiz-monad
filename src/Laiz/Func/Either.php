<?php

namespace Laiz\Func;

abstract class Either
{
    use CallTrait;

    public $value;

    /**
     * @param mixed
     */
    public function __construct($value)
    {
        if ($value === null)
            $value = new \Laiz\Func\Unit();
        $this->value = $value;
    }

    abstract public function either(callable $left, callable $right);
}

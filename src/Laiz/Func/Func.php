<?php

namespace Laiz\Func;

class Func extends Curry
{
    use CallTrait;

    public function __construct(callable $f)
    {
        $this->value = static::curry($f);
    }
}

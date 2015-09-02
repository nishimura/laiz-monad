<?php

namespace Laiz\Func;

class Curry
{
    use CurryTrait;

    public function __construct(callable $f)
    {
        $this->value = self::curry($f);
    }
}

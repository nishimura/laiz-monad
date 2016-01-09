<?php

namespace Laiz\Func;

abstract class Maybe
{
    use CallTrait;

    protected $value;
    public function __construct($a)
    {
        $this->value = $a;
    }
}

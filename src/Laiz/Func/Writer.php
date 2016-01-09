<?php

namespace Laiz\Func;

class Writer
{
    use CallTrait;

    public $a;
    public $w;
    public function __construct($a, $w)
    {
        $this->a = $a;
        $this->w = $w;
    }
}

namespace Laiz\Func\Writer;
use Laiz\Func\Writer;


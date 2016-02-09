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
use Laiz\Func\Unit;
use function Laiz\Func\f;

function tell(...$args)
{
    // Monoid w
    return f(function($w){
        return new Writer(new Unit(), $w);
    }, ...$args);
}

function runWriter(...$args)
{
    return f(function(Writer $w){
        return [$w->a, $w->w];
    }, ...$args);
}

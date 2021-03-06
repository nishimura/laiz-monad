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

namespace Laiz\Func\Either;

use Laiz\Func\Either;
use function Laiz\Func\f;

function Left(...$args){
    if (count($args) === 1)
        return new Either\Left(...$args);

    return f(function($a){
        return new Either\Left($a);
    }, ...$args);
}
function Right(...$args){
    if (count($args) === 1)
        return new Either\Right(...$args);

    return f(function($a){
        return new Either\Right($a);
    }, ...$args);
}

function either(...$args){
    $f = function(callable $left, callable $right, Either $a){
        return $a->either($left, $right);
    };
    if (count($args) === 3)
        return $f(...$args);
    else
        return f($f, ...$args);
}

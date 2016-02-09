<?php

namespace Laiz\Func;

use Laiz\Func;
use Laiz\Func\Any;
use Laiz\Func\Unit;

Loader::load();

function c(callable $f){
    return new Func\Curry($f);
}

function f(callable $f, ...$args){
    if (!($f instanceof Func\Func))
        $f = new Func\Func($f);

    if ($args)
        $f = $f(...$args);
    return $f;
}


// Func
function compose(...$args)
{
    return f(function(callable $g, callable $f, $a){
        return $g($f($a));
    }, ...$args);
}
function id(...$args)
{
    return f(function($a){
        return $a;
    }, ...$args);
}
function cnst(...$args)
{
    return f(function($a, $b){
        return $a;
    }, ...$args);
}

function flip(...$args)
{
    return f(function(callable $f, $a, $b){
        return $f($b, $a);
    }, ...$args);
}

function map(...$args)
{
    return f(function(callable $f, $as){
        foreach ($as as $a)
            yield $f($a);
    }, ...$args);
}

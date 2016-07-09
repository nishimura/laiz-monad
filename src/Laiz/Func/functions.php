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

function filter(...$args)
{
    return f(function($f, $as){
        $ret = [];
        foreach ($as as $v){
            if ($f($v))
                $ret[] = $v;
        }
        return $ret;
    }, ...$args);
}

function foldl(...$args)
{
    return f(function($f, $a, $b){
        $ret = $a;
        foreach ($b as $v){
            $ret = $f($ret, $v);
        }
        return $ret;
    }, ...$args);
}

function foldr(...$args)
{
    $f = function($f, $a, $b){
        $ret = $a;
        for ($i = count($b) - 1; $i >= 0; $i--){
            $ret = $f($ret, $b[$i]);
        }
        return $ret;
    };
    if (count($args) === 3)
        return $f(...$args);
    else
        return f($f, ...$args);
}

function colon(...$args)
{
    $f = function($a, $as){
        array_unshift($as, $a);
        return $as;
    };
    if (count($args))
        return $f(...$args);
    else
        return f($f, ...$args);
}
function colonr(...$args)
{
    $f = function($a, $as){
        $as[] = $a;
        return $as;
    };
    if (count($args) === 2)
        return $f(...$args);
    else
        return f($f, ...$args);
}

function concat(...$args)
{
    return f(function($ass){
        $ret = [];
        foreach ($ass as $as){
            foreach ($as as $a){
                $ret[] = $a;
            }
        }
        return $ret;
    }, ...$args);
}

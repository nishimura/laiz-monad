<?php

namespace Laiz\Func;

function curry(callable $f)
{
    return new Curry($f);
}

function f(callable $f){
    return new Func($f);
}

function id()
{
    return f(function($a){
        return $a;
    });
}

function fmap(callable $f = null)
{
    $ret = f(function(callable $f, Functor $a){
        return $a->fmap($f);
    });
    if ($f !== null)
        $ret = $ret($f);
    return $ret;
}

function ap(Applicative $f = null)
{
    $ret = f(function (Applicative $f, Applicative $a){
        return $a->ap($f);
    });
    if ($f !== null)
        $ret = $ret($f);
    return $ret;
}

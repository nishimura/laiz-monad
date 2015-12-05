<?php

namespace Laiz\Func;

use Laiz\Monad;

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

function fmap(Functor $a = null, callable $f = null)
{
    $ret = f(function(Functor $a, callable $f){
        return $a->fmap($f);
    });
    if ($a !== null)
        $ret = $ret($a);
    if ($f !== null)
        $ret = $ret($f);
    return $ret;
}

function ap(Applicative $f = null, Applicative $a = null)
{
    $ret = f(function (Applicative $f, Applicative $a){
        return $a->ap($f);
    });
    if ($f !== null)
        $ret = $ret($f);
    if ($a !== null)
        $ret = $ret($a);
    return $ret;
}


function maybe($b = null, callable $f = null, Monad\Maybe $a = null)
{
    $ret = f(function($b, callable $f, Monad\Maybe $a){
        return $a->maybe($b, $f);
    });
    if ($b !== null)
        $ret = $ret($b);
    if ($f !== null)
        $ret = $ret($f);
    if ($a !== null)
        $ret = $ret($a);
    return $ret;
}

function fromMaybe($b = null, Monad\Maybe $a = null)
{
    $ret = f(function($b, Monad\Maybe $a){
        return $a->fromMaybe($b);
    });
    if ($b !== null)
        $ret = $ret($b);
    if ($a !== null)
        $ret = $ret($a);
    return $ret;
}

function Just($a)
{
    return new Monad\Maybe\Just($a);
}

function Nothing()
{
    return Monad\Maybe\Nothing::getInstance();
}

function Left($a)
{
    return new Monad\Either\Left($a);
}

function Right($a)
{
    return new Monad\Either\Right($a);
}

function either(callable $f = null, callable $g = null, Monad\Either $a = null)
{
    $ret = f(function(callable $f, callable $g, Monad\Either $a){
        return $a->either($f, $g);
    });
    if ($f !== null)
        $ret = $ret($f);
    if ($g !== null)
        $ret = $ret($g);
    if ($a !== null)
        $ret = $ret($a);
    return $ret;
}

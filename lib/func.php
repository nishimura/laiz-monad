<?php

use Laiz\Func\Curry;
use Laiz\Func\Functor;
use Laiz\Func\Applicative;
use Laiz\Monad\Monad;
use Laiz\Monad\Func;
use Laiz\Monad\Maybe;
use Laiz\Monad\Either;

function c(callable $f){
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

function cnst($a = null, $b = null)
{
    $ret = f(function($a, $b){
        return $a;
    });
    if ($a !== null)
        $ret = $ret($a);
    if ($b !== null)
        $ret = $ret($b);
    return $ret;
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


function maybe($b = null, callable $f = null, Maybe $a = null)
{
    $ret = f(function($b, callable $f, Maybe $a){
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

function fromMaybe($b = null, Maybe $a = null)
{
    $ret = f(function($b, Maybe $a){
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
    return new Maybe\Just($a);
}

function Nothing()
{
    return Maybe\Nothing::getInstance();
}

function Left($a)
{
    return new Either\Left($a);
}

function Right($a)
{
    return new Either\Right($a);
}

function either(callable $f = null, callable $g = null, Either $a = null)
{
    $ret = f(function(callable $f, callable $g, Either $a){
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

function liftM(callable $f = null, Monad $ma = null)
{
    $ret = f(function(callable $f, Monad $ma){
        return $ma->bind(function($a) use ($f, $ma){
            return $ma::ret($f($a));
        });
    });
    if ($f !== null)
        $ret = $ret($f);
    if ($ma !== null)
        $ret = $ret($ma);
    return $ret;
}

function liftM2(callable $f = null, Monad $ma = null, Monad $mb = null)
{
    $ret = f(function(callable $f, Monad $ma, Monad $mb){
        return $ma->bind(function($a) use ($f, $mb){
            return $mb->bind(function($b) use ($a, $f, $mb){
                return $mb::ret($f($a, $b));
            });
        });
    });
    if ($f !== null)
        $ret = $ret($f);
    if ($ma !== null)
        $ret = $ret($ma);
    if ($mb !== null)
        $ret = $ret($mb);
    return $ret;
}

function flip(callable $f = null, $a = null, $b = null){
    $ret = f(function(callable $f, $a, $b){
        return $f($b, $a);
    });
    if ($f !== null)
        $ret = $ret($f);
    if ($a !== null)
        $ret = $ret($a);
    if ($b !== null)
        $ret = $ret($b);
    return $ret;
}

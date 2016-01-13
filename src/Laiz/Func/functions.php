<?php

use Laiz\Func;
use Laiz\Func\Any;
use Laiz\Func\Unit;

Func\Loader::load();

function c(callable $f){
    return new Func\Curry($f);
}

function f(callable $f, ...$args){
    if (!($f instanceof Laiz\Func\Func))
        $f = new Laiz\Func\Func($f);

    if ($args)
        $f = $f(...$args);
    return $f;
}

function _callInstance($class, $method, ...$args)
{
    assert(method_exists($class, $method),
           "Method [$class#$method] not exists.");

    $method = [$class, $method];
    return $method(...$args);
}

function _typeToInstance($method){
    $methods = [
        'fmap' => 'Functor',
        'pure' => 'Applicative',
        'ap' => 'Applicative',
        'ret' => 'Monad',
        'bind' => 'Monad',
        'mempty' => 'Monoid',
        'mappend' => 'Monoid',
        'mzero' => 'MonadPlus',
        'mplus' => 'MonadPlus'
    ];
    return $methods[$method];
}
function _classToInstance($type, $method)
{
    $prefix = _typeToInstance($method);
    $type = preg_replace('/Laiz\\\\Func\\\\/', '', $type);
    if (preg_match('/((\\\\[[:alnum:]_]+){2})$/', $type, $matches))
        $type = ltrim($matches[1], '\\');
    $class = 'Laiz\Func\\' . $prefix . '\\' . $type;
    if (!class_exists($class)){
        $old = $class;
        $class = preg_replace('/\\\\[[:alnum:]_]+$/', '', $class);
        assert(class_exists($class),
               "Class [$old] and [$class] not exists.");
    }
    return $class;
}

function _callInstanceMethod($a, $method, ...$args)
{
    $prefix = _typeToInstance($method);
    if (!is_object($a)){
        $a = gettype($a);
        $a = ucfirst(strtolower($a));
        $a = 'Laiz\\Func\\' . $prefix . '\\Type' . $a;
    }else{
        $a = _classToInstance(get_class($a), $method);
    }
    return _callInstance($a, $method, ...$args);
}
function _callInstanceMethodString($type, $method, ...$args)
{
    return _callInstance(_classToInstance($type, $method), $method, ...$args);
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
    });
}

// Functor
// <$>
function fmap(...$args)
{
    return f(function(callable $f, $a){
        return _callInstanceMethod($a, 'fmap', $f, $a);
    }, ...$args);
}

function pure(...$args)
{
    return f(function($a){
        return new Any('pure', $a);
    }, ...$args);
}

// <$
function fconst(...$args)
{
    $ret = fmap()->compose(cnst());
    if ($args) $ret = $ret(...$args);
    return $ret;
}

// Applicative
// <*> (NOT monad's ap)
function ap(...$args)
{
    return f(function($f, $g){
        return _callInstanceMethod($f, 'ap', $f, $g);
    }, ...$args);
}


// Monad
function bind(...$args) {
    return f(function($m, callable $f){
        $ret = _callInstanceMethod($m, 'bind', $m, f($f));
        if ($ret instanceof Any)
            $ret = $ret->cast($m);
        return $ret;
    }, ...$args);
}
function ret(...$args) {
    return f(function($a){
        return new Any('ret', $a);
    }, ...$args);
}

// Monoid
function mappend(...$args) {
    return f(function($m1, $m2){
        if ($m1 instanceof Any &&
            !($m2 instanceof Any))
            $m1 = $m1->cast($m2);
        else if ($m2 instanceof Any &&
                 !($m1 instanceof Any))
            $m2 = $m2->cast($m1);
        return _callInstanceMethod($m1, 'mappend', $m1, $m2);
    }, ...$args);
}
function mempty() { return new Any('mempty'); }

// MonadPlus
function mplus(...$args) {
    return f(function($m1, $m2){
        if ($m1 instanceof Any &&
            !($m2 instanceof Any))
            $m1 = $m1->cast($m2);
        else if ($m2 instanceof Any &&
                 !($m1 instanceof Any))
            $m2 = $m2->cast($m1);
        return _callInstanceMethod($m1, 'mplus', $m1, $m2);
    }, ...$args);
}
function mzero() { return new Any('mzero'); }

function guard(...$args){
    return f(function($a){
        if ($a) return pure(new Unit());
        else return mzero();
    }, ...$args);
}



// Maybe
function Just(...$args)
{
    return f(function($a){
        return new Func\Maybe\Just($a);
    }, ...$args);
}
function Nothing()
{
    return new Func\Maybe\Nothing();
}

function fromMaybe(...$args)
{
    return f(function($a, Func\Maybe $m){
        if ($m instanceof Func\Maybe\Just)
            return $m->fromJust();
        else
            return $a;
    }, ...$args);
}

function maybe(...$args)
{
    return f(function($b, callable $f, Func\Maybe $m){
        if ($m instanceof Func\Maybe\Just)
            return $f($m->fromJust());
        else
            return $b;
    }, ...$args);
}


// Either
function Left(...$args){
    return f(function($a){
        return new Func\Either\Left($a);
    }, ...$args);
}
function Right(...$args){
    return f(function($a){
        return new Func\Either\Right($a);
    }, ...$args);
}

function either(...$args){
    return f(function(callable $left, callable $right, Func\Either $a){
        return $a->either($left, $right);
    }, ...$args);
}


// Writer
function tell(...$args)
{
    // Monoid w
    return f(function($w){
        return new Func\Writer(new Func\Unit(), $w);
    }, ...$args);
}

function runWriter(...$args)
{
    return f(function(Func\Writer $w){
        return [$w->a, $w->w];
    }, ...$args);
}

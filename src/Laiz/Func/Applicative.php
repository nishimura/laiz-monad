<?php

namespace Laiz\Func;

interface Applicative extends Functor
{
    public static function pure($a);
    public static function ap($f, $a);
}

namespace Laiz\Func\Applicative;

use Laiz\Func\Loader;
use Laiz\Func\Any;
use function Laiz\Func\f;
use function Laiz\Func\id;
use function Laiz\Func\cnst;
use function Laiz\Func\Functor\fconst;
use function Laiz\Func\Functor\fmap;

function pure(...$args)
{
    $f = function($a){
        return new Any('pure', $a);
    };
    if (count($args) === 1)
        return $f(...$args);
    else
        return f($f, ...$args);
}


// (<*>) :: Applicative f => f (a -> b) -> f a -> f b
// (NOT monad's ap)
function ap(...$args)
{
    $f = function($f, $g){
        return Loader::callInstanceMethod($f, 'ap', $f, $g);
    };
    if (count($args) === 2)
        return $f(...$args);
    else
        return f($f, ...$args);
}

// liftA2 :: Applicative f => (a -> b -> c) -> f a -> f b -> f c
function liftA2(...$args)
{
    $f = function($f, $a, $b){
        return ap(fmap($f, $a), $b);
    };
    if (count($args) === 3)
        return $f(...$args);
    else
        return f($f, ...$args);
}

// (<*) :: Applicative f => f a -> f b -> f a
function const1(...$args)
{
    $f = function($a, $b){
        return ap(fmap(cnst(), $a), $b);
    };
    if (count($args) === 2)
        return $f(...$args);
    else
        return f($f, ...$args);
}

// (*>) :: Applicative f => f a -> f b -> f b
function const2(...$args)
{
    $f = function($a1, $a2){
        return ap(fconst(id(), $a1), $a2);
    };
    if (count($args) === 2)
        return $f(...$args);
    else
        return f($f, ...$args);
}

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
    return f(function($a){
        return new Any('pure', $a);
    }, ...$args);
}


// (<*>) :: Applicative f => f (a -> b) -> f a -> f b
// (NOT monad's ap)
function ap(...$args)
{
    return f(function($f, $g){
        return Loader::callInstanceMethod($f, 'ap', $f, $g);
    }, ...$args);
}

// liftA2 :: Applicative f => (a -> b -> c) -> f a -> f b -> f c
function liftA2(...$args)
{
    return f(function($f, $a, $b){
        return ap(fmap($f, $a), $b);
    }, ...$args);
}

// (<*) :: Applicative f => f a -> f b -> f a
function const1(...$args)
{
    return f(function($a, $b){
        return ap(fmap(cnst(), $a), $b);
    }, ...$args);
}

// (*>) :: Applicative f => f a -> f b -> f b
function const2(...$args)
{
    return f(function($a1, $a2){
        return ap(fconst(id(), $a1), $a2);
    }, ...$args);
}

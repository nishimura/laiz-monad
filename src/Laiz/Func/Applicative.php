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
use function Laiz\Func\_callInstanceMethod;

function pure(...$args)
{
    return f(function($a){
        return new Any('pure', $a);
    }, ...$args);
}


// <*> (NOT monad's ap)
function ap(...$args)
{
    return f(function($f, $g){
        return Loader::callInstanceMethod($f, 'ap', $f, $g);
    }, ...$args);
}

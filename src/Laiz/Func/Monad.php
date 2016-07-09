<?php

namespace Laiz\Func;

interface Monad extends Applicative
{
    public static function bind($m, callable $f);
    public static function ret($a);
}

namespace Laiz\Func\Monad;

use Laiz\Func\Any;
use Laiz\Func\Loader;
use function Laiz\Func\f;
use function Laiz\Func\_callInstanceMethod;

function bind(...$args) {
    $f = function($m, callable $f){
        $ret = Loader::callInstanceMethod($m, 'bind', $m, f($f));
        if ($ret instanceof Any)
            $ret = $ret->cast($m);
        return $ret;
    };
    if (count($args) === 2)
        return $f(...$args);
    else
        return f($f,...$args);
}
function ret(...$args) {
    $f = function($a){
        return new Any('ret', $a);
    };
    if (count($args) === 1)
        return $f(...$args);
    else
        return f($f, ...$args);
}

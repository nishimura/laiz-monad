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
    return f(function($m, callable $f){
        $ret = Loader::callInstanceMethod($m, 'bind', $m, f($f));
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

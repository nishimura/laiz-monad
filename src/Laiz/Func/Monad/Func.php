<?php

namespace Laiz\Func\Monad;

use Laiz\Func\Applicative;
use Laiz\Func\Monad;
use Laiz\Func\Func as Instance;

class Func extends Applicative\Func implements Monad
{
    public static function bind($m, callable $f)
    {
        assert($m instanceof Instance, 'First argument must be Maybe');

        return f(function($f, $g, $a){
            return $g($f($a), $a);
        }, $m, $f);
    }

    public static function ret($a)
    {
        return f(function($_) use ($a) { return $a; });
    }
}

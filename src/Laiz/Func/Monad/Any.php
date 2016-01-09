<?php

namespace Laiz\Func\Monad;

use Laiz\Func\Applicative;
use Laiz\Func\Monad;
use Laiz\Func\Any as Instance;

class Any extends Applicative\Any implements Monad
{
    public static function bind($m, callable $f)
    {
        assert($m instanceof Instance, 'First argument must be Any');

        if ($m->value instanceof \Laiz\Func\Func){
            return f(function($a) use ($f) { return $f($a); });
        }else{
            return $f($m->value);
        }
    }

    public static function ret($a)
    {
        return new Instance('ret', $a);
    }
}

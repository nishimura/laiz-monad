<?php

namespace Laiz\Func\Monad;

use Laiz\Func\Applicative;
use Laiz\Func\Monad;

class TypeString extends Applicative\TypeString implements Monad
{
    public static function bind($m, callable $f)
    {
        assert(is_string($m), 'First argument must be string');

        $ret = '';
        $len = strlen($m);
        for ($i = 0; $i < $len; $i++){
            $ret .= $f($m[$i]);
        }
        return $ret;
    }

    public static function ret($a)
    {
        return $a;
    }
}

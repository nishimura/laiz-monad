<?php

namespace Laiz\Func\Monad;

use Laiz\Func\Applicative;
use Laiz\Func\Monad;

class TypeArray extends Applicative\TypeArray implements Monad
{
    public static function bind($m, callable $f)
    {
        assert(is_array($m), 'First argument must be array');

        $ret = [];
        foreach ($m as $a){
            foreach ($f($a) as $b){
                $ret[] = $b;
            }
        }

        return $ret;
    }

    public static function ret($a)
    {
        return [$a];
    }
}

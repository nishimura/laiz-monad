<?php

namespace Laiz\Func\Functor;

use Laiz\Func\Functor;

class TypeArray implements Functor
{
    public static function fmap(callable $f, $a)
    {
        assert(is_array($a), 'Second argument must be array');

        $ret = [];
        foreach ($a as $v){
            $ret[] = $f($v);
        }

        return $ret;
    }
}

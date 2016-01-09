<?php

namespace Laiz\Func\Functor;

use Laiz\Func\Functor;

class TypeString implements Functor
{
    public static function fmap(callable $f, $a)
    {
        assert(is_array($a), 'Second argument must be array');

        $len = strlen($a);
        $ret = '';
        for ($i = 0; $i < $len; $i++){
            $ret .= $f($a[$i]);
        }

        return $ret;
    }
}

<?php

namespace Laiz\Func\Applicative;

use Laiz\Func\Functor;
use Laiz\Func\Applicative;

class TypeArray extends Functor\TypeArray implements Applicative
{
    public static function pure($a)
    {
        return [$a];
    }
    public static function ap($mf, $a)
    {
        $ret = [];
        foreach ($mf as $f){
            foreach ($a as $v){
                $ret[] = $f($a);
            }
        }
        return $ret;
    }
}

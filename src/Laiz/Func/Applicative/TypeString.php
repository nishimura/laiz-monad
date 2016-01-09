<?php

namespace Laiz\Func\Applicative;

use Laiz\Func\Functor;
use Laiz\Func\Applicative;

class TypeString extends Functor\TypeString implements Applicative
{
    public static function pure($a)
    {
        return (string)$a;
    }
    public static function ap($mf, $a)
    {
        $ret = '';
        $len = strlen($a);
        foreach ($mf as $f){
            for ($i = 0; $i < $len; $i++){
                $ret .= $f($a[$i]);
            }
        }
        return $ret;
    }
}

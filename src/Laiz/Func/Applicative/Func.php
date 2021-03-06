<?php

namespace Laiz\Func\Applicative;

use Laiz\Func\Functor;
use Laiz\Func\Applicative;
use function Laiz\Func\cnst;
use function Laiz\Func\f;

class Func extends Functor\Func implements Applicative
{
    public static function pure($a)
    {
        return cnst($a);
    }
    public static function ap($f, $g)
    {
        return f(function($f, $g, $a){
            return $f($a, $g($a));
        }, $f, $g);
    }
}

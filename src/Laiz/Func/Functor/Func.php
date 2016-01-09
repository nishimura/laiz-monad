<?php

namespace Laiz\Func\Functor;

use Laiz\Func\Functor;

class Func implements Functor
{
    public static function fmap(callable $f, $a)
    {
        return compose($f, $a);
    }
}

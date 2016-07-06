<?php

namespace Laiz\Func\Functor;

use Laiz\Func\Functor;
use function Laiz\Func\compose;

class Func implements Functor
{
    public static function fmap(callable $f, $a)
    {
        return compose($f, $a);
    }
}

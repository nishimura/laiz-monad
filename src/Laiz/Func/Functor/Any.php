<?php

namespace Laiz\Func\Functor;

use Laiz\Func\Functor;

class Any implements Functor
{
    public static function fmap(callable $f, $a)
    {
        assert($a instanceof \Laiz\Func\Any, 'Second argument must be Any');

        return $a::op($a, \Laiz\Func\Any::FMAP, $f);
    }
}

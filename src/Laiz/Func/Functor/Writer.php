<?php

namespace Laiz\Func\Functor;

use Laiz\Func\Functor;
use Laiz\Func\Monad;
use Laiz\Func\Writer as Instance;

class Writer implements Functor
{
    public static function fmap(callable $f, $a)
    {
        assert($a instanceof Instance, 'Second argument must be Writer');

        return bind($a, function($inner) use ($f){
            return Monad\Writer::ret($f($inner));
        });
    }
}

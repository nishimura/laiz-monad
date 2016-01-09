<?php

namespace Laiz\Func\Functor;

use Laiz\Func\Functor;
use Laiz\Func\Maybe as Instance;

class Maybe implements Functor
{
    public static function fmap(callable $f, $a)
    {
        assert($a instanceof Instance, 'Second argument must be Maybe');

        if ($a instanceof Instance\Nothing)
            return $a;

        return new Instance\Just($f($a->fromJust()));
    }
}

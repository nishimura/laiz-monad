<?php

namespace Laiz\Func\Functor;

use Laiz\Func\Functor;
use Laiz\Func\Either as Instance;

class Either implements Functor
{
    public static function fmap(callable $f, $a)
    {
        assert($a instanceof Instance, 'Second argument must be Either');

        if ($a instanceof Instance\Left)
            return $a;

        return Right($f($a->value));
    }
}

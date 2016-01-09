<?php

namespace Laiz\Func\Monad;

use Laiz\Func\Applicative;
use Laiz\Func\Monad;
use Laiz\Func\Maybe as Instance;

class Maybe extends Applicative\Maybe implements Monad
{
    public static function bind($m, callable $f)
    {
        assert($m instanceof Instance, 'First argument must be Maybe');

        if ($m instanceof Instance\Just)
            $ret = $f($m->fromJust());
        else
            $ret = $m;

        assert($ret instanceof Instance, 'Return value must be Maybe');
        return $ret;
    }

    public static function ret($a)
    {
        return new Instance\Just($a);
    }
}

<?php

namespace Laiz\Func\Monad;

use Laiz\Func\Applicative;
use Laiz\Func\Monad;
use Laiz\Func\Either as Instance;

class Either extends Applicative\Either implements Monad
{
    public static function bind($m, callable $f)
    {
        assert($m instanceof Instance, 'First argument must be Either');

        if ($m instanceof Instance\Right)
            $ret = $f($m->value);
        else
            $ret = $m;

        assert($ret instanceof Instance, 'Return value must be Either');
        return $ret;
    }

    public static function ret($a)
    {
        return new Instance\Right($a);
    }
}

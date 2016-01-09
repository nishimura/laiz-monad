<?php

namespace Laiz\Func\Applicative;

use Laiz\Func\Functor;
use Laiz\Func\Applicative;
use Laiz\Func\Any as Instance;

class Any extends Functor\Any implements Applicative
{
    public static function pure($a)
    {
        return new Instance('pure', $a);
    }
    public static function ap($mf, $a)
    {
        return $mf::op($mf, 'ap', $a);
    }
}

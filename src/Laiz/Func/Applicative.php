<?php

namespace Laiz\Func;

interface Applicative extends Functor
{
    public static function pure($a);
    public static function ap($f, $a);
}

<?php

namespace Laiz\Func;

interface Monoid
{
    public static function mempty();
    public static function mappend($m1, $m2);
}

<?php

namespace Laiz\Func;

interface Functor
{
    public static function fmap(callable $f, $a);
}

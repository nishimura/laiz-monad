<?php

namespace Laiz\Func;

interface Monad extends Applicative
{
    public static function bind($m, callable $f);
    public static function ret($a);
}

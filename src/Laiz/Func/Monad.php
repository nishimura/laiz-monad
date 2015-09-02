<?php

namespace Laiz\Func;

interface Monad extends Applicative
{
    public static function ret($a);
    public function bind(Monad $m);
}

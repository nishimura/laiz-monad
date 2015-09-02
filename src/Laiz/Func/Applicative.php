<?php

namespace Laiz\Func;

interface Applicative extends Functor
{
    public static function pure($a);
    public function ap(Applicative $f, Applicative $a);
}

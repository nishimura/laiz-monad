<?php

namespace Laiz\Func;

interface MonadZero extends Applicative
{
    public static function mzero();
}

namespace Laiz\Func\MonadZero;

use Laiz\Func;
use function Laiz\Func\f;

function mzero() { return new Func\Any('mzero'); }

// (Applicative a, MonadZero a) => Bool -> m ()
function guard(...$args){
    return f(function($a){
        if ($a) return Func\Applicative\pure(new Func\Unit());
        else return Func\MonadZero\mzero();
    }, ...$args);
}

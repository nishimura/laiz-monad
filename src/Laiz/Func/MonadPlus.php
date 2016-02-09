<?php

namespace Laiz\Func;

interface MonadPlus extends Monad
{
    public static function mplus($m1, $m2);
}

namespace Laiz\Func\MonadPlus;

use Laiz\Func\Loader;
use Laiz\Func\Any;
use function Laiz\Func\f;
use function Laiz\Func\_callInstanceMethod;

function mplus(...$args) {
    return f(function($m1, $m2){
        if ($m1 instanceof Any &&
            !($m2 instanceof Any))
            $m1 = $m1->cast($m2);
        else if ($m2 instanceof Any &&
                 !($m1 instanceof Any))
            $m2 = $m2->cast($m1);
        return Loader::callInstanceMethod($m1, 'mplus', $m1, $m2);
    }, ...$args);
}

<?php

namespace Laiz\Func;

interface Functor
{
    public static function fmap(callable $f, $a);
}

namespace Laiz\Func\Functor;

use Laiz\Func\Loader;
use Laiz\Func\Any;
use function Laiz\Func\_callInstanceMethod;
use function Laiz\Func\f;
use function Laiz\Func\cnst;

// <$>
function fmap(...$args)
{
    return f(function(callable $f, $a){
        return Loader::callInstanceMethod($a, 'fmap', $f, $a);
    }, ...$args);
}

// <$
function fconst(...$args)
{
    $ret = fmap()->compose(cnst());
    if ($args) $ret = $ret(...$args);
    return $ret;
}

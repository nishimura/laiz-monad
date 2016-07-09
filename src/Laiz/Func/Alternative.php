<?php

namespace Laiz\Func;

interface Alternative
{
    public static function aempty();
    public static function aor($a, $b);
}


namespace Laiz\Func\Alternative;
use Laiz\Func\Loader;
use Laiz\Func\Any;
use function Laiz\Func\f;

function aempty(){
    return new Any('aempty');
}

function aor(...$args){
    $f = function($m1, $m2){
        if ($m1 instanceof Any &&
            !($m2 instanceof Any))
            $m1 = $m1->cast($m2);
        else if ($m2 instanceof Any &&
                 !($m1 instanceof Any))
            $m2 = $m2->cast($m1);
        return Loader::callInstanceMethod($m1, 'aor', $m1, $m2);
    };
    if (count($args) === 2)
        return $f(...$args);
    else
        return f($f, ...$args);
}

<?php

namespace Laiz\Func\Monad;

use Laiz\Func\Applicative;
use Laiz\Func\Monad;
use Laiz\Func\Writer as Instance;

class Writer extends Applicative\Writer implements Monad
{
    public static function bind($m, callable $f)
    {
        assert($m instanceof Instance, 'First argument must be Writer');

        $inner = $f($m->a);
        if ($inner instanceof \Laiz\Func\Any)
            $inner = $inner->cast($m);

        return new Instance($inner->a, mappend($m->w, $inner->w));
    }

    public static function ret(...$args)
    {
        return f(function($a){
            return new Instance($a, mempty());
        }, ...$args);
    }
}

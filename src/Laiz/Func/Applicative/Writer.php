<?php

namespace Laiz\Func\Applicative;

use Laiz\Func\Functor;
use Laiz\Func\Applicative;
use Laiz\Func\Writer as Instance;

class Writer extends Functor\Writer implements Applicative
{
    public static function pure($a)
    {
        return f(function($a){
            return new Instance($a, mempty());
        }, ...$args);
    }

    public static function ap($mf, $a)
    {
        return f(function(Instance $mf, Instance $a){
            return $mf->bind(function($f) use($a){
                return fmap($f, $a);
            });
        }, $mf, $a);
    }
}

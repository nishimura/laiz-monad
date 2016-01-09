<?php

namespace Laiz\Func\Applicative;

use Laiz\Func\Functor;
use Laiz\Func\Applicative;
use Laiz\Func\Maybe as Instance;

class Maybe extends Functor\Maybe implements Applicative
{
    public static function pure($a)
    {
        return new Instance\Just($a);
    }
    public static function ap($mf, $a)
    {
        if ($mf instanceof Instance\Just){
            $f = $mf->fromJust();
            return fmap($f, $a);
        }

        return new Instance\Nothing();
    }
}

<?php

namespace Laiz\Func\Applicative;

use Laiz\Func\Functor;
use Laiz\Func\Applicative;
use Laiz\Func\Either as Instance;

class Either extends Functor\Either implements Applicative
{
    public static function pure($a)
    {
        return Right($a);
    }
    public static function ap($mf, $a)
    {
        return f(function(Instance $mf, Instance $a){
            if ($mf instanceof Instance\Left ||
                $a instanceof Instance\Left)
                return $fm;

            $f = $mf->value;
            return Right($f($a->value));
        }, $mf, $a);
    }
}

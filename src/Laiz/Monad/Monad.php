<?php

namespace Laiz\Monad;

interface Monad
{
    /**
     * @param callable $f (a -> m b)
     * @return Laiz\Monad
     */
    public function bind(callable $f);

    /**
     * @param mixed $a
     * @return Laiz\Monad
     */
    public static function ret($a);

    /**
     * @param $a string
     * @return Laiz\Monad
     */
    public static function fail($a = null);

}

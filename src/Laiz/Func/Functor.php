<?php

namespace Laiz\Func;

interface Functor
{
    public function fmap(callable $f);
}

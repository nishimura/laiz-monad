<?php

namespace Laiz\Monad;

abstract class Maybe implements Monad, MonadPlus
{
    use MonadTrait;
    use MaybeTrait;

    /**
     * @param $a mixed
     * @return mixed
     */
    abstract public function fromMaybe($a);

    /**
     * @param $a mixed
     * @return mixed
     */
    abstract public function maybe($a, callable $f);
}

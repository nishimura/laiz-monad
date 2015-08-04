<?php

namespace Laiz\Monad\DataList;

use Laiz\Monad\MonadPlus;

class Nil extends \Laiz\Monad\DataList
{
    use \Laiz\Monad\SingletonTrait;

    /**
     * @return Laiz\Monad\DataList
     */
    public function bind(callable $f)
    {
        return $this;
    }

    /**
     * @return Laiz\Monad\DataList
     */
    public function mplus(MonadPlus $m)
    {
        if (!($m instanceof \Laiz\Monad\DataList))
            $this->fail();

        return $m;
    }

    public function map(callable $f)
    {
        return $this;
    }

    public function toArray()
    {
        return [];
    }
}

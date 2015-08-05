<?php

namespace Laiz\Monad\MonadList;

use Laiz\Monad\MonadPlus;

class Nil extends \Laiz\Monad\MonadList
{
    use \Laiz\Monad\SingletonTrait;

    private function __construct()
    {
        $this->value = new \EmptyIterator();
    }

    /**
     * @return Laiz\Monad\DataList
     */
    public function mplus(MonadPlus $m)
    {
        assert($m instanceof \Laiz\Monad\MonadList);

        return $m;
    }

    public function map(callable $f)
    {
        return $this;
    }
}

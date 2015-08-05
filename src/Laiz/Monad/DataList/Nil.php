<?php

namespace Laiz\Monad\DataList;

use Laiz\Monad\MonadPlus;

class Nil extends \Laiz\Monad\DataList
{
    use \Laiz\Monad\SingletonTrait;

    private function __construct()
    {
        $this->value = [];
    }

    /**
     * @return Laiz\Monad\DataList
     */
    protected function bindInternal(callable $f)
    {
        return $this;
    }

    /**
     * @return Laiz\Monad\DataList
     */
    public function mplus(MonadPlus $m)
    {
        assert($m instanceof \Laiz\Monad\DataList);

        return $m;
    }

    public function map(callable $f)
    {
        return $this;
    }

    public function toArray()
    {
        return $this->value;
    }
}

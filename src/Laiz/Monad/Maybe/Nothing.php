<?php

namespace Laiz\Monad\Maybe;

use Laiz\Monad\MonadPlus;

class Nothing extends \Laiz\Monad\Maybe
{
    use \Laiz\Monad\SingletonTrait;

    /**
     * @override
     * @return Laiz\Monad\Maybe
     */
    protected function bindInternal(callable $f)
    {
        return $this;
    }

    /**
     * @param $a mixed
     * @return mixed
     */
    public function fromMaybe($a)
    {
        return $a;
    }


    /**
     * @param $a mixed
     * @return mixed
     */
    public function maybe($a, callable $f)
    {
        return $a;
    }

    /**
     * @return Laiz\Monad\Maybe
     */
    public function mplus(MonadPlus $m)
    {
        assert($m instanceof \Laiz\Monad\Maybe);
        return $m;
    }
}

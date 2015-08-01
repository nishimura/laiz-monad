<?php

namespace Laiz\Monad\Maybe;

use Laiz\Monad\MonadPlus;

class Nothing extends \Laiz\Monad\Maybe
{
    use \Laiz\Monad\SingletonTrait;

    /**
     * @return Laiz\Monad\Maybe
     */
    public function bind(callable $f)
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
        if (!($m instanceof \Laiz\Monad\Maybe))
            $this->fail();

        return $m;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return '';
    }
}

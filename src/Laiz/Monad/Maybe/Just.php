<?php

namespace Laiz\Monad\Maybe;

use Laiz\Monad\MonadPlus;

class Just extends \Laiz\Monad\Maybe
{
    public function __construct($value)
    {
        if ($value === null)
            throw new \InvalidArgumentException('null is invalid');
        $this->value = $value;
    }

    /**
     * @override
     * @return Laiz\Monad\Maybe
     */
    protected function bindInternal(callable $f)
    {
        return $f($this->fromJust());
    }

    protected function fromJust()
    {
        return $this->value;
    }

    /**
     * @param $a mixed
     * @return mixed
     */
    public function fromMaybe($a)
    {
        return $this->fromJust();
    }

    /**
     * @param $a mixed
     * @return mixed
     */
    public function maybe($a, callable $f)
    {
        return $f($this->fromJust());
    }


    /**
     * @return Laiz\Monad\Maybe
     */
    public function mplus(MonadPlus $m)
    {
        assert($m instanceof \Laiz\Monad\Maybe);
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->fromJust();
    }
}

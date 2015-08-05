<?php

namespace Laiz\Monad;

trait MonadTrait
{
    use ControlTrait;

    protected $value;

    public function bind(callable $f)
    {
        $ret = $this->bindInternal($f);
        assert($ret instanceof self);
        return $ret;
    }

    abstract protected function bindInternal(callable $f);
}

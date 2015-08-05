<?php

namespace Laiz\Monad;

trait MonadTrait
{
    use ControlTrait;

    protected $value;

    public function bind(callable $f)
    {
        $ret = $this->bindInternal($f);
        assert($ret instanceof self, 'bind callback must return monad instance');
        return $ret;
    }

    abstract protected function bindInternal(callable $f);
}

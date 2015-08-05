<?php

namespace Laiz\Monad;

abstract class Either implements Monad
{
    use MonadTrait;
    use EitherTrait;

    /**
     * @param mixed
     */
    public function __construct($value)
    {
        $this->value = $value;
    }
}

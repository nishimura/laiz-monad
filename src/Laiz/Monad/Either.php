<?php

namespace Laiz\Monad;

abstract class Either implements Monad
{
    use MonadTrait;

    /**
     * @param mixed
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    public static function ret($a)
    {
        if ($a === null)
            throw new \InvalidArgumentException('null is invalid');

        return new Either\Right($a);
    }

    /**
     * @param $a string
     */
    public static function fail($a = null)
    {
        return new Either\Left($a);
    }

}

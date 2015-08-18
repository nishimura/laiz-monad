<?php

namespace Laiz\Monad;

trait EitherTrait
{
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

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->value;
    }
}

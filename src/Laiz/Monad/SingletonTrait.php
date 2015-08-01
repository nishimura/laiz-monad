<?php

namespace Laiz\Monad;

trait SingletonTrait
{
    private function __construct()
    {
    }

    public static function getInstance()
    {
        static $instance;
        if ($instance === null)
            $instance = new static();

        return $instance;
    }
}

<?php

namespace Laiz\Func;

trait CallTrait
{
    public function __call($name, $args)
    {
        assert(function_exists($name), "Undefined method [$name]");

        $methods = [
            'ret',
            'mempty',
            'mzero',
            'pure'
        ];

        if (in_array($name, $methods)){
            return _callInstanceMethod($this, $name, ...$args);
        }

        array_unshift($args, $this);
        return $name(...$args);
    }
}

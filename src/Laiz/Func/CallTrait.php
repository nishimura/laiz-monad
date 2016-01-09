<?php

namespace Laiz\Func;

trait CallTrait
{
    public function __call($name, $args)
    {
        assert(function_exists($name), "Undefined method [$name]");

        $methods = [
            'ret' => 'Monad',
            'mempty' => 'Monoid',
            'mzero' => 'MonadPlus',
            'pure' => 'Applicative'
        ];

        if (array_key_exists($name, $methods)){
            return _callInstance($this, $methods[$name], $name, ...$args);
        }

        array_unshift($args, $this);
        return $name(...$args);
    }
}

<?php

namespace Laiz\Func;

use Laiz\Func\Any;
use Laiz\Func\Loader;
use Laiz\Func\_callInstanceMethod;

trait CallTrait
{
    public function __call($name, $args)
    {
        $methods = [
            'ret',
            'mempty',
            'mzero',
            'pure'
        ];

        // $self = $this;
        // if ($self instanceof Any &&
        //     isset($args[0]) &&
        //     !($args[0] instanceof Any))
        //     $self = $self->cast($args[0]);
        // else if (isset($args[0]) &&
        //          $args[0] instanceof Any &&
        //          !($self instanceof Any))
        //     $args[0] = $args[0]->cast($self);

        if (in_array($name, $methods)){
            return Loader::callFunction($name, ...$args);
        }

        array_unshift($args, $this);
        return Loader::callFunction($name, ...$args);
    }
}

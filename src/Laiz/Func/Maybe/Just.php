<?php

namespace Laiz\Func\Maybe;

use Laiz\Func\Maybe;

class Just extends Maybe
{
    public function fromJust()
    {
        return $this->value;
    }
}

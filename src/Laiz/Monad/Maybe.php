<?php

namespace Laiz\Monad;

abstract class Maybe implements Monad, MonadPlus
{
    use MaybeTrait;
}

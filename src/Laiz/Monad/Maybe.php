<?php

namespace Laiz\Monad;

abstract class Maybe implements Monad, MonadPlus
{
    use MonadTrait;
    use MaybeTrait;
}

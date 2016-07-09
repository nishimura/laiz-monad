<?php

namespace Laiz\Func;

abstract class Maybe
{
    use CallTrait;

    protected $value;
    public function __construct($a)
    {
        $this->value = $a;
    }
}

namespace Laiz\Func\Maybe;
use Laiz\Func\Maybe;
use function Laiz\Func\f;

function Just(...$args)
{
    if (count($args) === 1)
        return new Maybe\Just(...$args);

    return f(function($a){
        return new Maybe\Just($a);
    }, ...$args);
}
function Nothing()
{
    return new Maybe\Nothing();
}

function fromMaybe(...$args)
{
    return f(function($a, Maybe $m){
        if ($m instanceof Maybe\Just)
            return $m->fromJust();
        else
            return $a;
    }, ...$args);
}

function maybe(...$args)
{
    return f(function($b, callable $f, Maybe $m){
        if ($m instanceof Maybe\Just)
            return $f($m->fromJust());
        else
            return $b;
    }, ...$args);
}

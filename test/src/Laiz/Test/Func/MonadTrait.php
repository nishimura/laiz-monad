<?php

namespace Laiz\Test\Func;

use Laiz\Func\Monad;

trait MonadTrait
{
    /**
     * @return Laiz\Monad\Monad
     */
    abstract public function getMonad();

    public function testMonadContext()
    {
        $c = $this->getMonad();
        $this->assertInstanceOf('Laiz\Func\Monad', $c);
        return $c;
    }

    /**
     * return a >>= f == f a
     * @depends testMonadContext
     */
    public function testMonadLaw1(Monad $c)
    {
        $f = function($a) use ($c) { return $c::ret($a * 3); };
        $l = $c::ret(5)->bind($f);
        $r = $f(5);

        $this->assertEquals($l, $r);

        return $c;
    }

    /**
     * m >>= return == m
     * @depends testMonadLaw1
     */
    public function testMonadLaw2(Monad $c)
    {
        $m = $c::ret(5);
        $l = $m->bind(function($a) use ($c){ return $c::ret($a); });

        $this->assertEquals($l, $m);

        return $c;
    }

    /**
     * (m >>= f) >>= g == m >>= (\x -> f x >>= g)
     * @depends testMonadLaw2
     */
    public function testMonadLaw3(Monad $c)
    {
        $f = function($a) use ($c) { return $c::ret($a * 3); };
        $g = function($a) use ($c) { return $c::ret($a * 5); };
        $m = $c::ret(7);

        $l = $m->bind($f)->bind($g);
        $r = $m->bind(function($a) use ($f, $g){ return $f($a)->bind($g); });

        $this->assertEquals($l, $r);

        return $c;
    }
}

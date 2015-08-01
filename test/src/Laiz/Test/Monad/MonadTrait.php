<?php

namespace Laiz\Test\Monad;

use Laiz\Monad;
use Laiz\Monad\Context;

trait MonadTrait
{
    /**
     * @return object using Laiz\Monad\Context
     */
    abstract public function getMonadContext();

    public function testMonadContext()
    {
        $c = $this->getMonadContext();
        $this->assertInstanceOf('Laiz\Monad\Context', $c);
        return $c;
    }

    /**
     * return a >>= f == f a
     * @depends testMonadContext
     */
    public function testLaw1(Context $c)
    {
        $f = function($a) use ($c) { return $c->ret($a * 3); };
        $l = $c->ret(5)->bind($f);
        $r = $f(5);

        $this->assertEquals($l, $r);

        return $c;
    }

    /**
     * m >>= return == m
     * @depends testLaw1
     */
    public function testLaw2(Context $c)
    {
        $m = $c->ret(5);
        $l = $m->bind(function($a) use ($c){ return $c->ret($a); });

        $this->assertEquals($l, $m);

        return $c;
    }

    /**
     * (m >>= f) >>= g == m >>= (\x -> f x >>= g)
     * @depends testLaw2
     */
    public function testLaw3(Context $c)
    {
        $f = function($a) use ($c) { return $c->ret($a * 3); };
        $g = function($a) use ($c) { return $c->ret($a * 5); };
        $m = $c->ret(7);

        $l = $m->bind($f)->bind($g);
        $r = $m->bind(function($a) use ($f, $g){ return $f($a)->bind($g); });

        $this->assertEquals($l, $r);

        return $c;
    }
}

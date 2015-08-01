<?php

namespace Laiz\Test\Monad;

use Laiz\Monad\Maybe;
use Laiz\Monad\MaybeContext;
use Laiz\Monad\Maybe\Just;

class MaybeTest extends \PHPUnit_Framework_TestCase
{
    use MonadTrait;
    use MonadPlusTrait;

    /**
     * @override
     */
    public function getMonadContext()
    {
        return new MaybeContext();
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testNull()
    {
        $c = $this->getMonadContext();
        $c->ret(null);
    }

    public function testFromMaybe()
    {
        $c = $this->getMonadContext();
        $z = $c->mzero();
        $m = $c->ret(2);

        $this->assertEquals(5, $z->fromMaybe(5));
        $this->assertEquals(2, $m->fromMaybe(5));
    }

    public function testMaybe()
    {
        $c = $this->getMonadContext();
        $z = $c->mzero();
        $m = $c->ret(2);

        $f = function ($a) { return $a * 3; };

        $this->assertEquals(5, $z->maybe(5, $f));
        $this->assertEquals(6, $m->maybe(5, $f));
    }

    public function testChain1()
    {
        $c = $this->getMonadContext();

        $m1 = $c->ret(2);
        $f1 = function($a) use($c) { return $c->ret($a * 3); };
        $f2 = function($a) use($c) { return $c->mzero(); };
        $f3 = function($a) use($c) { return $c->ret($a * 5); };

        $this->assertEquals(new Just(6), $m1->bind($f1));
        $this->assertSame($c->mzero(), $m1->bind($f1)->bind($f2));
        $this->assertEquals(new Just(30), $m1->bind($f1)->bind($f3));
        $this->assertSame($c->mzero(), $m1->bind($f1)->bind($f2)->bind($f3));
    }
}

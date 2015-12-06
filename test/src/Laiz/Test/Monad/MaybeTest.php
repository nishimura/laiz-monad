<?php

namespace Laiz\Test\Monad;

use Laiz\Monad\Maybe;
use Laiz\Monad\Maybe\Just;

\Laiz\Monad\Func::importUtil();

class MaybeTest extends \PHPUnit_Framework_TestCase
{
    use MonadTrait;
    use MonadPlusTrait;
    use ControlTrait;

    /**
     * @override
     */
    public function getMonadContext()
    {
        return Maybe::mzero();
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testNull()
    {
        $c = $this->getMonadContext();
        $c::ret(null);
    }

    public function testFromMaybe()
    {
        $c = $this->getMonadContext();
        $z = $c::mzero();
        $m = $c::ret(2);

        $this->assertEquals(5, $z->fromMaybe(5));
        $this->assertEquals(2, $m->fromMaybe(5));
    }

    public function testMaybe()
    {
        $c = $this->getMonadContext();
        $z = $c::mzero();
        $m = $c::ret(2);

        $f = function ($a) { return $a * 3; };

        $this->assertEquals(5, $z->maybe(5, $f));
        $this->assertEquals(6, $m->maybe(5, $f));
    }

    public function testChain1()
    {
        $c = $this->getMonadContext();

        $m1 = $c::ret(2);
        $f1 = function($a) use($c) { return $c::ret($a * 3); };
        $f2 = function($a) use($c) { return $c::mzero(); };
        $f3 = function($a) use($c) { return $c::ret($a * 5); };

        $this->assertEquals(new Just(6), $m1->bind($f1));
        $this->assertSame($c->mzero(), $m1->bind($f1)->bind($f2));
        $this->assertEquals(new Just(30), $m1->bind($f1)->bind($f3));
        $this->assertSame($c->mzero(), $m1->bind($f1)->bind($f2)->bind($f3));
    }

    public function testFmap()
    {
        $c = $this->getMonadContext();

        $m1 = $c::ret(3);
        $f1 = function($a){ return $a + 1; };
        $this->assertEquals(new Just(4), $m1->fmap($f1));
        $this->assertEquals(new Just(4), fmap($m1, $f1));

        $f2 = f(function($a, $b){ return $a + $b; });
        $mf = $m1->fmap($f2);
        $this->assertInstanceOf('Laiz\Monad\Maybe', $mf);
        $a = $mf->fmap(function($f){
            return $f(4);
        });
        $this->assertEquals(new Just(7), $a);

        $m2 = $c::ret(2);
        $this->assertEquals(new Just(5), ap($mf, $m2));
    }

    public function testFuncMaybe()
    {
        $z = Nothing();
        $m = Just(2);

        $f = function ($a) { return $a * 3; };

        $this->assertEquals(5, maybe(5, $f, $z));
        $this->assertEquals(6, maybe(5, $f, $m));

        $fromMaybe = fromMaybe(5);
        $this->assertEquals(5, $fromMaybe($z));
        $this->assertEquals(2, $fromMaybe($m));
    }
}

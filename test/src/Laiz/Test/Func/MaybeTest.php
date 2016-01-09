<?php
namespace Laiz\Test\Func;

use Laiz\Func;

class MaybeTest extends \PHPUnit_Framework_TestCase
{
    use MonadTrait;
    public function getMonad() { return new Func\Monad\Maybe(); }
    use MonadPlusTrait;
    public function getMonadPlus() { return new Func\MonadPlus\Maybe(); }

    public function testInstance()
    {
        $m = Func\Monad\Maybe::ret(1);
        $this->assertInstanceOf('Laiz\Func\Maybe', $m);
        $this->assertInstanceOf('Laiz\Func\Maybe\Just', $m);

        $m = Just(1);
        $this->assertInstanceOf('Laiz\Func\Maybe\Just', $m);

        $m = new Func\Maybe\Just(1);
        $this->assertInstanceOf('Laiz\Func\Maybe\Just', $m);

        $m = Nothing();
        $this->assertInstanceOf('Laiz\Func\Maybe\Nothing', $m);
        $m = new Func\Maybe\Nothing();
        $this->assertInstanceOf('Laiz\Func\Maybe\Nothing', $m);
    }

    public function testBind()
    {
        $m = Just(3);
        $f = function($a){ return Just($a + 2); };
        $m1 = bind($m, $f);
        $this->assertEquals(new Func\Maybe\Just(5), $m1);

        $m2 = $m->bind($f);
        $this->assertEquals(Just(5), $m2);

        $m3 = $m->bind(function($_){ return Nothing(); });
        $this->assertEquals(Nothing(), $m3);
    }


    public function testFromMaybe()
    {
        $z = Nothing();
        $m = Just(2);

        $this->assertEquals(5, fromMaybe(5, $z));
        $this->assertEquals(2, fromMaybe(5, $m));
    }

    public function testMaybe()
    {
        $z = Nothing();
        $m = Just(2);

        $f = function ($a) { return $a * 3; };

        $this->assertEquals(5, maybe(5, $f, $z));
        $this->assertEquals(6, maybe(5, $f, $m));
    }

    public function testChain1()
    {
        $m1 = Just(2);
        $f1 = function($a) { return Just($a * 3); };
        $f2 = function($a) { return Nothing(); };
        $f3 = function($a) { return Just($a * 5); };

        $this->assertEquals(Just(6), $m1->bind($f1));
        $this->assertEquals(Nothing(), $m1->bind($f1)->bind($f2));
        $this->assertEquals(Just(30), $m1->bind($f1)->bind($f3));
        $this->assertEquals(Nothing(), $m1->bind($f1)->bind($f2)->bind($f3));
    }

    public function testFmap()
    {
        $m1 = Just(3);
        $f1 = function($a){ return $a + 1; };
        $this->assertEquals(Just(4), fmap($f1, $m1));

        $f2 = f(function($a, $b){ return $a + $b; });
        $mf = fmap($f2, $m1);
        $this->assertInstanceOf('Laiz\Func\Maybe', $mf);
        $a = fmap(function($f){
            return $f(4);
        }, $mf);
        $this->assertEquals(Just(7), $a);

        $m2 = Just(2);
        $this->assertEquals(Just(5), ap($mf, $m2));
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

    public function testFconst()
    {
        $this->assertEquals(Just(1), fconst(1, Just(2)));
        $this->assertEquals(Nothing(), fconst(1, Nothing()));
    }
}

<?php

namespace Laiz\Test\Func;

use Laiz\Func\Func;

\Laiz\Func\Loader::load();

class FuncTest extends \PHPUnit_Framework_TestCase
{
    // Func and Curry test

    public function testInstance()
    {
        $f = f(function($a){ return $a; });
        $this->assertInstanceOf('Laiz\Func\Func', $f);
    }

    /**
     * fmap id == id
     */
    public function testFunctorLaw1()
    {
        $id = id();
        $a = f(function($a){ return $a + 1; });

        $left = fmap($id);
        $right = $id;

        $this->assertEquals(4, $left($a)->apply(3));
        $this->assertEquals($left($a)->apply(3), $right($a)->apply(3));
    }

    /**
     * fmap (f . g) == fmap f . fmap g
     */
    public function testFunctorLaw2()
    {
        $f = f(function($a){ return "ret $a"; });
        $g = f(function($a){ return $a * 3; });

        $left = fmap($f->compose($g));
        $right = fmap($f)->compose(fmap($g));

        $a = f(function($a){ return $a - 3; });

        $this->assertEquals('ret 24', $left($a, 11));
        $this->assertEquals($left($a)->apply(11), $right($a)->apply(11));
    }

    public function testPure()
    {
        $f = \Laiz\Func\Applicative\Func::pure(3);

        $this->assertEquals(3, $f(0));
        $this->assertEquals(3, $f(5));
    }

    public function testAp()
    {
        $f = f(function($a, $b){ return $a - $b; });
        $ret = $f->ap(function($a){ return $a + 2; });
        $this->assertEquals(-2, $ret(4));
    }
}

<?php

namespace Laiz\Test\Monad;

use Laiz\Monad\Func;

Func::importUtil();

class FuncTest extends \PHPUnit_Framework_TestCase
{
    use \Laiz\Test\Monad\MonadTrait;

    protected function getMonadContext()
    {
        return Func::ret(1);
    }

    /**
     * fmap id == id
     */
    public function testFuncLaw1()
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
    public function testFuncLaw2()
    {
        $f = f(function($a){ return "ret $a"; });
        $g = f(function($a){ return $a * 3; });

        $left = fmap($f->compose($g));
        $right = fmap($f)->compose(fmap($g));

        $a = f(function($a){ return $a - 3; });

        $this->assertEquals('ret 24', $left($a, 11));
        $this->assertEquals($left($a)->apply(11), $right($a)->apply(11));
    }
}

<?php

namespace Laiz\Test\Func;

use Laiz\Func;

class FuncTest extends \PHPUnit_Framework_TestCase
{
    /**
     * fmap id == id
     */
    public function testLaw1()
    {
        $id = Func\id();
        $a = Func\f(function($a){ return $a + 1; });

        $left = Func\fmap($id);
        $right = $id;

        $this->assertEquals($left($a)->apply(3), $right($a)->apply(3));
    }

    /**
     * fmap (f . g) == fmap f . fmap g
     */
    public function testLaw2()
    {
        $f = Func\f(function($a){ return $a + 7; });
        $g = Func\f(function($a){ return $a + 11; });

        $left = Func\fmap($f->compose($g));
        $right = Func\fmap($f)->compose(Func\fmap($g));

        $a = Func\f(function($a){ return $a + 3; });

        $this->assertEquals($left($a)->apply(17), $right($a)->apply(17));
    }
}

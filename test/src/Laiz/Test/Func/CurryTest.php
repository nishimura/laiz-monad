<?php

namespace Laiz\Test\Func;

use function Laiz\Func\c;

class CurryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testNull()
    {
        try {
            $f = c();
        }catch (\TypeError $e){
            // PHP7
            trigger_error($e->getMessage(), E_USER_ERROR);
        }
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testInvalid()
    {
        try {
            $f = c(1);
        }catch (\TypeError $e){
            // PHP7
            trigger_error($e->getMessage(), E_USER_ERROR);
        }
    }

    public function testInstance()
    {
        $f = c(function($a){return $a;});
        $this->assertInstanceOf('Laiz\Func\Curry', $f);
    }

    public function testCurry()
    {
        $f = c(function($a){ return $a + 1; });
        $this->assertEquals($f(3), 4);

        $f1 = c(function($a, $b){ return $a + $b + 1; });
        $f2 = $f1(2);
        $this->assertEquals($f2(3), 6);

        $f1 = c(function($a, $b, $c){ return $a + $b + $c + 1; });
        $f2 = $f1(2);
        $f3 = $f2(3);
        $this->assertEquals($f3(4), 10);
    }

    public function testInvoke()
    {
        $f = c(function($a, $b, $c){
            return [$a, $b, $c];
        });
        $this->assertInstanceOf('Laiz\Func\Curry', $f);
        $f1 = $f(1);
        $this->assertInstanceOf('Laiz\Func\Curry', $f1);
        $f2 = $f1(2);
        $this->assertInstanceOf('Laiz\Func\Curry', $f2);

        $this->assertEquals($f(1, 2, 3), [1, 2, 3]);
        $this->assertEquals($f2(3), [1, 2, 3]);
        $this->assertEquals($f1(2, 3), [1, 2, 3]);
    }

    public static function staticFunc($a){}
    public function testStaticString()
    {
        $f = c('Laiz\Test\Func\CurryTest::staticFunc');
        $this->assertInstanceOf('Laiz\Func\Curry', $f);
    }
    public function testStaticArray()
    {
        $f = c(['Laiz\Test\Func\CurryTest','staticFunc']);
        $this->assertInstanceOf('Laiz\Func\Curry', $f);
    }

    public function testReferentialTransparency()
    {
        $f = c(function($a, $b, $c){
            return $a + $b + $c;
        });
        $f1 = $f(5);
        $f2 = $f1(8);
        $this->assertEquals(213, $f2(200));

        $f3 = $f1(9);
        $this->assertEquals(213, $f2(200));
        $this->assertEquals(214, $f3(200));

        $tmp = $f(-100);
        $this->assertEquals(213, $f2(200));
        $this->assertEquals(214, $f3(200));
    }
}

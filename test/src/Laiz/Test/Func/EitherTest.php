<?php

namespace Laiz\Test\Func;

use Laiz\Func;
use function Laiz\Func\Either\Right;
use function Laiz\Func\Either\Left;
use function Laiz\Func\Either\either;

class EitherTest extends \PHPUnit_Framework_TestCase
{
    public function testChain1()
    {
        $f = function($a){ return $a >= 5 ? Right($a) : Left('under 5'); };
        $g = function($a){ return $a <= 10 ? Right($a) : Left('over 10'); };

        $a = Right(7);
        $this->assertEquals($a, $a->bind($f)->bind($g));

        $a = Right(3);
        $this->assertEquals(Left('under 5'), $a->bind($f)->bind($g));

        $a = Right(11);
        $this->assertEquals(Left('over 10'), $a->bind($f)->bind($g));
    }

    public function testNull()
    {
        $a = Right(null);
        $this->assertEquals(Right(new Func\Unit()), $a);
    }

    public function testEither()
    {
        $left = function($v){ return 'error [' . (string)$v . ']'; };
        $right = function($v){ return $v * 2; };

        $this->assertEquals(Right(3)->either($left, $right), 6);
        $this->assertEquals(Left(3)->either($left, $right), 'error [3]');
    }

    public function testFunc()
    {
        $left = Left(['error1']);
        $this->assertInstanceOf('Laiz\Func\Either\Left', $left);

        $right = Right(5);
        $this->assertInstanceOf('Laiz\Func\Either\Right', $right);

        $f = function($left){ return array_merge($left,['error2']); };
        $g = function($right){ return $right + 11; };

        $either = either($f, $g);
        $this->assertEquals(['error1', 'error2'], $either($left));
        $this->assertEquals(16, $either($right));
    }
}

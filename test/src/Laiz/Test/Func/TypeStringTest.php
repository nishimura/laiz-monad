<?php
namespace Laiz\Test\Func;

use function Laiz\Func\Monad\bind;
use function Laiz\Func\Monoid\mappend;

class TypeStringTest extends \PHPUnit_Framework_TestCase
{
    public function testBind()
    {
        $m = 'abc';
        $f = function($a){ return $a . ','; };
        $m1 = bind($m, $f);
        $this->assertEquals('a,b,c,', $m1);
    }

    public function testAppend()
    {
        $m1 = 'abc';
        $m2 = 'def';
        $m = mappend($m1, $m2);
        $this->assertEquals('abcdef', $m);

    }
}

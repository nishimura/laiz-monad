<?php
namespace Laiz\Test\Func;

use Laiz\Func;

Func\Loader::load();

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

<?php
namespace Laiz\Test\Func;

use Laiz\Func;
use function Laiz\Func\Monoid\mappend;
use function Laiz\Func\Monoid\mempty;

class UnitTest extends \PHPUnit_Framework_TestCase
{
    public function testAppend()
    {
        $m = new Func\Unit();
        $m = mappend(new Func\Unit(), new Func\Unit());
        $this->assertEquals(new Func\Unit(), $m);

        $this->assertEquals(new Func\Unit(), mappend($m, mempty()));
        $this->assertEquals(new Func\Unit(), mempty()->mappend(mempty())->mappend($m));
    }
}

<?php

namespace Laiz\Test\Monad;

use Laiz\Monad;
use Laiz\Monad\Context;

trait ControlTrait
{
    /**
     * (Monad m) => m (m a) -> m a
     * @depends testMonadContext
     */
    public function testJoin(Context $c)
    {
        $ma = $c->ret(2);
        $mma = $c->ret($ma);

        $this->assertEquals($ma, $mma->join());

        return $c;
    }

    /**
     * @depends testJoin
     * @expectedException PHPUnit_Framework_Error
     * @expectedExceptionMessage Assertion failed
     */
    public function testJoinException1(Context $c)
    {
        $ma = $c->ret(2);
        $ma->join();
    }

    /**
     * @depends testJoin
     * @expectedException PHPUnit_Framework_Error
     * @expectedExceptionMessage Assertion failed
     */
    public function testJoinException2(Context $c)
    {
        $ma = $c->fail();
        $ma->join();
    }
}

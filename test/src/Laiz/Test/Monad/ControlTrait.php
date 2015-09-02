<?php

namespace Laiz\Test\Monad;

use Laiz\Monad\Monad;

trait ControlTrait
{
    /**
     * (Monad m) => m (m a) -> m a
     * @depends testMonadContext
     */
    public function testJoin(Monad $c)
    {
        $ma = $c::ret(2);
        $mma = $c::ret($ma);

        $this->assertEquals($ma, $mma->join());

        return $c;
    }

    /**
     * @depends testJoin
     * @expectedException PHPUnit_Framework_Error
     */
    public function testJoinException1(Monad $c)
    {
        $ma = $c::ret(2);
        $ma->join();
    }

    /**
     * @depends testJoin
     * @expectedException PHPUnit_Framework_Error
     */
    public function testJoinException2(Monad $c)
    {
        $ma = $c::fail();
        $ma->join();
    }
}

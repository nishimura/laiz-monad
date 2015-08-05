<?php

namespace Laiz\Test\Monad;

use Laiz\Monad\DataList;
use Laiz\Monad\DataListContext;
use Laiz\Monad\DataList\Cons;
use Laiz\Monad\DataList\Nil;

class DataListTest extends \PHPUnit_Framework_TestCase
{
    use MonadTrait;
    use MonadPlusTrait;
    use ControlTrait;

    /**
     * @override
     */
    public function getMonadContext()
    {
        return new DataListContext();
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testNull()
    {
        $c = $this->getMonadContext();
        $z = $c->ret(null);
    }

    public function testMplus()
    {
        $c = $this->getMonadContext();
        $m1 = Cons::fromArray([1, 2, 3]);
        $m2 = Cons::fromArray([4, 5, 6]);

        $this->assertEquals(Cons::fromArray([1,2,3,4,5,6]),
                            $m1->mplus($m2));
    }

    public function testDoubleBind()
    {
        $c = $this->getMonadContext();
        $m1 = Cons::fromArray([1, 2, 3]);
        $m2 = Cons::fromArray([4, 5, 6]);

        $ret = $m1->bind(function($a) use($c, $m2){
            return $m2->bind(function($b) use($c, $a){
                return $c->ret([$a, $b]);
            });
        });

        $this->assertEquals(Cons::fromArray([[1, 4], [1, 5], [1, 6],
                                             [2, 4], [2, 5], [2, 6],
                                             [3, 4], [3, 5], [3, 6]]),
                            $ret);
    }
}

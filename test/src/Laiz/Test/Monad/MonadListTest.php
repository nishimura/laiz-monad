<?php

namespace Laiz\Test\Monad;

use Laiz\Monad\MonadList;
use Laiz\Monad\MonadList\Cons;

class MonadListTest extends \PHPUnit_Framework_TestCase
{
    use MonadTrait;
    use MonadPlusTrait;
    use ControlTrait;

    /**
     * @override
     */
    public function getMonadContext()
    {
        return MonadList::mzero();
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testNull()
    {
        $c = $this->getMonadContext();
        $z = $c::ret(null);
    }

    public function testMplus()
    {
        $c = $this->getMonadContext();
        $m1 = MonadList::cast([1, 2, 3]);
        $m2 = MonadList::cast([4, 5, 6]);

        $this->assertEquals([1,2,3,4,5,6],
                            $m1->mplus($m2)->toArray());
    }

    public function testDoubleBind()
    {
        $c = $this->getMonadContext();
        $m1 = MonadList::cast([1, 2, 3]);
        $m2 = MonadList::cast([4, 5, 6]);

        $ret = $m1->bind(function($a) use($c, $m2){
            return $m2->bind(function($b) use($c, $a){
                return $c::ret([$a, $b]);
            });
        });

        $this->assertEquals([[1, 4], [1, 5], [1, 6],
                             [2, 4], [2, 5], [2, 6],
                             [3, 4], [3, 5], [3, 6]],
                            $ret->toArray());
    }

    public function testFmap()
    {
        $c = $this->getMonadContext();
        $m1 = MonadList::cast([1, 2, 3]);
        $m2 = MonadList::cast([4, 5, 6]);

        // use fmap & bind in MonadTrait
        $ret = $m1->fmap(function($a) use($c, $m2){
            return $m2->fmap(function($b) use($c, $a){
                return [$a, $b];
            });
        });

        $expected = [[[1, 4], [1, 5], [1, 6]],
                    [[2, 4], [2, 5], [2, 6]],
                    [[3, 4], [3, 5], [3, 6]]];
        $this->assertEquals($expected, $ret->toArray());

        // use map & MapIterator in MonadList\Cons
        $ret = $m1->map(function($a) use($c, $m2){
            return $m2->map(function($b) use($c, $a){
                return [$a, $b];
            });
        });
        $this->assertEquals($expected, $ret->toArray());
    }

    public function testForeach()
    {
        $m = MonadList::cast([1, 2, 3]);
        $i = 1;
        foreach ($m as $v){
            $this->assertEquals($i, $v);
            $i++;
        }
        $this->assertEquals(4, $i);

        $mm = MonadList::ret($m);
        $x2 = function($a) { return MonadList::ret($a * 2);};
        $mm2 = MonadList::ret($m->bind($x2));
        $mm = $mm->mplus($mm2);
        $i = 1;
        $j = 1;
        foreach ($mm as $vv){
            $i = $j;
            foreach ($vv as $v){
                $this->assertEquals($i, $v);
                $i += $j;
            }
            $j++;
        }
        $this->assertEquals(8, $i);
        $this->assertEquals(3, $j);
    }

    public function testCount()
    {
        $c = $this->getMonadContext();
        $m = $c::ret(1);
        $this->assertEquals(1, count($m));

        $m2 = $m->mplus($c::ret(2));
        $this->assertEquals(2, count($m2));

        $mm = $c::ret($m);
        $this->assertEquals(1, count($mm));
        $this->assertEquals(1, count($mm->join()));

        $m0 = $c::mzero();
        $this->assertEquals(0, count($m0));
        $this->assertEquals(0, count($m0->mplus($c::mzero())));

        $mm0 = $c::ret($m0);
        $this->assertEquals(1, count($mm0));
        $this->assertEquals(0, count($mm0->join()));
    }
}

<?php
namespace Laiz\Test\Func;

use function Laiz\Func\Functor\fmap;
use function Laiz\Func\Monad\bind;
use function Laiz\Func\Monoid\mappend;
use function Laiz\Func\MonadPlus\mplus;

class TypeArrayTest extends \PHPUnit_Framework_TestCase
{
    public function testBind()
    {
        $m = [2,3,5];
        $f = function($a){ return [$a + 1]; };
        $m1 = bind($m, $f);
        $this->assertEquals([3,4,6], $m1);
    }

    public function testAppend()
    {
        $m1 = [1,2,3];
        $m2 = [11, 13];
        $m = mappend($m1, $m2);
        $this->assertEquals([1,2,3,11,13], $m);

    }


    public function testMplus()
    {
        $m1 = [1, 2, 3];
        $m2 = [4, 5, 6];

        $this->assertEquals([1,2,3,4,5,6], mplus($m1, $m2));
    }

    public function testDoubleBind()
    {
        $m1 = [1, 2, 3];
        $m2 = [4, 5, 6];

        $ret = bind($m1, function($a) use($m2){
            return bind($m2, function($b) use($a){
                return [[$a, $b]];
            });
        });

        $this->assertEquals([[1, 4], [1, 5], [1, 6],
                             [2, 4], [2, 5], [2, 6],
                             [3, 4], [3, 5], [3, 6]],
                            $ret);
    }

    public function testFmap()
    {
        $m1 = [1, 2, 3];
        $m2 = [4, 5, 6];

        $ret = fmap(function($a) use($m2){
            return fmap(function($b) use($a){
                return [$a, $b];
            }, $m2);
        }, $m1);

        $expected = [[[1, 4], [1, 5], [1, 6]],
                    [[2, 4], [2, 5], [2, 6]],
                    [[3, 4], [3, 5], [3, 6]]];
        $this->assertEquals($expected, $ret);
    }

    public function testForeach()
    {
        $m = [1, 2, 3];
        $i = 1;

        $mm = [$m];
        $x2 = function($a) { return [($a * 2)];};
        $mm2 = [bind($m, $x2)];
        $mm = mplus($mm, $mm2);
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
}

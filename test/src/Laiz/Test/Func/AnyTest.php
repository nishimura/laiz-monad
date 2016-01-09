<?php
namespace Laiz\Test\Func;

use Laiz\Func;

\Laiz\Func\Loader::load();

class AnyTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $a = new Func\Any(1);
        $this->assertInstanceOf('Laiz\Func\Any', $a);

        $a = ret(1);
        $this->assertInstanceOf('Laiz\Func\Any', $a);
    }

    public function testMaybeMonad()
    {
        $ret = ret(1)->bind(function($a){
            return Just($a + 1);
        });
        $this->assertInstanceOf('Laiz\Func\Maybe', $ret);

        $ret = ret(1)->bind(function($a){
            return Nothing();
        });
        $this->assertInstanceOf('Laiz\Func\Maybe', $ret);

        $ret = ret(1)->bind(function($a){
            return ret($a + 1);
        })->bind(function($a){
            return Just($a + 1);
        });
        $this->assertInstanceOf('Laiz\Func\Maybe', $ret);
        $this->assertEquals(Just(3), $ret);
    }

    public function testWriterMonad()
    {
        $ret = runWriter(ret(1)->bind(function($_){
            return ret(2);
        })->bind(function($a){
            return tell("a")->bind(function($_) use ($a){
                return ret($a + 5);
            });
        }));
            
        $this->assertEquals([7, "a"], $ret);
    }

    public function testMonoid()
    {
        $ret = ret('ab')->mappend(ret('cd'));
        $this->assertInstanceOf('Laiz\Func\Any', $ret);

        $this->assertEquals('abcd', $ret->cast(''));
        $this->assertEquals(['ab', 'cd'], $ret->cast([]));
        $this->assertEquals(Just('abcd'), $ret->cast(Nothing()));

        $this->assertEquals(['ab', 'cd', 'x'], $ret->mappend(['x']));
        $this->assertEquals(Just('abcdx'), $ret->mappend(Just('x')));

        $e = mempty();
        $s = 'str';
        $a = ['arr'];
        $m = Just('m');

        $this->assertEquals('str', mappend($e, $s));
        $this->assertEquals('str', mappend(mappend($e, $s), $e));

        $this->assertEquals(['arr'], mappend($e, $a));
        $this->assertEquals(['arr'], mappend(mappend($e, $a), $e));

        $this->assertEquals(Just('m'), mappend($e, $m));
        $this->assertEquals(Just('m'), mappend(mappend($e, $m), $e));
    }

    public function testGuard()
    {
        $a = guard(false)->cast([]);
        $this->assertEquals([], $a);

        $a = guard(true)->cast([]);
        $this->assertEquals([new Func\Unit], $a);

        $a = fconst('a', guard(false));
        $this->assertEquals([], $a->cast([]));

        $a = fconst('a', guard(true));
        $this->assertEquals(['a'], $a->cast([]));
        $this->assertEquals(Just('a'), $a->cast(Nothing()));
    }

    public function testGuardAppend()
    {
        $f = function ($s, ...$eq){
            return f(function($s, $a, $b){
                return fconst($s, guard($a === $b));
            }, $s, ...$eq);
        };

        $at = $f('a', 1, 1);
        $af = $f('a', 1, 2);
        $bt = $f('b', 2, 2);
        $bf = $f('b', 2, 3);

        $this->assertEquals(Just('a'), $at->cast(Nothing()));
        $this->assertEquals(Nothing(), $af->cast(Nothing()));
        $this->assertEquals(Just('b'), $bt->cast(Nothing()));
        $this->assertEquals(Nothing(), $bf->cast(Nothing()));

        $this->assertEquals(Nothing(), mappend($af, $bf)->cast(Nothing()));
        $this->assertEquals(Just('a'), mappend($at, $bf)->cast(Nothing()));
        $this->assertEquals(Just('b'), mappend($af, $bt)->cast(Nothing()));
        $this->assertEquals(Just('ab'), mappend($at, $bt)->cast(Nothing()));

        $this->assertEquals(Nothing(),
                            mappend($f('a', 1), $f('b', 1), 2)->cast(Nothing()));
        $this->assertEquals(Just('a'),
                            mappend($f('a', 2), $f('b', 1), 2)->cast(Nothing()));
        $this->assertEquals(Just('b'),
                            mappend($f('a', 1), $f('b', 2), 2)->cast(Nothing()));
        $this->assertEquals(Just('ab'),
                            mappend($f('a', 2), $f('b', 2), 2)->cast(Nothing()));
    }

    public function testFromMaybe()
    {
        $this->assertEquals('a', fromMaybe('a', mzero()));
        $this->assertEquals(2, fromMaybe(2, mzero()));
    }
}

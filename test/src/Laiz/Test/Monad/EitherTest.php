<?php

namespace Laiz\Test\Monad;

use Laiz\Monad\Either;

class EitherTest extends \PHPUnit_Framework_TestCase
{
    use MonadTrait;
    use ControlTrait;

    /**
     * @override
     */
    public function getMonadContext()
    {
        return Either::fail('');
    }

    public function testChain1()
    {
        $c = $this->getMonadContext();

        $f = function($a) use ($c){ return $a >= 5 ? $c->ret($a) : $c->fail('under 5'); };
        $g = function($a) use ($c){ return $a <= 10 ? $c->ret($a) : $c->fail('over 10'); };

        $a = $c->ret(7);
        $this->assertEquals($a, $a->bind($f)->bind($g));

        $a = $c->ret(3);
        $this->assertEquals($c->fail('under 5'), $a->bind($f)->bind($g));

        $a = $c->ret(11);
        $this->assertEquals($c->fail('over 10'), $a->bind($f)->bind($g));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testNull()
    {
        Either::ret(null);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testNewNull()
    {
        new Either\Right(null);
    }

    public function testEither()
    {
        $c = $this->getMonadContext();

        $left = function($v){ return 'error [' . (string)$v . ']'; };
        $right = function($v){ return $v * 2; };

        $this->assertEquals($c->ret(3)->either($left, $right), 6);
        $this->assertEquals($c->fail(3)->either($left, $right),
                            'error [3]');
    }
}

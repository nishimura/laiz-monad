<?php
namespace Laiz\Test\Func;

use Laiz\Func\Writer;
use Laiz\Func\Monad;

class WriterTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $w = Monad\Writer::ret(1);
        $this->assertInstanceOf('Laiz\Func\Writer', $w);
    }

    public function testRun()
    {
        $ret = runWriter(tell("a")->bind(function($_){
            return Monad\Writer::ret(1);
        }));
        $this->assertEquals([1, "a"], $ret);

        $ret = runWriter(tell("a")->bind(function($_){
            return ret(1); // Any#cast => Writer
        }));
        $this->assertEquals([1, "a"], $ret);

        $ret = runWriter(tell("a")->bind(function($_){
            return tell("b");
        })->bind(function($_){
            return ret(2);
        }));
        $this->assertEquals([2, "ab"], $ret);

        $ret = runWriter(tell("a")->bind(function($_){
            return tell("b");
        })->bind(function($_){
            return ret(2);
        })->bind(function($a){
            return ret(3);
        }));
        $this->assertEquals([3, "ab"], $ret);

        $ret = runWriter(ret(2)->bind(function($_){
            return tell("a");
        })->bind(function($_){
            return ret(2);
        }));
        $this->assertEquals([2, "a"], $ret);
    }
}

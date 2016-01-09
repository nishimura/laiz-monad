<?php
namespace Laiz\Test\Func;

use Laiz\Func;

\Laiz\Func\Loader::load();

class AnyTest extends \PHPUnit_Framework_TestCase
{
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
}

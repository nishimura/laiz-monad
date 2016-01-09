<?php

namespace Laiz\Test\Func;

use Laiz\Func\MonadPlus;

trait MonadPlusTrait
{
    abstract public function getMonadPlus();

    /**
     * mzero >>= f == mzero
     */
    public function testMonadPlusLaw1()
    {
        $c = $this->getMonadPlus();
        $z = $c::mzero();
        $f = function($a) use ($c) { return $c::ret($a * 3); };

        $this->assertEquals($z, $z->bind($f));

        return $c;
    }

    /**
     * m >>= (\x -> mzero) == mzero
     * @depends testMonadPlusLaw1
     */
    public function testMonadPlusLaw2($c)
    {
        $m = $c::ret(5);
        $f = function($a) use ($c) { return $c::mzero(); };

        $this->assertEquals($c::mzero(), $m->bind($f));

        return $c;
    }

    /**
     * mzero `mplus` m == m
     * @depends testMonadPlusLaw2
     */
    public function testMonadPlusLaw3($c)
    {
        $m = $c::ret(5);
        $z = $c::mzero();

        $this->assertEquals($m, $z->mplus($m));

        return $c;
    }

    /**
     * m `mplus` mzero == m
     * @depends testMonadPlusLaw3
     */
    public function testMonadPlusLaw4($c)
    {
        $m = $c::ret(5);
        $z = $c::mzero();

        $this->assertEquals($m, $m->mplus($z));

        return $c;
    }
}

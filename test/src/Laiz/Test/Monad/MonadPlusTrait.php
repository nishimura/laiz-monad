<?php

namespace Laiz\Test\Monad;

use Laiz\Monad;
use Laiz\Monad\Context;

trait MonadPlusTrait
{
    /**
     * mzero >>= f == mzero
     * @depends testLaw3
     */
    public function testLawPlus1(Context $c)
    {
        $z = $c->mzero();
        $f = function($a) use ($c) { return $c->ret($a * 3); };

        $this->assertEquals($z, $z->bind($f));

        return $c;
    }

    /**
     * m >>= (\x -> mzero) == mzero
     * @depends testLawPlus1
     */
    public function testLawPlus2(Context $c)
    {
        $m = $c->ret(5);
        $f = function($a) use ($c) { return $c->mzero(); };

        $this->assertEquals($c->mzero(), $m->bind($f));

        return $c;
    }

    /**
     * mzero `mplus` m == m
     * @depends testLawPlus2
     */
    public function testLawPlus3(Context $c)
    {
        $m = $c->ret(5);
        $z = $c->mzero();

        $this->assertEquals($m, $z->mplus($m));

        return $c;
    }

    /**
     * m `mplus` mzero == m
     * @depends testLawPlus3
     */
    public function testLawPlus4(Context $c)
    {
        $m = $c->ret(5);
        $z = $c->mzero();

        $this->assertEquals($m, $m->mplus($z));

        return $c;
    }
}

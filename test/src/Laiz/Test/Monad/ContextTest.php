<?php

namespace Laiz\Test\Monad;

use Laiz\Monad\Monad;
use Laiz\Monad\Context;
use Laiz\Monad\Maybe;
use Laiz\Monad\Maybe\Just;
use Laiz\Monad\MonadList;

class Tree
{
    public $left;
    public $value;
    public $right;
    public function __construct($value, $left, $right)
    {
        $this->value = $value;
        $this->left = $left;
        $this->right = $right;
    }
}
class EmptyTree extends Tree
{
    public function __construct(){}
}

class ContextTest extends \PHPUnit_Framework_TestCase
{
    // MonadPlus m => (Int -> Bool) -> Tree -> m Int
    private function searchTree(Monad $m, callable $f, Tree $tree)
    {
        if ($tree instanceof EmptyTree)
            return $m::mzero();

        if ($f($tree->value))
            return $this->searchTree($m, $f, $tree->left)
                ->mplus($m::ret($tree->value))
                ->mplus($this->searchTree($m, $f, $tree->right));
        else
            return $this->searchTree($m, $f, $tree->left)
                ->mplus($this->searchTree($m, $f, $tree->right));
    }

    private function getTree()
    {
        $empty = new EmptyTree();
        return new Tree(3,
                        new Tree(2, $empty, $empty),
                        new Tree(1, $empty, $empty));
    }

    public function testTreeMaybe()
    {
        $c = Maybe::mzero();
        $f = function($a){ return $a % 2 == 1; };
        $t = $this->getTree();

        $ret = $this->searchTree($c, $f, $t);

        $this->assertEquals(new Just(3), $ret);
    }

    public function testTreeMonadList()
    {
        $c = MonadList::mzero();
        $f = function($a){ return $a % 2 == 1; };
        $t = $this->getTree();

        $ret = $this->searchTree($c, $f, $t);

        $this->assertEquals([3,1], $ret->toArray());
    }
}

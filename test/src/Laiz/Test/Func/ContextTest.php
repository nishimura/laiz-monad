<?php

namespace Laiz\Test\Func;

use function Laiz\Func\Monad\ret;
use function Laiz\Func\MonadZero\mzero;
use function Laiz\Func\MonadPlus\mplus;
use function Laiz\Func\Maybe\Just;
use function Laiz\Func\Maybe\Nothing;

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
    private function searchTree(callable $f, Tree $tree)
    {
        if ($tree instanceof EmptyTree)
            return mzero();

        if ($f($tree->value))
            return $this->searchTree($f, $tree->left)
                ->mplus(ret($tree->value))
                ->mplus($this->searchTree($f, $tree->right));
        else
            return $this->searchTree($f, $tree->left)
                ->mplus($this->searchTree($f, $tree->right));
    }

    private function getTree()
    {
        $empty = new EmptyTree();
        return new Tree(3,
                        new Tree(2, $empty, $empty),
                        new Tree(1, $empty, $empty));
    }

    private function runSearch()
    {
        $f = function($a){ return $a % 2 == 1; };
        $t = $this->getTree();
        return $this->searchTree($f, $t);
    }
    public function testTreeMaybe()
    {
        $ret = $this->runSearch();
        $this->assertEquals(Just(3), mplus($ret, Nothing()));
    }

    public function testTreeArray()
    {
        $ret = $this->runSearch();

        $this->assertEquals([3,1], mplus($ret, []));
    }
}

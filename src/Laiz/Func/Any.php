<?php

namespace Laiz\Func;

class Any
{
    use CallTrait;

    const FMAP = '_reversefmap_';

    public $op;
    public $value;
    public $ops = [];
    public function __construct($op, $value = null, $ops = [])
    {
        $this->op = $op;
        if ($value === null)
            $value = new Nul();
        $this->value = $value;
        $this->ops = $ops;
    }

    public function __toString()
    {
        return (string)$this->value;
    }

    private function opsFold($ret)
    {
        foreach ($this->ops as $op){
            list($method, $any) = $op;
            if ($method === self::FMAP)
                $ret = fmap($any, $ret);
            else
                $ret = $method($ret, $any->cast($ret));
        }
        return $ret;
    }

    public function castByName($name){
        $args = [];
        if (!($this->value instanceof Nul))
            $args[] = $this->value;
        $ret = _callInstanceMethodString($name, $this->op, ...$args);
        return $this->opsFold($ret);
    }

    public function cast($m)
    {
        if (is_object($m) ||
            is_string($m) ||
            is_array($m)){
            $args = [];
            if (!($this->value instanceof Nul))
                $args[] = $this->value;
            $ret = _callInstanceMethod($m, $this->op, ...$args);
            return $this->opsFold($ret);
        }

        throw new \Exception('Unsupported cast [' . gettype($m) . ']');
    }

    public static function op($a1, $op, $a2)
    {
        $ret = new Any($a1->op, $a1->value, $a1->ops);
        $ret->ops[] = [$op, $a2];
        return $ret;
    }
}

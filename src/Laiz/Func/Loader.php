<?php

namespace Laiz\Func;

class Loader
{
    public static function load($name = null)
    {
        static $loaded;

        if ($loaded)
            return;

        if ($name === null || $name === 'classes'){
            foreach (['functions', 'Functor', 'Applicative', 'Monad',
                      'MonadPlus', 'MonadZero', 'Monoid',
                      'Maybe', 'Either', 'Writer'] as $file)
                require_once __DIR__ . "/$file.php";
            return;
        }

        if ($name !== 'all'){
            require_once __DIR__ . "$name.php";
            return;
        }

        foreach (glob(__DIR__ .'/*.php') as $file){
            require_once $file;
        }
        $loaded = true;
    }

    public static function callInstance($class, $method, ...$args)
    {
        assert(method_exists($class, $method),
               "Method [$class#$method] not exists.");

        $method = [$class, $method];
        return $method(...$args);
    }

    private static $funcMap = [
        'compose' => 'Laiz\Func',
        'fmap' => 'Laiz\Func\Functor',
        'pure' => 'Laiz\Func\Applicative',
        'ap' => 'Laiz\Func\Applicative',
        'ret' => 'Laiz\Func\Monad',
        'bind' => 'Laiz\Func\Monad',
        'mempty' => 'Laiz\Func\Monoid',
        'mappend' => 'Laiz\Func\Monoid',
        'mzero' => 'Laiz\Func\MonadZero',
        'mplus' => 'Laiz\Func\MonadPlus'
    ];
    public static function callFunction($name, ...$args)
    {
        $namespace = self::$funcMap[$name];
        $f = $namespace . '\\' .  $name;
        return $f(...$args);
    }
    public static function setFunction($func, $namespace)
    {
        self::$funcMap[$func] = $namespace;
    }

    private static $methodMap = [
        'fmap' => 'Functor',
        'pure' => 'Applicative',
        'ap' => 'Applicative',
        'ret' => 'Monad',
        'bind' => 'Monad',
        'mempty' => 'Monoid',
        'mappend' => 'Monoid',
        'mzero' => 'MonadZero',
        'mplus' => 'MonadPlus'
    ];
    public static function typeToInstance($method){
        return self::$methodMap[$method];
    }
    public static function setMethod($method, $class){
        self::$methodMap[$method] = $class;
    }

    public static function classToInstance($type, $method)
    {
        static $cache;
        if ($cache === null)
            $cache = [];
        if (isset($cache[$type][$method]))
            return $cache[$type][$method];

        $prefix = self::typeToInstance($method);
        $class = preg_replace('/^(.*?)(\\\\[[:alnum:]_]+)$/',
                              '\\1\\' . $prefix . '\\2', $type);
        if (!class_exists($class)){
            $old = $class;
            $oldType = $type;
            $type = preg_replace('/\\\\[[:alnum:]_]+$/', '', $type);
            $class = preg_replace('/^(.*?)(\\\\[[:alnum:]_]+)$/',
                                  '\\1\\' . $prefix . '\\2', $type);
            assert(class_exists($class),
                   "Class [$old] and [$class] not exists.");

            $cache[$oldType][$method] = $class;
        }

        $cache[$type][$method] = $class;
        return $class;
    }

    public static function callInstanceMethod($a, $method, ...$args)
    {
        $prefix = self::typeToInstance($method);
        if (!is_object($a)){
            $a = gettype($a);
            $a = ucfirst(strtolower($a));
            $a = 'Laiz\\Func\\' . $prefix . '\\Type' . $a;
        }else{
            $a = self::classToInstance(get_class($a), $method);
        }
        return self::callInstance($a, $method, ...$args);
    }

    public static function callInstanceMethodString($type, $method, ...$args)
    {
        return self::callInstance(
            self::classToInstance($type, $method), $method, ...$args);
    }

}

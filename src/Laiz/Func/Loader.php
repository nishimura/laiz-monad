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
                      'MonadPlus', 'MonadZero', 'Monoid', 'Alternative',
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

    // If register new utility function then call setMethod.
    // Can use method call "$monad->($monadFunc)"
    // instead of "bind($monad, $monadFunc)".
    //
    // definitions of global function
    // used in Any and CallTrait
    private static $funcMap = [
        'compose' => 'Laiz\Func',
        'fmap' => 'Laiz\Func\Functor',
        'pure' => 'Laiz\Func\Applicative',
        'ap' => 'Laiz\Func\Applicative',
        'const1' => 'Laiz\Func\Applicative',
        'const2' => 'Laiz\Func\Applicative',
        'aor' => 'Laiz\Func\Alternative',
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

    // If register new type-class then call setMethod.
    //
    // resolv a instance class of type-class
    private static $methodMap = [
        'fmap' => 'Functor',
        'pure' => 'Applicative',
        'ap' => 'Applicative',
        'aor' => 'Alternative',
        'ret' => 'Monad',
        'bind' => 'Monad',
        'mempty' => 'Monoid',
        'mappend' => 'Monoid',
        'mzero' => 'MonadZero',
        'mplus' => 'MonadPlus'
    ];
    public static function methodToClass($method){
        return self::$methodMap[$method];
    }
    private static $namespaceMap = [];
    public static function setMethod($method, $class, $namespace){
        self::$methodMap[$method] = $class;
        self::$namespaceMap[$method] = $namespace;
    }
    public static function methodToNamespace($method){
        if (isset(self::$namespaceMap[$method]))
            return self::$namespaceMap[$method];
        return 'Laiz\\Func';
    }

    public static function classToInstance($type, $method)
    {
        static $cache;
        if ($cache === null)
            $cache = [];
        if (isset($cache[$type][$method]))
            return $cache[$type][$method];

        $prefix = self::methodToClass($method);
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
        if (!is_object($a)){
            $a = gettype($a);
            $a = ucfirst(strtolower($a));
            $prefix = self::methodToClass($method);
            $namespace = self::methodToNamespace($method);
            $a = $namespace . '\\' . $prefix . '\\Type' . $a;
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

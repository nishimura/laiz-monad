<?php

namespace Laiz\Func;

class Loader
{
    public static function load($all = false)
    {
        static $loaded;

        if ($loaded)
            return;

        foreach (['functions.php', 'Maybe.php'] as $file)
            require_once __DIR__ . "/$file";

        if (!$all)
            return;

        foreach (glob(__DIR__ .'/*.php') as $file){
            require_once $file;
        }
        $loaded = true;
    }
}

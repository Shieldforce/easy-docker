<?php

namespace App\Execute\Implements;
use App\Colors\SetColors;
use App\Execute\Errors\StringError;

class ImplementPHP
{
    public static function run($args)
    {
        self::version($args[2]);
    }

    private static function version($version)
    {
        $stringCurrent = "--version=";
        if(strpos($version, $stringCurrent) === false) {
            $setColors = new SetColors;
            $string = "Você precisa passar {$setColors->setEffect('blue')} ";
            $string .= "{$stringCurrent}{version}{$setColors->setEffect('end')} ";
            $string .= "{$setColors->setEffect('red')}como segundo parâmetro!
             Se a implementação for PHP, aonde {version} é a versão escolhida! ";
            $string .= "{$setColors->setEffect('end')}";
            StringError::getError($string);
            return;
        }

        self::dockerRun(str_replace([$stringCurrent], [""], $version));
    }

    private static function dockerRun(string $version)
    {
        $path = str_replace(["/Execute/Implements"], [""], __DIR__);
        exec($path."/dockers/php/{$version}/run.sh", $output);
        print_r($output);
    }
}
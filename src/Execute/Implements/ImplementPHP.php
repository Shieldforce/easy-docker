<?php

namespace App\Execute\Implements;
use App\Colors\SetColors;
use App\Execute\Errors\StringError;

class ImplementPHP
{
    private static string $version;
    private static string $port;
    private static string $container;

    public static function run($argv)
    {
        $argsMount = [];
        foreach ($argv as $arg) {
            if($arg=="--php") {
                continue;
            }
            $argMethod = false;
            if(preg_match("/--(.*?)=/", $arg, $matches)) {
                $argMethod = $matches[1] ?? false;
                if (method_exists(new ImplementPHP(), $argMethod)) {
                    self::$argMethod($arg);
                    $argsMount[] = $arg;
                }
            }
            if(!$argMethod) StringError::getErrorArg($argMethod);
        }

        if(count($argsMount) > 0) self::dockerRun();
    }

    private static function version($arg)
    {
        $path = str_replace(["/Execute/Implements"], [""], __DIR__);
        $versionValue = str_replace(["--version="], [""], $arg);
        if(!file_exists($path."/dockers/php/{$versionValue}/run.sh")) {
            $setColors = new SetColors();
            StringError::getError(
                $setColors->setEffect("red").
                "Versão {$versionValue} do PHP, ainda não foi implementada!".
                $setColors->setEffect("end")
            );
        }
        self::$version = $versionValue;
    }

    private static function port($arg)
    {
        $portValue = str_replace(["--port="], [""], $arg);
        if(!is_numeric($portValue)) {
            $setColors = new SetColors();
            StringError::getError(
                $setColors->setEffect("red").
                "Porta {$portValue}, precisa ser um valor inteiro!".
                $setColors->setEffect("end")
            );
        }
        self::$port = $portValue;
    }

    private static function container($arg)
    {
        $containerValue = str_replace(["--container="], [""], $arg);
        exec("docker ps --filter 'name={$containerValue}'", $output);
        if(count($output) > 1) {
            $message = "";
            foreach ($output as $cont) {
                $message .= $cont."\n";
            }
            StringError::getError(
                "Existem containers com nome parecido : {$containerValue}! \n" .$message
            );
        }
        self::$container = $containerValue;
    }

    private static function dockerRun()
    {
        $version    = self::$version;
        $port       = self::$port;
        $container  = self::$container;
        $path       = str_replace(["/Execute/Implements"], [""], __DIR__);
        exec($path."/dockers/php/{$version}/run.sh {$version} {$port} {$container}", $output);
        print_r($output);
    }
}
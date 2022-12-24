<?php

namespace App\Execute\Implements;
use App\Colors\SetColors;
use App\Execute\Errors\StringError;

class LaravelPHP
{
    private static string $version;
    private static string $port;
    private static string $container;

    private static string $remount;

    public static function run($argv)
    {
        $argsMount = [];
        foreach ($argv as $arg) {
            if($arg=="--php") {
                continue;
            }
            $argMethod = false;
            if($arg=="--remount") {
                $argMethod = true;
                self::remount($arg, $argv);
                $argsMount[] = $arg;
            }
            if(preg_match("/--(.*?)=/", $arg, $matches)) {
                $argMethod = $matches[1] ?? false;
                if (method_exists(new LaravelPHP(), $argMethod)) {
                    self::$argMethod($arg, $argv);
                    $argsMount[] = $arg;
                }
            }
            if(!$argMethod) StringError::getErrorArg($argMethod);
        }

        if(count($argsMount) > 0) self::dockerRun();
    }

    private static function version($arg, $argv=null)
    {
        $path = str_replace(["/Execute/Implements"], [""], __DIR__);
        $versionValue = str_replace(["--version="], [""], $arg);
        if(!file_exists($path."/dockers/laravel/{$versionValue}/run.sh")) {
            $setColors = new SetColors();
            StringError::getError(
                $setColors->setEffect("red").
                "Versão {$versionValue} do PHP, ainda não foi implementada!".
                $setColors->setEffect("end")
            );
        }
        self::$version = $versionValue;
    }

    private static function port($arg, $argv=null)
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

    private static function container($arg, $argv=null)
    {
        $containerValue = str_replace(["--container="], [""], $arg);
        exec("docker ps --filter 'name={$containerValue}'", $output);
        if(count($output) > 1) {
            $message = "";
            foreach ($output as $cont) {
                $message .= $cont."\n";
            }
            if(strpos(implode(",", $argv), "--remount")===false) {
                $remount = "Se deseja remontar o container passe a flag --remount";
                StringError::getError(
                    "Existem containers com nome parecido : {$containerValue}! \n" .$message. "\n". $remount
                );
            }
        }
        self::$container = $containerValue;
    }

    private static function remount($arg, $argv=null)
    {
        if(strpos($arg, "--remount")!==false) {
            self::$remount = "--build";
        }
    }

    private static function dockerRun()
    {

        if(!isset(self::$version)) {
            StringError::getErrorArg("--version");
            return;
        }

        if(!isset(self::$port)) {
            StringError::getErrorArg("--port");
            return;
        }

        if(!isset(self::$container)) {
            StringError::getErrorArg("--container");
            return;
        }

        $version    = self::$version;
        $port       = self::$port;
        $container  = self::$container;

        $path       = str_replace(["/Execute/Implements"], [""], __DIR__);

        $remount = "";

        if(isset(self::$remount)) {
            $remount = self::$remount;
        }

        exec($path."/dockers/laravel/{$version}/run.sh {$version} {$port} {$container} {$remount}", $output);
        print_r($output);
    }
}
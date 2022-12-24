<?php

namespace App\Execute\Implements;
use App\Colors\SetColors;
use App\Execute\Errors\StringError;

class ImplementLaravel
{
    private static string $version;
    private static string $port;

    private static string $redis_port;

    private static string $mysql_port;
    private static string $container;

    private static string $remount;

    public static function run($argv)
    {
        $argsMount = [];
        foreach ($argv as $arg) {
            if($arg=="--laravel") {
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
                if (method_exists(new ImplementLaravel(), $argMethod)) {
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

    private static function redis_port($arg, $argv=null)
    {
        $portValue = str_replace(["--redis_port="], [""], $arg);
        if(!is_numeric($portValue)) {
            $setColors = new SetColors();
            StringError::getError(
                $setColors->setEffect("red").
                "Porta {$portValue}, precisa ser um valor inteiro!".
                $setColors->setEffect("end")
            );
        }
        self::$redis_port = $portValue;
    }

    private static function mysql_port($arg, $argv=null)
    {
        $portValue = str_replace(["--mysql_port="], [""], $arg);
        if(!is_numeric($portValue)) {
            $setColors = new SetColors();
            StringError::getError(
                $setColors->setEffect("red").
                "Porta {$portValue}, precisa ser um valor inteiro!".
                $setColors->setEffect("end")
            );
        }
        self::$mysql_port = $portValue;
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

        if(!isset(self::$redis_port)) {
            StringError::getErrorArg("--redis_port");
            return;
        }

        if(!isset(self::$mysql_port)) {
            StringError::getErrorArg("--mysql_port");
            return;
        }

        $version          = self::$version;
        $port             = self::$port;
        $redis_port       = self::$redis_port;
        $mysql_port       = self::$mysql_port;
        $container        = self::$container;
        $path             = str_replace(["/Execute/Implements"], [""], __DIR__);
        $remount          = "";

        if(isset(self::$remount)) {
            $remount = self::$remount;
        }

        exec($path."/dockers/laravel/{$version}/run.sh {$version} {$port} {$container} {$redis_port} {$mysql_port} {$remount}", $output);
        print_r($output);
    }
}
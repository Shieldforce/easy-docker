<?php

declare(strict_types=1);

namespace App\Execute;

use App\Colors\SetColors;
use App\Execute\Errors\StringError;
use App\Execute\Implements\ImplementPHP;
use App\Execute\Implements\LaravelPHP;

class ExecuteArgs
{

    public static function run($argv) : void
    {
        $argv = self::execArgs($argv);
        self::validArgs($argv);
    }

    private static function execArgs($argv) : array
    {
        $input  = $argv;
        $remove = ["scoob", "vendor/shieldforce/easy-docker/scoob"];
        return array_diff($input, $remove);
    }

    private static function validArgs($argv) : void
    {
        foreach ($argv as $arg) {

            $arg = str_replace(["--"], [""], $arg);

            if (method_exists(new ExecuteArgs, $arg)) {
                self::$arg($arg, $argv);
                return;
            }

            StringError::getErrorArg($arg);

        }
    }

    private static function help($arg, $argv)
    {
        $setColors = new SetColors;

        echo "\n";
        echo "---- {$setColors->setEffect('blue')} Inicio da Ajuda ";
        echo "{$setColors->setEffect('end')} ---------------------------------------------------------------- \n";
        echo "\n";

        foreach (self::getMethods() as $method) {
            $description = self::descriptions($method);

            echo "{$setColors->setEffect('green')}#### {$setColors->setEffect('end')}";
            echo "(--{$method}) : {$description} \n";
            echo "\n";
        }

        echo "---- {$setColors->setEffect('blue')} Final da Ajuda ";
        echo "{$setColors->setEffect('end')} ---------------------------------------------------------------- \n";
        echo "\n";
    }

    private static function getMethods()
    {
        $class_methods = get_class_methods(new ExecuteArgs());
        $arrayMethods  = [];
        foreach ($class_methods as $method) {
            if(
                array_search($method, [
                "run", "execArgs", "validArgs", "getMethods", "descriptions", "vendor/shieldforce/easy-docker/scoob"
                ])===false
            ) {
                $arrayMethods[] = $method;
            }
        }
        return $arrayMethods;
    }

    private static function descriptions($method) : string
    {
        $return =  [
            "help"     => "Este argumento fornece uma lista de ajuda para o usuário!",
            "php"      => "Este comando sobe um container com o PHP mais a --version= informada, 
            se não passar versão, será considerado a última!",
            "laravel"  => "Este comando sobe um container com todos os recursos para rodar o laravel!",
        ];
        return $return[$method] ?? "";
    }

    private static function php($arg, $argv)
    {
        ImplementPHP::run($argv);
    }

    private static function laravel($arg, $argv)
    {
        LaravelPHP::run($argv);
    }
}
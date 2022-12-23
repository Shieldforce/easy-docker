<?php

declare(strict_types=1);

namespace App\Execute;

use App\Colors\SetColors;

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
        $remove = ["scoob"];
        return array_diff($input, $remove);
    }

    private static function validArgs($argv) : void
    {
        foreach ($argv as $arg) {
            $arg = str_replace(["--"], [""], $arg);
            $setColors = new SetColors;

            if (!method_exists(new ExecuteArgs, $arg)) {
                echo "\n";
                echo "---- Inicio do  Erro ----------------------------------------- \n";
                echo "\n";
                echo "---- Argumento ({$setColors->setEffect('red')}{$arg}";
                echo "{$setColors->setEffect('end')}) é inválido! \n";
                echo "\n";
                echo "---- Final do  Erro ------------------------------------------ \n";
                echo "\n";
                break;
            }

            self::$arg($arg);
        }
    }

    private static function help($arg)
    {
        $setColors = new SetColors;

        echo "\n";
        echo "---- {$setColors->setEffect('blue')} Inicio da Ajuda ";
        echo "{$setColors->setEffect('end')} ---------------------------------------------------------------- \n";

        foreach (self::getMethods() as $method) {
            $description = self::descriptions($method);

            echo "\n";
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
                "run", "execArgs", "validArgs", "getMethods", "descriptions"
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
            "help" => "Este argumento fornece uma lista de ajuda para o usuário!"
        ];
        return $return[$method] ?? "";
    }
}
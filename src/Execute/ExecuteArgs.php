<?php

declare(strict_types=1);

namespace App\Execute;

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

            if (!method_exists(new ExecuteArgs, $arg)) {
                echo "\n";
                echo "---- Inicio do  Erro ----------------------------------------- \n";
                echo "\n";
                echo "---- Argumento (\033[0;31m{$arg}\033[0m) é inválido! \n";
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
        echo "\n";
        echo "---- Inicio da Ajuda ----------------------------------------- \n";
        echo "\n";
        echo "---- Você pode usar os seguintes argumentos: \n";
        echo "\n";
        echo "---- Final da  Ajuda ------------------------------------------ \n";
        echo "\n";
    }
}
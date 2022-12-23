<?php

declare(strict_types=1);

namespace App\Execute\Errors;

use App\Colors\SetColors;

class StringError
{
    public static function getErrorArg(string $arg)
    {
        $setColors = new SetColors;
        echo "\n";
        echo "---- Inicio do  Erro ----------------------------------------- \n";
        echo "\n";
        echo "---- Argumento ({$setColors->setEffect('red')}{$arg}";
        echo "{$setColors->setEffect('end')}) é inválido! \n";
        echo "\n";
        echo "---- Final do  Erro ------------------------------------------ \n";
        echo "\n";
    }

    public static function getError(string $string)
    {
        $setColors = new SetColors;
        echo "\n";
        echo "---- Inicio do  Erro ----------------------------------------- \n";
        echo "\n";
        echo "---- {$setColors->setEffect('red')}{$string}";
        echo "{$setColors->setEffect('end')}! \n";
        echo "\n";
        echo "---- Final do  Erro ------------------------------------------ \n";
        echo "\n";
    }
}
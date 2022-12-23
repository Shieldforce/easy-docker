<?php

namespace App\Colors;

class SetColors
{
    public function setEffect($effect)
    {
        $return = [
            "red"        =>"\033[0;31m",
            "header"     =>"\033[95m",
            "blue"       =>"\033[94m",
            "green"      =>"\033[92m",
            "waring"     =>"\033[93m",
            "fail"       =>"\033[91m",
            "bold"       =>"\033[1m",
            "underline"  =>"\033[4m",
            "end"        =>"\033[0m",
        ];
        return $return[$effect] ?? "";
    }
}
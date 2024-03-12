<?php

namespace Core;

class Autoloader
{
    public function registrate(): void
    {
        $autoloader = function (string $className) {
            $helper = str_replace('\\','/',$className);
            $path = "./../$helper.php";
            if (file_exists($path)){
                require_once $path;
                return true;
            } else {
                return false;
            }
        };

        spl_autoload_register($autoloader);
    }

}
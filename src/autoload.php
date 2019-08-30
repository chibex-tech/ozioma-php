<?php

/**
 * Ozioma Autoloader
 * For use when library is being used without composer
 */

$ozioma_autoloader = function ($class_name) {
    if (strpos($class_name, 'Chibex\Ozioma')===0) {
        $file = dirname(__FILE__) . DIRECTORY_SEPARATOR;
        $file .= str_replace([ 'Chibex\\', '\\' ], ['', DIRECTORY_SEPARATOR ], $class_name) . '.php';
        include_once $file;
    }
};

spl_autoload_register($ozioma_autoloader);

return $ozioma_autoloader;

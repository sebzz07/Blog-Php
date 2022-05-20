<?php

spl_autoload_register(function ($className) {
    $classNames = preg_split('/\//', str_replace('\\', '/', $className));
    $classNames = array_slice($classNames, 2);
    $file = basename(__DIR__).DIRECTORY_SEPARATOR.implode(DIRECTORY_SEPARATOR, $classNames).'.php';

    if (file_exists($file)) {
        require $file;

        return true;
    }

    return false;
});

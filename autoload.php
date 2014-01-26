<?php

$autoload = function($className)
{
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'src/' . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
};

spl_autoload_register($autoload);
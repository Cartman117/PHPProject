<?php

$autoload = function($className)
{
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'src/' . str_replace('/', '\\', $className) . '.php';
};

spl_autoload_register($autoload);
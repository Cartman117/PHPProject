<?php

$cache_file = __DIR__ . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'cache.php';
$autoload_map = array();

include_once $cache_file;

$autoload = function($className) use ($autoload_map, $cache_file) {
    global $cache_map;
    if (!empty($cache_map) && array_key_exists($className, $cache_map)) {
        // If the class is in cache.
        require_once $cache_map[$className];
        return;
    }
    if (!empty($autoload_map) && array_key_exists($className, $autoload_map)) {
        // Else, if the class is not in cache, it can be in the array $autoload_map. Add it to the cache.
        addFileToCache($className, $autoload_map[$className]);
        require_once $autoload_map[$className];
        return;
    }
    // If the class is not in cache nor in the array, get it and add it to the cache.
    searchFile(__DIR__, $className);
};

function searchFile($directory, $className) {
    $className = ltrim($className, '\\');
    $classNameSave = $className;
    $directory_not_allowed = array(
                                 '.',
                                 '..',
                                 '.git',
                                 '.idea'
                             );
    $file = '';
    if ($last_position = strripos($className, '\\')) {
        $namespace = substr($className, 0, $last_position);
        $className = substr($className, $last_position + 1);
        $file = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $file .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    if(strrpos($file, DIRECTORY_SEPARATOR)) {
        $file = substr($file, strrpos($file, DIRECTORY_SEPARATOR) + 1);
    }
    loadFile($directory, $directory_not_allowed, $file, $classNameSave);
}


function loadFile($directory, $directory_not_allowed, $file, $classNameSave) {
    $open_directory = opendir($directory);
    while (false !== ($entry = readdir($open_directory))) {
        if (is_dir($directory . DIRECTORY_SEPARATOR . $entry) && !in_array($entry, $directory_not_allowed)) {
            loadFile($directory . DIRECTORY_SEPARATOR . $entry, $directory_not_allowed, $file, $classNameSave);
        }
        elseif($entry === $file) {
            closedir($open_directory);
            $path = $directory . DIRECTORY_SEPARATOR . $file;
            addFileToCache($classNameSave, $path);
            require_once $path;
            return;
        }
    }
    closedir($open_directory);
}

function addFileToCache($className, $file) {
    global $cache_map, $cache_file;
    if (!$cache_map) {
        $cache_map = array();
    }
    if (!empty($className)) {
        $cache_map[$className] = $file;
        var_dump($cache_map);
        echo $file;
        file_put_contents($cache_file, '<?php' . "\n" . '$cache_map = ' . var_export($cache_map, true) . ';');
    }
}

spl_autoload_register($autoload);
<?php
/**
 * Created by IntelliJ IDEA.
 * User: blitzcat
 * Date: 4/12/15
 * Time: 3:23 PM
 */
require_once __DIR__ . '/../src/autoload.php';
require_once __DIR__ . '/../vendor/autoload.php';
spl_autoload_register(function($class) {
    $namespace = 'GameOfLifeTest';
    if (strncmp($class, $namespace, strlen($namespace)) === 0) {
        require_once __DIR__ . str_replace(
                [$namespace, '\\'],
                ['', DIRECTORY_SEPARATOR],
                $class
            ) . '.php';
    }
});
<?php
/**
 * Created by IntelliJ IDEA.
 * User: blitzcat
 * Date: 4/12/15
 * Time: 2:07 PM
 */
spl_autoload_register(function($class) {
    $namespace = 'GameOfLife';
    if (strncmp($class, $namespace, strlen($namespace)) === 0) {
       require_once __DIR__ . str_replace(
               [$namespace, '\\'],
               ['', DIRECTORY_SEPARATOR],
                $class
           ) . '.php';
    }
});
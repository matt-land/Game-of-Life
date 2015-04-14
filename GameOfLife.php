#!/usr/bin/php
<?php
/**
 * Created by IntelliJ IDEA.
 * User: blitzcat
 * Date: 11/15/14
 * Time: 9:49 AM
 */
require_once __DIR__ . '/src/autoload.php';

use GameOfLife\Models\Controller;
use GameOfLife\Models\Board;

$board = new Board(
    isset($argv[1]) ? $argv[1] : shell_exec('tput lines'),
    isset($argv[2]) ? $argv[2] : shell_exec('tput cols')-1
);
$controller = new Controller($board);
$controller->run();

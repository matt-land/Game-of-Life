#!/usr/bin/php
<?php
/**
 * Created by IntelliJ IDEA.
 * User: blitzcat
 * Date: 11/15/14
 * Time: 9:49 AM
 */
require_once __DIR__ . '/src/autoload.php';

use GameOfLife\Models\Game;

Game::run(
    isset($argv[1]) ? $argv[1] : 80,
    isset($argv[2]) ? $argv[2] : 24
);
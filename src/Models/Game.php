<?php namespace GameOfLife\Models;
/**
 * Created by IntelliJ IDEA.
 * User: blitzcat
 * Date: 4/12/15
 * Time: 2:16 PM
 */

class Game
{
    public static function run($width, $height)
    {
        //restore the terminal on shutdown
        register_shutdown_function(function() {
            shell_exec('reset');
        });

        //ask initial state
        echo "Conway's Game of Life " . PHP_EOL
            . "1. Random" . PHP_EOL
            . "2. Blinker" . PHP_EOL
            . "3. Square" . PHP_EOL;
        $initialState = readline("Which initial state?");

        //make STDIN not block
        stream_set_blocking(STDIN, false);

        $controller = new Controller($height, $width);

        switch ($initialState) {
            case 3:
                $controller->setInitialStateSquare();
                break;
            case 2:
                $controller->setInitialStateBlinker();
                break;
            case 1:
            default:
                $controller->setInitialStateRandom();
                break;
        }
        echo $controller->show();
        while (true) {
            if (fgets(STDIN)) {
                $controller->setInitialStateRandom();
            } else {
                $controller->runAGeneration();
            }
            echo $controller->show();
            usleep(100000);
        }
    }
}
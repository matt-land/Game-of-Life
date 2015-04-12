<?php namespace GameOfLife\Models;
/**
 * Created by IntelliJ IDEA.
 * User: blitzcat
 * Date: 4/12/15
 * Time: 2:16 PM
 */

class Game
{
    public static function run(ControllerInterface $controller)
    {
        //make STDIN not block
        stream_set_blocking(STDIN, false);

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
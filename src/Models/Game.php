<?php namespace GameOfLife\Models;
/**
 * Created by IntelliJ IDEA.
 * User: blitzcat
 * Date: 4/12/15
 * Time: 2:16 PM
 */

class Game
{
    const UPDATE_FREQUENCY = 3333;

    private static $nextRenderTime;

    public static function run(ControllerInterface $controller)
    {
        //make STDIN not block
        stream_set_blocking(STDIN, false);

        self::$nextRenderTime = ((microtime(true) * 10000) + self::UPDATE_FREQUENCY);

        //controls update speed
        $nextRender = function () use ($controller) {

            while (self::$nextRenderTime - (microtime(true) * 10000) > 0) {
                usleep(10000);
            }
            self::$nextRenderTime += self::UPDATE_FREQUENCY;
            echo $controller->show();

            return;
        };

        $nextRender();

        //just keep running while listening for input
        while (true) {
            if (fgets(STDIN)) {
                $controller->setInitialStateRandom();
            } else {
                $controller->runAGeneration();
            }
            $nextRender();
        }
    }
}
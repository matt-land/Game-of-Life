<?php namespace GameOfLife\Models;
/**
 * Created by IntelliJ IDEA.
 * User: blitzcat
 * Date: 4/12/15
 * Time: 1:59 PM
 */

class Controller implements ControllerInterface
{
    const UPDATE_FREQUENCY = 3333;

    private static $nextRenderTime;

    /**
     * @var Board GameOfLife\Models\Board
     */
    private $currentBoard;

    public function __construct(Board $board)
    {
        $this->currentBoard = $board;
    }

    public function setInitialStateSquare()
    {
        $this->currentBoard->setCellLive(1,1);
        $this->currentBoard->setCellLive(1,2);
        $this->currentBoard->setCellLive(2,1);
        $this->currentBoard->setCellLive(2,2);
    }

    public function setInitialStateBlinker()
    {
        $this->currentBoard->setCellLive(0,1);
        $this->currentBoard->setCellLive(1,1);
        $this->currentBoard->setCellLive(2,1);
    }

    public function setInitialStateRandom()
    {
        for ($posX = 0; $posX < $this->currentBoard->getLength(); $posX++) {
            for ($posY = 0; $posY < $this->currentBoard->getWidth(); $posY++) {
                rand (0,1) ? $this->currentBoard->setCellLive($posX, $posY) : $this->currentBoard->setCellDead($posX, $posY);
            }
        }
    }

    public function runAGeneration()
    {
        $this->currentBoard = $this->currentBoard->buildNextGeneration();
    }

    public function show()
    {
        return (string) $this->currentBoard;
    }

    public function run()
    {
        //make STDIN not block
        stream_set_blocking(STDIN, false);

        self::$nextRenderTime = ((microtime(true) * 10000) + self::UPDATE_FREQUENCY);

        //controls update speed
        $nextRender = function () {

            while (self::$nextRenderTime - (microtime(true) * 10000) > 0) {
                usleep(10000);
            }
            self::$nextRenderTime += self::UPDATE_FREQUENCY;
            echo $this->show();

            return;
        };

        $nextRender();

        //just keep running while listening for input
        while (true) {
            if (fgets(STDIN)) {
                $this->setInitialStateRandom();
            } else {
                $this->runAGeneration();
            }
            $nextRender();
        }
    }
}
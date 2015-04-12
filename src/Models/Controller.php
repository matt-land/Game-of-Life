<?php namespace GameOfLife\Models;
/**
 * Created by IntelliJ IDEA.
 * User: blitzcat
 * Date: 4/12/15
 * Time: 1:59 PM
 */

class Controller
{
    /**
     * @var Board GameOfLife\Models\Board
     */
    private $currentBoard;

    public function __construct($length = 4, $width = 4)
    {
        $this->currentBoard = new Board($length, $width);
    }

    public function setInitialStateSquare()
    {
        $this->currentBoard->setLive(1,1);
        $this->currentBoard->setLive(1,2);
        $this->currentBoard->setLive(2,1);
        $this->currentBoard->setLive(2,2);
    }

    public function setInitialStateBlinker()
    {
        $this->currentBoard->setLive(0,1);
        $this->currentBoard->setLive(1,1);
        $this->currentBoard->setLive(2,1);
    }

    public function setInitialStateRandom()
    {
        for ($i = 0 ; $i < $this->currentBoard->length; $i++) {
            for ($j = 0 ; $j < $this->currentBoard->width; $j++) {
                rand (0,1) ? $this->currentBoard->setLive($i, $j): $this->currentBoard->setDead($i, $j);
            }
        }
    }

    public function runAGeneration()
    {
        $this->currentBoard = $this->currentBoard->nextGeneration();
    }

    public function show()
    {
        return (string) $this->currentBoard;
    }
}
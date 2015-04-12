<?php
/**
 * Created by IntelliJ IDEA.
 * User: blitzcat
 * Date: 4/12/15
 * Time: 2:00 PM
 */

namespace GameOfLife\Models;
use GameOfLife\Models\CellRules\DeadCellRules;
use GameOfLife\Models\CellRules\LivingCellRules;
class Board
{
    public $array = array();
    public  $length;
    public  $width;

    public function __construct($length, $width)
    {
        $this->length = $length;
        $this->width = $width;
        for ($i = 0 ; $i < $length; $i++) {
            for ($j = 0 ; $j < $width; $j++) {
                $this->array[$i][$j] = 0 ; //rand (0,1);
            }
        }
    }

    public function  __toString()
    {
        $string = chr(27) . "[2J" . chr(27) . "[;H"; //clear the screen
        for ($i = 0 ; $i < $this->length; $i++) {
            for ($j = 0 ; $j < $this->width; $j++) {
                $string .=  chr(27) . ($this->stateCheck($i , $j) ? "[47m".chr(27)."[30m0" : "[40m ");
            }
            $string .= PHP_EOL;
        }

        return $string . chr(27)."[39m".chr(27)."[49m";
    }

    public function NeighborCount($posX, $posY)
    {
        return
            $this->stateCheck($posX -1, $posY -1) +
            $this->stateCheck($posX -1, $posY -0) +
            $this->stateCheck($posX -1, $posY +1) +
            $this->stateCheck($posX -0, $posY -1) +
            // skip middle sq
            $this->stateCheck($posX -0, $posY +1) +
            $this->stateCheck($posX +1, $posY -1) +
            $this->stateCheck($posX +1, $posY -0) +
            $this->stateCheck($posX +1, $posY +1);
    }

    public function stateCheck($posX, $posY)
    {
        if (! isset($this->array[$posX][$posY])) {
            return false;
        }
        return $this->array[$posX][$posY];
    }

    private function updateLifeStatus($posX, $posY, $boolState)
    {
        if (! isset($this->array[$posX][$posY])) {
            return;
        }
        $this->array[$posX][$posY] = (int) $boolState;
    }

    public function setLive($posX, $posY)
    {
        self::updateLifeStatus($posX, $posY, 1);
    }

    public function setDead($posX, $posY)
    {
        self::updateLifeStatus($posX, $posY, 0);
    }

    public function nextGeneration()
    {
        $nextBoard = new self($this->length, $this->width);
        for ($i = 0 ; $i < $this->length; $i++) {
            for ($j = 0; $j < $this->width; $j++) {
                //do something
                $cell = $this->stateCheck($i, $j) ? new LivingCellRules() : new DeadCellRules();
                $nextBoard->updateLifeStatus(
                    $i,
                    $j,
                    $cell->nextGenerationLifeStatus(
                        $this->NeighborCount($i, $j)
                    )
                );
            }
        }
        return $nextBoard;
    }
}
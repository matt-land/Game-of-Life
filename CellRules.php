<?php
/**
 * Created by IntelliJ IDEA.
 * User: blitzcat
 * Date: 11/15/14
 * Time: 9:49 AM
 */

namespace Model;
date_default_timezone_set('America/Los_Angeles');

class Controller
{
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
        $string = '';
        for ($i = 0; $i< 2*$this->length; $i++) {
            $string .= '_';
        }
        $string .= PHP_EOL;
        for ($i = 0 ; $i< $this->length; $i++) {
            for ($j = 0 ; $j < $this->width; $j++) {
                $string .= ($this->stateCheck($i , $j) ? "0" : " ") . " ";
            }
            $string .= PHP_EOL;
        }

        return $string;
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

abstract class cellRules {
    public function nextGenerationLifeStatus($neighborCount)
    {
        return 0;
    }
}
class LivingCellRules extends cellRules {
    public function nextGenerationLifeStatus($neighborCount)
    {
        if ($neighborCount == 2) {
            return 1;
        }
        if ($neighborCount == 3) {
            return 1;
        }
        parent::nextGenerationLifeStatus($neighborCount);
    }
}
class DeadCellRules extends cellRules {
    public function nextGenerationLifeStatus($neighborCount)
    {
        if ($neighborCount == 3) {
            return 1;
        }
    }
}
class cellTest// extends \PHPUnit_Framework_TestCase
{
    public function testUnderPopulation()
    {
        $cell = new LivingCellRules();
        $neighbors = 1;
        $this->assertEquals(0, $cell->nextGenerationLifeStatus($neighbors));

        $cell = new DeadCellRules();
        $neighbors = 1;
        $this->assertEquals(0, $cell->nextGenerationLifeStatus($neighbors));
    }

    public function testSurvival()
    {
        $cell = new LivingCellRules();
        $this->assertEquals(1, $cell->nextGenerationLifeStatus(2), 'tested 2');
        $cell = new LivingCellRules();
        $this->assertEquals(1, $cell->nextGenerationLifeStatus(3), 'tested 3');
    }

    public function testOverCrowding()
    {
        $cell = new LivingCellRules();
        $this->assertEquals(0, $cell->nextGenerationLifeStatus(4), 'tested 4');
        $this->assertEquals(0, $cell->nextGenerationLifeStatus(8), 'tested 8');
        $this->assertEquals(0, $cell->nextGenerationLifeStatus(6), 'tested 6');
    }

    public function testUnderCrowdedDead()
    {
        $cell = new DeadCellRules();
        $this->assertEquals(0, $cell->nextGenerationLifeStatus(2));
    }

    public function testReproduction()
    {
        $cell = new DeadCellRules();
        $this->assertEquals(1, $cell->nextGenerationLifeStatus(3));
    }


    public function testBoardIsEmpty()
    {
        $board = new Board(4, 4);
        for ($i = 0; $i < 4; $i++) {
            for ($j = 0; $j < 4; $j++) {
                $this->assertEquals(0, $board->stateCheck($i, $j));
            }
        }

    }
    public function testBoardSetter()
    {
        $board = new Board(4, 4);
        $board->setLive(1,1);
        $this->assertEquals(1, $board->stateCheck(1,1));
        $board->setLive(1,2);
        $this->assertEquals(1, $board->stateCheck(1,2));
        $board->setLive(2,1);
        $this->assertEquals(1, $board->stateCheck(2,1));
        $board->setLive(2,2);
        $this->assertEquals(1, $board->stateCheck(2,2));
    }

    public function testSetState()
    {
        $board = new Board(3, 3);
        $board->setLive(2,2);
        $this->assertEquals(1, $board->stateCheck(2,2));
    }

    public function testAskNeighbors()
    {
        $board = new Board(3, 3);
        $this->assertEquals(0, $board->NeighborCount(1,1));
        $this->assertEquals(0, $board->NeighborCount(2,2));

        $board = new Board(4, 4);
        $board->setLive(1,1);
        $board->setLive(1,2);
        $board->setLive(2,1);
        $board->setLive(2,2);
        $this->assertEquals(3, $board->NeighborCount(2,2));
    }

    public function testOneGeneration()
    {
        $controller = new Controller();
        $controller->setInitialStateSquare();
        $before = $controller->show();
        $controller->runAGeneration();
        $this->assertEquals($before, $controller->show());
    }

    public function testTenGenerations()
    {
        $controller = new Controller();
        $controller->setInitialStateSquare();
        $before = $controller->show();
        for ($i = 0; $i < 10; $i++) {
            $controller->runAGeneration();
        }
        $this->assertEquals($before, $controller->show());
    }

//    public function testBlinkerGenerations()
//    {
//        $controller = new Controller();
//        $controller->setInitialStateBlinker();
//        $string = $controller->show();
//
//        for ($i = 0; $i < 4; $i++) {
//            $controller->runAGeneration();
//            $string .= $controller->show();
//        }
//        $this->fail($string);
//    }
    public function testRandomGenerations()
    {
        $controller = new Controller(20,20);
        $controller->setInitialStateRandom();
        $string = $controller->show();

        for ($i = 0; $i < 10; $i++) {
            $controller->runAGeneration();
            $string .= $controller->show();

        }
        $this->fail($string);
    }
}

function runSample()
{
    $controller = new Controller(20,20);
    $controller->setInitialStateRandom();
    echo $controller->show();

    for ($i = 0; $i < 1000; $i++) {
        usleep(100000);
        $controller->runAGeneration();
        echo $controller->show();

    }
    //$this->fail($string);
}
runSample();
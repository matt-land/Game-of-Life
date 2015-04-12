<?php
/**
 * Created by IntelliJ IDEA.
 * User: blitzcat
 * Date: 4/12/15
 * Time: 2:13 PM
 */
date_default_timezone_set('America/Los_Angeles');

class cellTest// extends \PHPUnit_Framework_TestCase
{


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
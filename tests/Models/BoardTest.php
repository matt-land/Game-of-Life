<?php namespace GameOfLifeTest\Models;
/**
 * Created by IntelliJ IDEA.
 * User: blitzcat
 * Date: 4/12/15
 * Time: 3:35 PM
 */
use GameOfLife\Models\Board;

class BoardTest extends \PHPUnit_Framework_TestCase
{
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
}
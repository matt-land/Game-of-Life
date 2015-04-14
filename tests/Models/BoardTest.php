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
                $this->assertEquals(0, $board->getCellStatus($i, $j));
            }
        }

    }

    public function testBoardSetter()
    {
        $board = new Board(2, 2);
        $board->setCellLive(0,0);
        $this->assertEquals(true, $board->getCellStatus(0,0));
        $board->setCellLive(0,1);
        $this->assertEquals(true, $board->getCellStatus(0,1));
        $board->setCellLive(1,0);
        $this->assertEquals(true, $board->getCellStatus(1,0));
        $board->setCellLive(1,1);
        $this->assertEquals(true, $board->getCellStatus(1,1));
    }

    public function testSetState()
    {
        $board = new Board(3, 3);
        $board->setCellLive(2,2);
        $this->assertEquals(true, $board->getCellStatus(2,2));
    }

    public function testAskNeighbors()
    {
        $board = new Board(3, 3);
        $this->assertEquals(false, $board->NeighborCount(1,1));
        $this->assertEquals(false, $board->NeighborCount(2,2));

        $board = new Board(4, 4);
        $board->setCellLive(1,1);
        $board->setCellLive(1,2);
        $board->setCellLive(2,1);
        $board->setCellLive(2,2);
        $this->assertEquals(3, $board->NeighborCount(2,2));
    }
}
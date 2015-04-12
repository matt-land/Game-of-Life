<?php namespace GameOfLifeTest\Models;
/**
 * Created by IntelliJ IDEA.
 * User: blitzcat
 * Date: 4/12/15
 * Time: 3:37 PM
 */

use GameOfLife\Models\Controller;
class ControllerTest extends \PHPUnit_Framework_TestCase
{
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

    public function testRandomGenerations()
    {
        $controller = new Controller(20,20);
        $controller->setInitialStateRandom();

        $string = $controller->show();

        for ($i = 0; $i < 10; $i++) {
            $controller->runAGeneration();
            $string .= $controller->show();

        }
    }
}
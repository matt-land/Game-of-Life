<?php namespace GameOfLifeTest\Models\CellRules;
/**
 * Created by IntelliJ IDEA.
 * User: blitzcat
 * Date: 4/12/15
 * Time: 3:26 PM
 */
use GameOfLife\Models\CellRules\LivingCellRules;
use GameOfLife\Models\CellRules\DeadCellRules;

class CellRulesTest extends \PHPUnit_Framework_TestCase
{
    public function testUnderPopulation()
    {
        $cell = new LivingCellRules();
        $neighbors = 1;
        $this->assertEquals(false, $cell->nextGenerationLifeStatus($neighbors));

        $cell = new DeadCellRules();
        $neighbors = 1;
        $this->assertEquals(false, $cell->nextGenerationLifeStatus($neighbors));
    }

    public function testSurvival()
    {
        $cell = new LivingCellRules();
        $this->assertEquals(true, $cell->nextGenerationLifeStatus(2), 'tested 2');
        $cell = new LivingCellRules();
        $this->assertEquals(true, $cell->nextGenerationLifeStatus(3), 'tested 3');
    }

    public function testOverCrowding()
    {
        $cell = new LivingCellRules();
        $this->assertEquals(false, $cell->nextGenerationLifeStatus(4), 'tested 4');
        $this->assertEquals(false, $cell->nextGenerationLifeStatus(8), 'tested 8');
        $this->assertEquals(false, $cell->nextGenerationLifeStatus(6), 'tested 6');
    }

    public function testUnderCrowdedDead()
    {
        $cell = new DeadCellRules();
        $this->assertEquals(false, $cell->nextGenerationLifeStatus(2));
    }

    public function testReproduction()
    {
        $cell = new DeadCellRules();
        $this->assertEquals(true, $cell->nextGenerationLifeStatus(3));
    }
}
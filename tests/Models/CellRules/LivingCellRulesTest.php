<?php
/**
 * Created by IntelliJ IDEA.
 * User: blitzcat
 * Date: 4/12/15
 * Time: 3:26 PM
 */
use GameOfLife\Models\CellRules\LivingCellRules;
use GameOfLife\Models\CellRules\DeadCellRules;

class LivingCellRulesTest extends PHPUnit_Framework_TestCase
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
}
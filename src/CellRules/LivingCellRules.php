<?php namespace GameOfLife\CellRules;
/**
 * Created by IntelliJ IDEA.
 * User: blitzcat
 * Date: 4/12/15
 * Time: 2:03 PM
 */

class LivingCellRules extends CellRules
{
    public static function nextGenerationLifeStatus($neighborCount)
    {
        if ($neighborCount === 2) {
            return true;
        }
        if ($neighborCount === 3) {
            return true;
        }
        return parent::nextGenerationLifeStatus($neighborCount);
    }
}
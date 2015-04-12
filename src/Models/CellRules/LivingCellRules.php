<?php namespace GameOfLife\Models\CellRules;
/**
 * Created by IntelliJ IDEA.
 * User: blitzcat
 * Date: 4/12/15
 * Time: 2:03 PM
 */

class LivingCellRules extends CellRules
{
    public function nextGenerationLifeStatus($neighborCount)
    {
        if ($neighborCount === 2) {
            return 1;
        }
        if ($neighborCount === 3) {
            return 1;
        }
        parent::nextGenerationLifeStatus($neighborCount);
    }
}
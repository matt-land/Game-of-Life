<?php namespace GameOfLife\Models\CellRules;
/**
 * Created by IntelliJ IDEA.
 * User: blitzcat
 * Date: 4/12/15
 * Time: 2:05 PM
 */

class DeadCellRules extends CellRules
{
    public function nextGenerationLifeStatus($neighborCount)
    {
        if ($neighborCount === 3) {
            return 1;
        }
    }
}
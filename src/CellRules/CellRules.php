<?php namespace GameOfLife\CellRules;
/**
 * Created by IntelliJ IDEA.
 * User: blitzcat
 * Date: 4/12/15
 * Time: 2:02 PM
 */
abstract class CellRules
{
    public static function nextGenerationLifeStatus($neighborCount)
    {
        return false;
    }
}
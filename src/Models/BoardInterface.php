<?php namespace GameOfLife\Models;
/**
 * Created by IntelliJ IDEA.
 * User: mland
 * Date: 4/13/15
 * Time: 9:33 PM
 */
interface BoardInterface
{
    public function setCellLive($posX, $posY);

    public function setCellDead($posX, $posY);

    public function getLength();

    public function getWidth();

    public function buildNextGeneration();

    public function show();
}
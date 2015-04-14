<?php namespace GameOfLife;
/**
 * Created by IntelliJ IDEA.
 * User: blitzcat
 * Date: 4/12/15
 * Time: 3:47 PM
 */

interface ControllerInterface
{
    public function setInitialStateRandom();

    public function setInitialStateBlinker();

    public function setInitialStateSquare();

    public function run();
}
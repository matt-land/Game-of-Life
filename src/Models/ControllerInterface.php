<?php
/**
 * Created by IntelliJ IDEA.
 * User: blitzcat
 * Date: 4/12/15
 * Time: 3:47 PM
 */

namespace GameOfLife\Models;


interface ControllerInterface {

    public function setInitialStateRandom();

    public function runAGeneration();

    public function show();

}
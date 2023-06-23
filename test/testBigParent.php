<?php

use bo\src\ChildClass;

class testBigParent extends \PHPUnit\Framework\TestCase
{

    public function testChild(){
        
        $childClass = \Mockery::mock('ChildClass')->makePartial();
        $childClass->shouldReceive('doesEverything')->andReturn('Some Result');

        $childClass->doesOneThing();
    }
}
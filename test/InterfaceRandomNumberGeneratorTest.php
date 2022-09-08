<?php
namespace bo\test;

use bo\src\RandomNumberGenerator;
use bo\src\UseGenerator;
use Mockery;
use PHPUnit\Framework\TestCase;

class InterfaceRandomNumberGeneratorTest extends TestCase{

    public function testABC()
    {
        $mock = Mockery::mock(RandomNumberGenerator::class);
        $mock->shouldReceive('generate')
        ->andReturn("4567");

        $use = new UseGenerator($mock);

        $this->assertEquals("ABCD4567", $use->preFix("abc"));
    }
}
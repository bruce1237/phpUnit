<?php declare(strict_types=1);

final class GreeterTest extends \PHPUnit\Framework\TestCase
{
    public function testGreetsWithName(): void
    {
        $greeter = new Greeter;
        $greeting = $greeter->greet('Alice');
        $this->assertSame('Hello, Alice!', $greeting);
        
        
    }
}
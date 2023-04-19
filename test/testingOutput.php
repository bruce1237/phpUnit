<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class testingOutput extends TestCase
{
    public  function testExpectFooActualFoo(): void
    {
        $this->expectOutputString('foo');
        
        print 'foo';
    }
    
    public function testExpectBarActualBaz(): void
    {
        $this->expectOutputString('bar');
        
        print 'baz';
    }
    
    public function testRegex():void
    {
        $this->expectOutputRegex('/^aaa/');
        
        print 'aaabc';
    }
    
    public function testEqu(): void
    {
        $this->expectOutputString('hi, there');
        
        echo 'hi, there';
    }
}
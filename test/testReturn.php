<?php
// vendor/phpunit/phpunit/phpunit --filter testR test/testReturn.php
use PHPUnit\Framework\TestCase;

class testReturn extends TestCase
{
    public function testR(){
        $mock = \Mockery::mock(MyClass::class);
        $mock->shouldReceive('someMethod')
             ->andReturnUsing(
                 function ($arg) {
                     if ($arg > 0) {
                         return 'Positive';
                     } else {
                         return 'Negative';
                     }
                 },
                 function ($arg) {
                     return $arg * 2;
                 },
                 function () {
                     return 'Fallback';
                 }
             );
        
        echo $result1 = $mock->someMethod(5);   // Returns "Positive"
        echo $result2 = $mock->someMethod(-2);  // Returns "Negative"
        echo $result3 = $mock->someMethod(10);  // Returns 20
        echo $result4 = $mock->someMethod(0);   // Returns "Fallback"
        $this->assertSame('Positive', $result1);
        $this->assertSame(-4, $result2);
        $this->assertSame('Fallback', $result3);
        $this->assertSame('Fallback', $result4);

        
    }
}


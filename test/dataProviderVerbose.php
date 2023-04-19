<?php declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class dataProviderVerbose extends TestCase
{
    /**
     * @dataProvider addition
     * @testdox Adding two numbers from the "addition" data set
     */
    public static function additionProvider(): array
    {
        return [
            'adding zeros' => [0, 0, 0],
            'zero plus one' => [0, 1, 1],
            'one plus zero' => [1, 0, 1],
            'one plus one' => [1, 1, 3],
        ];
    }

    #[DataProvider('additionProvider')]
    public function testAdd(int $a, int $b, int $expected): void
    {
        $this->assertSame($expected, $a + $b);
    }
    
   
    
    
    
    
      /**
     * @dataProvider dataProvider1
     * @depends testExample1
     */
    public function testWithDependency($a, $b, $expected)
    {
        $this->assertEquals($expected, $a + $b);
    }

    public static function dataProvider1()
    {
        return [
            [1, 2, 3],
            [4, 5, 8],
            [7, 8, 15],
        ];
    }

    public function testExample1()
    {
        $this->assertTrue(true);
    }

    /**
     * @depends testExample2
     * @dataProvider dataProvider2
     */
    public function testDependencyWithDataProvider($a, $b, $expected)
    {
        $this->assertEquals($expected, $a + $b);
    }

    public static function dataProvider2()
    {
        return [
            [1, 2, 3],
            [4, 5, 9],
            [7, 8, 15],
        ];
    }

    public function testExample2()
    {
        $this->assertTrue(true);
    }

}


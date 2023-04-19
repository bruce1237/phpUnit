<?php declare(strict_types=1);

final class dataProviders extends \PHPUnit\Framework\TestCase
{
    public static function additionProvider(): array
    {
        return [
            [0,0,0],
            [0,1,1],
            [1,0,1],
            [1,1,3],
        ];
    }
    
    #[\PHPUnit\Framework\Attributes\DataProvider('additionProvider')]
    public function testAdd(int $a, int $b, int $expected): void
    {
        $this->assertSame($expected, $a + $b);
    }
}
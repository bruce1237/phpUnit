<?php declare(strict_types=1);

final class ExceptionsTest extends \PHPUnit\Framework\TestCase
{
    public function testException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode('Code');
        $this->expectExceptionMessage('ExpectionMessages');
//        expectExceptionMessageMatches() only asserts that the acutal message contains the $expected message
        $this->expectExceptionMessageMatches('ExpectionMessage');
        
    }
}
<?php

use PHPUnit\Framework\TestCase;

final class DependencyAndDataProviderComboTest extends TestCase
{
    public function provider(): array
    {
        return [['provider1'], ['provider2']];
    }

    public function testProducerFirst(): void
    {
        $this->assertTrue(true);

        return 'first';
    }

    public function testProducerSecond(): void
    {
        $this->assertTrue(true);

        return 'second';
    }

    /**
     * @depends testProducerFirst
     * @depends testProducerSecond
     * @dataProvider provider
     */
    public function testConsumer(): void
    {
        $this->assertSame(
            ['provider1', 'first', 'second'],
            func_get_args()
        );
    }
}

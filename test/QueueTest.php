<?php
namespace bo\test;

use bo\src\Queue;
use Exception;
use PHPUnit\Framework\TestCase;

class QueueTest extends TestCase{

    private Queue $queue;

    protected function setUp(): void
    {
        $this->queue = new Queue();
    }

    public function testIsEmpty()
    {
        $this->assertTrue($this->queue->isEmpty());
    }
    public function testNonEmptyQueue()
    {
        $this->queue->add("Dave");
        $this->assertFalse($this->queue->isEmpty());
    }

    public function testSize()
    {
        $this->assertEquals(0,$this->queue->size());
    }

    public function testExceptionThrow()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Can not pop empty queue");
        $this->queue->pop();
    }

}
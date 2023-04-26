<?php

use PHPUnit\Framework\TestCase;

final class stackTest extends TestCase
{
    public function testEmpty()
    {
        $stack = [];
        $this->assertEmpty($stack);
        return $stack;
    }

    /**
     * depends testEmpty
     * 
     * @depends testEmpty
     *
     * @param array $stack
     * @return array
     */
    public function testPush(array $stack): array
    {
        array_push($stack, 'foo');
        $this->assertSame('foo', $stack[count($stack) - 1]);
        $this->assertNotEmpty($stack);

        return $stack;
    }

    /**
     * depends testPush
     * @depends testPush
     *
     * @param array $stack
     * @return void
     */
    public function testPop(array $stack): void
    {
        $this->assertSame('foo', array_pop($stack));
        $this->assertEmpty($stack);
    }
}

/**
 * in the example above, the first test, `testEmpty()`, creates a new array as asserts that it is empty. 
 * the test then returns the fixture as its result. 
 * the second test `testPush()`, depends on `testEmpty()` and is passed the result of that depended-upon test as its argument. 
 * finally, `testPop()` depends upon `testPush()`.
 */

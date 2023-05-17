<?php
use PHPUnit\Framework\TestCase;

class testOrder extends TestCase
{
    public function testOrderedMethodGroups()
    {
        // 创建一个 Mock 对象
        $mock = \Mockery::mock('MyClass');

        // 设置方法调用的期望顺序和组，并指定返回值
        $mock->shouldReceive('method1')->ordered('Group1')->andReturn('Result 1');
        $mock->shouldReceive('method2')->ordered('Group1')->andReturn('Result 2');
        $mock->shouldReceive('method3')->ordered('Group2')->andReturn('Result 3');
        $mock->shouldReceive('method4')->ordered('Group2')->andReturn('Result 4');
        $mock->shouldReceive('method5')->ordered('Group3')->andReturn('Result 5');
        $mock->shouldReceive('method6')->ordered('Group3')->andReturn('Result 6');

        // 调用方法，并使用断言来验证返回值
        $result1 = $mock->method1();
        $this->assertEquals('Result 1', $result1);

        $result2 = $mock->method2();
        $this->assertEquals('Result 2', $result2);

        $result3 = $mock->method3();
        $this->assertEquals('Result 3', $result3);

        $result4 = $mock->method4();
        $this->assertEquals('Result 4', $result4);

        $result5 = $mock->method5();
        $this->assertEquals('Result 5', $result5);

        $result6 = $mock->method6();
        $this->assertEquals('Result 6', $result6);
    }
    public function testOrderedMethodCalls()
    {
        // 创建一个 Mock 对象
        $mock = \Mockery::mock('MyClass');

        // 设置方法调用的期望顺序，并指定返回值
        $mock->shouldReceive('method1')->ordered()->andReturn('Result 1');
        $mock->shouldReceive('method2')->ordered()->andReturn('Result 2');
        $mock->shouldReceive('method3')->ordered()->andReturn('Result 3');

        // 调用方法，并使用断言来验证返回值
        $result1 = $mock->method2();
        $this->assertEquals('Result 2', $result1);

        $result2 = $mock->method1();
        $this->assertEquals('Result 1', $result2);

        $result3 = $mock->method3();
        $this->assertEquals('Result 3', $result3);
    }
}
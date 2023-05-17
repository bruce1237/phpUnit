<?php
// vendor/phpunit/phpunit/phpunit --filter testR test/testReturn.php
use PHPUnit\Framework\TestCase;

class testReturn extends TestCase
{
    public function testR()
    {
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

    public function OrderedMethodCalls()
    {
        $mock = \Mockery::mock('MyClass');

        $mock->shouldReceive('method1')->ordered()->andReturn('Result 1');
        $mock->shouldReceive('method2')->ordered()->andReturn('Result 2');

        $mock->shouldReceive('group1')->ordered('group')->andReturn('Group Result 1');
        $mock->shouldReceive('group2')->ordered('group')->andReturn('Group Result 2');

        Mockery::globally()->shouldReceive('globalMethod')->ordered()->andReturn('Global Result');

        // 调用方法并断言返回值
        $result1 = $mock->method1();
        $this->assertEquals('Result 1', $result1);

        $result2 = $mock->method2();
        $this->assertEquals('Result 2', $result2);

        $groupResult1 = $mock->group1();
        $this->assertEquals('Group Result 1', $groupResult1);

        $groupResult2 = $mock->group2();
        $this->assertEquals('Group Result 2', $groupResult2);

        // $globalResult = globalMethod();
        // $this->assertEquals('Global Result', $globalResult);
    }

    public function testOrderedQueries(){
        $db = \Mockery::mock('db');
        $db->shouldReceive('startup')->once()->ordered();
        $db->shouldReceive('query')->with('CPWR')->andReturn(12.3)->once()->ordered('queries');
        $db->shouldReceive('query')->with('MSFT')->andReturn(10.0)->once()->ordered('queries');
        $db->shouldReceive('query')->with(\Mockery::pattern("/^....$/"))->andReturn(3.3)->atLeast()->once()->ordered('queries');
        $db->shouldReceive('finish')->once()->ordered();

        $a = $db->query('CPWR');
        $b = $db->query('MSFT');
        $this->assertSame(12.3, $a);
        $this->assertSame(10.0, $b);
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

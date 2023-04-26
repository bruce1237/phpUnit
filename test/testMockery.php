<?php

use PHPUnit\Framework\TestCase;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use PhpParser\Node\Expr\Instanceof_;

// Simple Example

/**
 * imagine we have a Temperature class which samples the temperature of a locale
 * before reporting an average temperature. the data could come from 
 * a web service or any other data source, but we do not have such a class at present. 
 * we can however, assume some basic interactions with such a class based 
 * on its interaction with such a class based on its interaction with the Temperature class
 */

class Temperature
{
    private $service;

    public function __construct($service)
    {
        $this->service = $service;
    }


    public function average()
    {
        $total = 0;
        for ($i = 0; $i < 3; $i++) {
            $total += $this->service->readTemp();
        }
        return $total / 3;
    }
}


class TemperatureTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testGetsAverageTemperatureFromThreeServiceReadings()
    {
        $service = Mockery::mock('service');
        $service->shouldReceive('readTemp')
            ->times(3)
            ->andReturn(10, 12, 14);

        $temperature = new Temperature($service);

        $this->assertEquals(12, $temperature->average());
    }
}

/**
 * Intergrate Mockery with PHPUnit either 
 */

// 1.
class MyTest extends MockeryTestCase
{
}
// 2.
class MyTest2 extends TestCase
{
    use MockeryPHPUnitIntegration;
}

/**
 * Creating a test double
 */

$testDouble = \Mockery::mock('MyClass');

/**
 * creating a test double that implements a scertain interface:
 */

$testDouble = \Mockery::mock('myClass, MyInterface');

/**
 * Expecting a method to be called on a test double
 */

$testDouble = Mockery::mock('MyClass');
$testDouble->shouldReceive('foo');

/**
 * Expecting a method to NOT be called on a test double
 */

$testDouble->shouldNotReceive('foo');

/**
 * expecting a method to be called on a test double, 
 * once, with a certain argument, and to return a value
 */

$testDouble->shouldReceive('foo')
    ->once()
    ->with($arg)
    ->andReturn($returnValue);

/**
 * expecting a method to be called on a test double
 * and to return a different value for each successive call
 */

$mock->shoudReceive('foo')
    ->andReturn(1, 2, 3);
$mock->foo(); //int(1);
$mock->foo(); //int(2);
$mock->foo(); //int(3);

/**
 * creating a runtime partial test double
 */

$mock = Mockery::mock('MyClass')->makePartial();



class MyClass
{
    public function foo()
    {
        return "foo";
    }

    public function bar()
    {
        return "bar";
    }
}

class MyClassTest extends TestCase
{
    public function testMakePartial(): void
    {
        $myClassMock = Mockery::mock(MyClass::class)->makePartial();
        $myClassMock->shouldReceive('foo')->andReturn('mockedFoo');

        $this->assertEquals('mockedFoo', $myClassMock->foo());
        $this->assertEquals('bar', $myClassMock->bar());
    }
}

/**
 * creating a SPY
 */

$spy = Mockery::spy('MyClass');
//  expecting that a spy should ahve received a method call
$spy->foo();
$spy->shouldHaveReceived()->foo();

/**
 * Creating a mock object to return a sequence of values from a set of method calls
 */

class SimpleTest extends MockeryTestCase
{
    public function testSimpleMock()
    {
        $mock = Mockery::mock(['pi' => 3.1416, 'e' => 2.71]);
        $this->assertEquals(3.1416, $mock->pi());
        $this->assertEquals(2.71, $mock->e());
    }
}

/**
 * creating a mock object wich returns a self-chaining undefined object for a method call
 * andReturnUndefined() will not return any value or throw exception
 * 
 */

class UnderfinedTest extends MockeryTestCase
{
    public function testUnderfinedValues()
    {
        $mock = Mockery::mock('MyMock');
        $mock->shouldReceive('divideBy')->with(0)->andReturnUndefined();
        $this->assertTrue($mock->divideBy(0) instanceof \Mockery\Undefined);
    }
}

/**
 * creating a mock object with multiple query calls and a single update call
 */

class DbTest extends MockeryTestCase
{
    public function testDbAdapter()
    {
        $mock = Mockery::mock('db');
        $mock->shoudReceive('query')->andReturn(1, 2, 3);
        $mock->shouldReceive('update')->with(5)->andReturn(NULL)->once();
    }
}


/**
 * expecting all queries to be executed before any updates
 * using ordered to make sure the call in the order, query() first, 
 * then update()
 */

class DbTest2 extends MockeryTestCase
{
    public function testQueryAndUpdateOrder()
    {
        $mock = Mockery::mock('db');
        $mock->shouldReceive('query')->andReturn(1, 2, 3)->ordered();
        $mock->shouldReceive('update')->andReturn(NULL)->ordered();
    }
}


/**
 * creating a mock object where all queries occur after start up, but before finish
 * and where queries are expected with several different params
 * ordered('queries'), 'queries' is the name of the order group
 */

 class DbTest3 extends MockeryTestCase
 {
    public function testOrderedQueries(){
        $db = Mockery::mock('db');
        $db->shouldReceive('startup')->once()->ordered();
        $db->shouldReceive('query')->with('CPWR')->andReturn(12.3)->once()->ordered('queries');
        $db->shouldReceive('query')->with('MSFT')->andReturn(10.0)->once()->ordered('queries');
        $db->shouldReceive('query')->with(\Mockery::pattern("/^....$/"))->andReturn(3.3)->atLeast()->once()->ordered('queries');
        $db->shouldReceive('finish')->once()->ordered();
    }
 }
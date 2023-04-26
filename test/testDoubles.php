<?php

declare(strict_types=1);

use Mockery\Matcher\Subset;
use PharIo\Version\AbstractVersionConstraint;
use PHPUnit\Event\Code\Test;
use PHPUnit\Event\Test\MockObjectForAbstractClassCreated;
use PHPUnit\Framework\TestCase;


/************************
 ******** STUB **********
 *************************/


final class SomeClass
{
    public function doSomething(Dependency $dependency): string
    {
        $result = '';
        return $dependency->doSomething();
    }
}

interface Dependency
{
    public function doSomething(): string;
}


final class SomeClassTest extends TestCase
{
    public function testDoesSomething(): void
    {
        $sut = new SomeClass;

        // create a test stub for the dependency interface
        $dependency = $this->createStub(Dependency::class);

        //configure the test stub
        $dependency->method('doSomething')
            ->willReturn('foo');

        //if the interface or the class has a function called method, then using the following
        $stub->expects($this->any())->method('doSomething')->willReturn('foo');

        $result = $sut->doSomething($dependency);
        $this->assertStringEndsWith('foo', $result);
    }
}


// createConfiguredStub

interface Dependency2
{
    public function doSomething(): string;
    public function doSomethingElse(): string;
}


final class CreateConfiguredStubExampleTest extends TestCase
{
    public function testCreateConfiguredStub(): void
    {
        $o = $this->createConfiguredStub(
            Dependency2::class,
            [
                'doSomething' => 'foo',
                'doSomethingElse' => 'bar',
            ]
        );

        $this->assertSame('foo', $o->doSomething());

        $this->assertSame('abr', $o->doSomethingElse());
    }
}

// createStubForIntersectionOfInterfaces
interface X
{
    public function m(): bool;
}

interface Y
{
    public function n(): int;
}

final class z
{
    public function doSomething(X&Y $input): bool
    {
        $result = false;

        return $result;
    }
}


final class StubForIntersectionExapleTest extends TestCase
{
    public function testCreateStubForIntersection(): void
    {
        $o = $this->createStubForIntersectionOfInterfaces(
            [
                X::class,
                Y::class,
            ]
        );

        $this->assertInstanceOf(X::class, $o);
        $this->assertInstanceOf(Y::class, $o);
    }
}

// returnArgument()
/**
 * sometimes you want to return one of the arugments of a method call(uncahnged) 
 * as the result of a stubbed method call by using returnArgument() 
 * instead of returnValue()
 */

final class ReturnArgumentExampleTest extends TestCase
{
    public function testReturnArgumentStub(): void
    {
        // create a stub for the someClass class
        $stub = $this->createStub(SomeClass::class);

        // configure the stub
        $stub->method('doSomething')
            ->will($this->returnArgument(0)); //return the first arguement

        $this->assertSame('foo', $stub->doSomething('foo'));

        $this->assertSame('bar', $stub->doSomething('bar'));
    }
}

// returnSelf()
/**
 * when testing a fluent interface, it is sometimes useful to have a stubbed method return a reference
 * to the stubbed object. 
 */

final class ReturnSelfExampleTest extends TestCase
{
    public function testReturnSelf(): void
    {
        $stub = $this->createStub(SomeClass::class);

        // configure the stub
        $stub->method('doSomething')
            ->will($this->returnSelf());

        $this->assertSame($stub, $stub->doSomething());
    }
}

//  returnValueMap()
/**
 * sometimes a stubbed method should return different values depending on 
 * a predefined list of arguments. 
 */

final class ReturnValueMapExampleTest extends TestCase
{
    public function testReturnValueMapStub(): void
    {
        $stub = $this->createStub(SomeClass::class);

        // create a map of argumens to return values
        $map = [
            ['a', 'b', 'c', 'd'],
            ['e', 'f', 'g', 'h'],
        ];

        // configure the stub
        $stub->method('doSomething')
            ->will($this->returnValueMap($amp));

        // $stub->doSomething() returns different values depending on the provided arguments
        $this->assertSame('d', $stub->doSomething('a', 'b', 'c'));
        $this->assertSame('h', $stub->doSomething('e', 'f', 'g'));
    }
}

// returnCallback()
/**
 * when the stubbed method call should return a calculated value instead of a fixed one(see returnValue())
 * or an (unchanged) argument(see returnArgument()), you can use 'returnCallback()' to have the stubbed method 
 * return the result of a callback function or method
 */

final class ReturnCallbackExampleTest extends TestCase
{
    public function testReturnCallbackStub(): void
    {
        $stub = $this->createStub(SomeClass::class);

        // configure $stub
        $stub->method('doSomething')
            ->will($this->returnCallback('str_rot13')); //str_rot13, using the 13th char to replace the 1st char, and so on

        $this->assertSame('fbzrguvat', $stub->doSomething('something'));
    }
}

//  onConsecutiveCalls()
/**
 * a simple alternative to setting up a callback method may be to specify a list
 * of desired return values.
 */

final class OnConsecutiveCallsExampleTest extends TestCase
{
    public function testOnConsecutiveCallsStub(): void
    {
        $stub = $this->createStub(SomeClass::class);

        $stub->method('doSomething')
            ->will($this->onConsecutiveCalls(2, 3, 5, 7));

        $this->assertSame(2, $stub->doSomething());
        $this->assertSame(3, $stub->doSomething());
        $this->assertSame(5, $stub->doSomething());
    }
}

// throwException()
/**
 * instead of returning a value, stubbed method can also raise an exception.
 */

final class ThrowExceptionExampleTest extends TestCase
{
    public function testThrowExceptionStub(): void
    {
        $stub = $this->createStub(SomeClass::class);

        $stub->method('doSomething')
            ->will($this->throwException(new Exception));

        $stub->doSomething();
    }
}



/************************
 ******** MOCK **********
 ************************/

/**
 * the practice of replacing an object with a test double that verifies expectations, 
 * for instance asserting that a method has been called, is referred to as Mocking
 * you can use a mock object as an observation point that is used to verify the indirect outputs of
 * the SUT(System Under Test) as it is exercised. Typically, the mock object also includes
 * the functionality of a test stub in that it must return values to the SUT if it hasn't already
 * failed the tests but the emphasis is on the verification of the indirect outputs. there fore, 
 * a mock object is a lot more than just a test stub plus assertions. it is used in a fundamentally different way
 */

// createMock()
/**
 * `createMock(string $type) returns a mock object for the specified type. 
 * the creation of this mock object is performed using the best practice defaults:
 * the `__construct()` and `__clone()` methods of the original class are not executed and the arguments passed to
 * a method of the test double will not be cloned.
 * 
 * if these defaults are not what you need then you can use the `getMockBuilder(string $type)` 
 * method to customize the test double generation using a fluent interface
 * 
 * by default, all methods of the original class are replaced with an implementation that returns an
 * automatically generated value that satisfies the method's return type declaration(without calling the original method).
 * furthermore, expectations for invocations of these method
 * ("method must be called with specified arguments", "method must not be called) can be configured.
 * 
 * here is an example, suppose we want to test that the correct method, `update()` in our example, 
 * is called on an object that observes another object, 
 * here is the code for the subject class and the observer interface that are part of the system under test
 */

final class Subject
{
    private array $observers = [];
    public function attach(Observer $observer): void
    {
        $this->observers[] = $observer;
    }

    public function doSomething(): void
    {
    }

    private function notify(string $argument): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($argument);
        }
    }
}

interface Observer
{
    public function update(string $argument): void;
}

final class SubjectTest extends TestCase
{
    public function testObserversAreUpdated(): void
    {
        $observer = $this->createMock(Observer::class);

        $observer->expects($this->once())
            ->method('update')
            ->with($this->identicalTo('something'));

        $subject = new Subject();
        $subject->attach($observer);
        $subject->doSomething();
    }
}

/**
 * Explanation
 * we first use the `createMock()` method to create a mock object for the `Observer`
 * 
 * because we are interested in verifying the communication between two objects(
 * theat a method is called and which artguments it is called with), we use the `expects()` and `with()` methods 
 * to specify  what this communication should look like
 * 
 * The `with()` method can take any number of arguments, corresponding to the number of 
 * arguments to the method being mocked. you can specify more advanced constratints on the 
 * method's arugments than a simple match.
 * 
 * constraints shows the constraints that can be applied to method arguments and here is s list of 
 * matchers that are available to specify the number of invocations:
 * 
 * * any() returns a matcher that matches when the method it is evaluated for is executed zero or more times
 * 
 * * never() returns a matcher that matches when the method it is evaluated for is never executed
 * 
 * * atLeastOnce() returns a matcher that matches when the method it is evaluated for is executed at least once
 * 
 * * once() returns a matcher that matches when the method it is evaluated for is executed exactly once
 * 
 * * exactly(int $count) returns a matcher that matches when the method it is evaluated for is executed exactly $count times
 * 
 */



//  createMockForInstersectionOfInterfaces()

interface A
{
    public function a(): bool;
}

interface B
{
    public function b(): int;
}

final class C
{
    public function c(A&B $ab): bool
    {
        $result = false;
        return $result;
    }
}

final class MockForIntersectionExampleTest extends TestCase
{
    public function testCreateMockForIntersection(): void
    {
        $o = $this->createMockForIntersectionOfInterfaces([A::class, B::class]);

        $this->assertInstanceOf(A::class, $o);
        $this->assertInstanceOf(B::class, $o);
    }
}

// createConfiguredMock()

final class CreateConfiguredMockExampleTest extends TestCase
{
    public function testCreateConfiguredMock(): void
    {
        $o = $this->createConfiguredMock(
            SomeInterface::class,
            [
                'doSomething' => 'foo',
                'doSomethingElse' => 'bar',
            ]
        );

        $this->assertSame('foo', $o->doSomething());
        $this->assertSame('bar', $o->doSomethingElse());
    }
}


// Abstract Class and Traits

/**
 * the 'getMockForAbstractClass()` method returns a mock object for an abstract class.
 * all abstract methods of the given abstract class are mocked. 
 * this allows for testing the concrete methods of an abstract class
 */

abstract class AbstractClass
{
    public function concreteMethod()
    {
        return $this->abstractMethod();
    }

    abstract public function abstractMethod();
}


final class AbstractClassTest extends TestCase
{
    public function testConcerteMethod(): void
    {
        $stub = $this->getMockForAbstractClass(AbstractClass::class);

        $stub->expects($this->any())
            ->method('abstractMethod')
            ->will($this->returnValue(true));

        $this->assertTrue($stub->concreteMethod());
    }
}


// getMockForTrait()

/**
 * the method returns a mock object that uses a specified trait. all abstract method of the given trait are mocked, 
 * this allows for testing the concerte methods of a trait
 */

 trait AbstractTrait
 {
    public function concreteMethod()
    {
        return $this->abstractMethod();
    }

    abstract public function abstractMethod();
 }


 final class AbstractTraitTest extends TestCase
 {
    public function testConcreteMethod(): void
    {
        $mock = $this->getMockForTrait(AbstractTrait::class);
        
        $mock->expects($this->any())
        ->method('abstractMethod')
        ->will($this->returnValue(true));

        $this->assertTrue($mock->concreteMethod());
    }
 }


//  Web Services

/**
 * when your application interacts with a web service you want to test it without actually interacting
 * with the web service. to create subs and mocks of web services, the `getMockFromWsdl()` method
 * can be used.
 * 
 * this method returns a test stub based on a web service description in WSDL whereas `createStub()`
 * for instance, returns a test stub based on an interface or on a class
 */

 final class WsdlStubExampleTest extends TestCase
 {
    public function testWebserviceCanBeStubbed(): void
    {
        $service = $this->getMockFromWsdl(__DIR__.'/HelloService.wsdl');
         $service->method('sayHello')
         ->willReturn('Hello');

         $this->assertSame('Hello', $service->sayHello('message'));
    }   
 }

//  MockBuilder API

/**
 * as mentioned before, when the defaults used by the createSub() and createMock() methods
 * to generate the test double do not match your needs then you can use the getMockBuilder($type)
 * method to customize the test double generation using a fluent interface. 
 * here is a a list of methods provided by the mock builder
 * 
 * * onlyMethods(array $methods)   can be called on the Mock builder object to specify the methods 
 *   that are to be replaced with a configurable test double. the behavior of the other method is 
 *   not changed. each method must exist in the given mock class
 * 
 * * addMethods(array $methods)   can be called on the mock builder object to specify the methods
 *   that don't exist(yet) in the given mock class. the behavior of the other methods remains the same
 * 
 * * setConstructorArgs(array $args)    can be called to provide a parameter array that is passed to the orignal class'
 *   constructor (which is not replaced with a dummy implementation by default)
 * 
 * * setMockClassName($name)   can be used to specify a class name for the generated test double class
 * 
 * *disableOriginalConstructor()   can be used to disable the call to the original class' constructor
 * 
 * * enableOriginalConstructor()   can be used to enable the call to the original class' conctructor
 * 
 * * disableOriginalClone()
 * * enableOriginalClone()   can be sued to disable/enable the call to the original class' clone constructor
 * 
 * * disableAutoload()
 * * enableAutoload()   can be used to disable/enable __autoload() during the generation of the test double class
 * 
 * * disableArgumentCloning()
 * * enableArgumentCloning() can be used to disable/enable the cloning of arguments passed to mocked
 * 
 * * enableProxyingToOriginalMethods()
 * * disableProxyingToOriginalMethods() can be used to disable/enable the invocation of the original methods
 * 
 * * setProxyTraget() can be used to set the proxy target for the invocation of the original methods
 * 
 * * allowMockingUnknowTypes()
 * * disallowMockingUnknowTypes() can be used to allow/disallow the doubling of unknown types
 * 
 * * disableAutoReturnValueGeneration()
 * * enableAutoReturnValueGeneration() can be used to disable/enable the automatic generation of return values
 *   when  no return value is configured
 *  
 */

 final class MockBuilderExampleTest extends TestCase
 {
    public function testStub(): void
    {
        $stub = $this->getMockBuilder(SomeClass::class)
        ->disableOriginalClone()
        ->disableOriginalConstructor()
        ->disableArgumentCloning()  
        ->disallowMockingUnknownTypes()
        ->getMock();

        $stub->method('doSomething')
            ->willReturn('foo');

            $this->assertSame('foo', $stub->doSomething());
    }
 }
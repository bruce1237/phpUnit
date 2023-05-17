<?php

/**
 * Mockery's main goal is to help us create test doubles, it can create stubs, mocks and spies.
 * 
 * stubs and mocks are created the same. the difference between the two is that a stub only returns
 * a preset result when called, while a mock needs to have expectations set on hte method calls
 * it expects to receive.
 * 
 * Spies are a type of test doubles that keep track of the calls they received, 
 * and allow us to inspect these calls after the face
 * 
 * when creating a test double object, wd can pass in an identifier as a name for our test double.
 * if we pass it no identifier, the test double name will be unknown, Furthermore, the identifier does
 * not have to be a class name. it is a good practice, and our recommendation, to always name the test doubles
 * with the same name as the underlying class we are creating test doubles for.
 * 
 * if the identifier we use for our test double is a name of an existing class, the test double will 
 * inherit the type of the class(via inheritance), i.e. the mock object will pass type hints or instance of
 * evaluations for the existing class. this is useful when a test double must be of a specific type, 
 * to satisfy the expectations our code has. 
 */

//  Stubs and mocks

/**
 * stubs and mocks are created by call the `§Mockery::mock()` method. 
 */

$mock = \Mockery::mock('foo');

/**
 * the mock object created like this is the loosest form of mocks possible, and is an instance
 * `\Mockery\MockInterface`, 
 * All test doubles created with Mockery are an instance of `\Mockery\MockInterface` 
 * regardless are they a stub, mock or a spy.
 */


/**
 * to create a stub or a mock object with no name, we can call the mock() method 
 * with no parameters, this is not recommended
 */
$mock = \Mockery::mock();


//   Classes, abstracts interfaces

/**
 * the recommended way to create a stub or a mock object is by using a name of an existing class
 * we want to create a test double of:
 */

$mock = \Mockery::mock('MyClass');

/**
 * this stub or mock object will have the type of MyClass, through inheritance.
 * stub or mock objects can be based on any concrete class, abstract class or even interface. 
 * the primary purpose is to ensure the mock object inherits a specific type for type hinting
 */

$mock = \Mockery::mock('MyInterface');

/**
 * classes marked final, or classes that have methods marked final cannot be mocked fully. 
 * mockery supports creating partial mocks for these cases.
 * 
 * Mockery also supports creating stub or mock objects based on a single existing class, which must 
 * implement one or more interfaces. we can do this by providing a comma-separated list of the class
 * and interfaces as teh first argument to the \Mockery::mock() method
 * this stub or mock object will now be of type MyClass and implements MyInterface and OtherInterface interfaces
 * 
 * the class name doesn't need to be the first member of the list but it's a friendly convention
 * to use for readability.
 */

$mock = \Mockery::mock('MyClass, MyInterface, OtherInterface');

// we can tell a mock to implement the desired interfaces by passing the list of interfaces as the second argument
// this is same as above   
$mock = \Mockery::mock('MyClass', 'MyInterface, OtherInterface');


// Spies

/**
 * the third type of test doubles mockery supports are spies. the main difference between spies and mock objects is that
 * spies we verify the calls made against our test double after the calls were made. 
 * we would use a spy when we don't necessarily care about all the calls that are going to be made to an object
 * 
 * a spy will return `null` for all method calls it receives. it is not possible to tell a spy what will be the 
 * return value of a method call. if we do that, then we would deal with a mock object, and not with a spy
 */

//  create a spy by calling the \Mockery::spy()  method
$spy = \Mockery::spy('MyClass');

/**
 * just as with stubs or mocks, we can tell mockery to base a spy on any concrete or abstract class, 
 * or to implement any number of interfaces
 */

$spy = \Mockery::spy('MyClass, MyInterface, OtherInterface');

/**
 * this spy will now be of type MyClass and implement the MyInterface and OtherInterface
 * 
 * The \Mockery::spy() method call is actually a shorthand for calling 
 * \Mockery::mock()->shoudIgnoreMissing().  the shouldIgnoreMissing method
 * is a behaviour modifier.
 */

//  Mocks VS Spies

// let's try and illustrate the difference between mocks and spies with the following example

$mock = \Mockery::mock('MyClass');
$spy = \Mockery::spy('MyClass');

$mock->shouldReceive('foo')->andReturn(42);

$mockResult = $mock->foo();
$spyResult = $spy->foo();

$spy->shouldHaveReceived()->foo();

var_dump($mockResult); //int(42)
var_dump($spyResult); //null

/**
 * as we can see from this example, with a mock object we set the call expectations before the call itself.
 * and we get the return result we expect it to return. with a spy object on the other hand,
 * we verify the call has happened after th4e fact(call). the return result of a method call against a spy is 
 * always null
 */


//  Partial Test Doubles

/**
 * partial doubles are useful when we want ot stub out, set expectations for or spy on some methods
 * of a class, but run the actual code for  other methods
 * 
 * we differentiate between three types of partial test doubles:
 * - runtime partial test doubles,
 * - generated partial test doubles 
 * - proxied partial test doubles
 */

//  Runtime partial test doubles
/**
 * what we call a runtime partial, involves creating a test double and then telling it to make 
 * itself partial. any method calls that the double hasn't been toald to allow or expect, will act 
 * as they would on a normal instance of the object
 */

class Foo
{
function foo()
{
return 123;
}
function bar()
{
return $this->foo();
}
}
$foo = mock(Foo::class)->makePartial();
$foo->foo(); //int(123);

// we can then tell the test double to allow or expect calls as with any other Mockery double

$foo->shouldReceive('foo')->andReturn(456);
$foo->bar(); //int(456);

// generated Partial test doubles
/**
 * the second type of partial double we can create is what we call a generated partial.
 * with generated partials, we specifically tell Mockery which methods we want to be able to allow
 * or expect calls to. all other methods will run the actual code directly, so stubs and expectations on these
 * methods will not work.
 */

class Foo
{
function foo()
{
return 123;
}
function bar()
{
return $this->foo();
}
}

$foo = mock("Foo[foo]");

$foo->foo(); //error, no expectation set

$foo->shouldReceive('foo')->andReturn(456);
$foo->foo(); //int(456);

// setting an expectation for this has no effect, as it not been mocked
$foo->shouldReceive('bar')->andReturn(999);
$foo->bar(); //int(456)

/**
 * it's also possible to specify explicitly which methods to run directly using the !method syntax
 */

class Foo
{
function foo()
{
return 123;
}
function bar()
{
return $this->foo();
}
}
$foo = mock("Foo[foo]");
$foo->foo(); //int(123)
$foo->bar(); //error, no expectation set

/**
 * even though we support generated partial test doubles, we do not recommend using them
 * 
 * one of the reasons why is because a generated partial will call the original constructor of the
 * mocked class. this can have unwanted side-effects during testing application code.
 */



//  Proxied partial test doubles
/**
 * we may encounter a class wihich is simply not capable of being mocked bacause it has been marked as final. 
 * simiarly, we may find a class with methods marked as final. in such a scenario, we cannot simply extends
 * the class and override method to mock.  so we create the following
 */

$mock = \Mockery::mock(new MyClass);

/**
 * yes, the new mock is a proxy. it intercepts calls and reroutes them to the proxied object
 * which we construct and pass in for methods which are not subject to any expectations. 
 * indirectly, this allows us to mock methods marked final since the proxy is not subject ot those limitations.
 * the tradeoff should be obvious- a proxied partial will fail any typehint checks for the class being mocked since it can not extend the class
 */

//   Aliasing
/**
 * prefixing the valid name of a class (which is NOT currently loaded) with `alias:`
 * will generate an 'alias mock', alias mocks create a class alias with the given classname to stdClass and are
 * generally used to enable the mocking of public static methods. expectations set on the new mock object which 
 * refer to static methods will be used by all static calls to this class
 * 
 * this is NOT recommended
 */

$mock = \Mockery::mock('alias:MyClass');

//  Overloading
/**
 * prefixing the valid name of a class (which is not currently loaded) with `overload:` will generate
 * a alias mock except that created new instances of the class will import any expectations set on the origin mock($mock)
 * the origin mock is never verified since it's used oan expectation store for new instances
 * for this purpose we use term 'instance mock' to differentiate it from the simple 'alias mock'
 * 
 * in other words, an instance mock will intercept when a new instance of the mocked class is created
 * then the mock will be used instead. this is useful especially when mocking hard dependencies.
 */
$mock = \Mockery::mock('overload:MyClass');
/**
 * using alias/instance mocks across more than one test will generate a fatal error since we can 't have two classes of the same name
 * to avoid this, run each test of this kind in a separate PHP process
 */


//  Named Mocks
/**
 * the namedMock() method will generate a class called by the first argument, so in this example 
 * MyCalssName. the rest of the arguments are treated in the same way as the mock method
 */
$mock = \Mockery::namedMock('MyClassName', 'DateTime');

/**
 * this example would create a class called MyClassName that extends DateTime
 * 
 * named mocks are quite an edge case, but they can be useful when code depends on 
 * the __CLASSS__ magic constant, or when we need two dervatives of an abstract type, 
 * that are actually different classes
 * 
 * we can only create a named mock once, any subsequent calls to namedMock with different
 * arguments are likely to cause exceptions
 */

//  Constructor arguments
/**
 * sometimes the mocked class has required constructor arguments. we can pass these to Mockery
 * as an indexed array, as the 2nd argument
 */
$mock = \Mockery::mock('MyClass', [$constructorArg1, $constructorArg2]);

/**
 * or is we need the MyClass to implement an interface as well, as the 3red arguments
 */
$mock = \Mockery::mock('MyClass', 'MyInterface', [$constructorArg1, $constructorArg2]);

/**
 * Mockery now know to pass in $constructorArg1 and $constructorArg2 as arguments to the constructor.
 */

//  Behavior Modifiers
/**
 * we creating a mock object, we may wish to use some commonly preferred behaviours that 
 * are not the default in mockery.
 * 
 * the use of the `shouldIgnoreMissing()` behaviour modifier will label this mock obnject as a passive mock
 */

\Mockery::mock('MyClass')->shouldIgnoreMissing();

/**
 * in such a mock object, calls to methods which are not covered by expectations will return null 
 * instead of the usual error about there being no expectation matching the call.
 * 
 * on PHP >=7.0 methods with missing expectations that have a return type will return either
 * a mock of the object(if return type is a class) or a 'falsy' primitive value, e.g. empty string, 
 * empty array, zero for ints and floats, false for bools or empty closures
 * 
 * on PHP >=7.1, methods with missing expectations and nullable return type will return null
 * 
 * we can optionally prefer to return an object of type \Mockery\Underfined i.e., a null object
 * which was the 0.7.2 behaviour by using an additional modifier.
 */
\Mockery::mock('MyClass')->shouldIgnoreMissing()->asUnderfined();
/**
 * the returned object is nothing more than a placeholder so if, by some act of fate, it's
 * erroneously used somewhere it shouldn't it will likely not pass a logic check.
 * 
 * we have encountered the makePartial() method before, as it is the method we use to create runtime partial test doubles
 */
\Mockery::mock('MyClass')->makePartial();
/**
 * this form of mock object will defer all methods not subject to an expectation to the parent class
 * of the mock. i.e. MyClass, whereas the previous shouldIgnoreMissing() returned null, this behaviour simply calls the parent's matching method.
 */

//  Expectation Declarations
/**
 * in order for our expectations to work we must call Mockery::close(), preferably in a callback
 * method such as tearDown or _after(depending on whether or not we're integrating mockery with another framework)
 * this static call cleans up the mockery container used by the current test, and run any verification tasks needed for our expectations.
 * 
 * once we have created a mock object, we'll often want to start defining how exactly it should behave 
 * and how it should be called. this is where the mockery expectation declarations take over.
 */


//  Delcaring method call expectations
/**
 * to tell our test double to expect a call for a method with a given name, we use the
 * shouldReceive method
 */

$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('name_of_method');

/**
 * this is the starting expectation upon which all other expectations and constraints are appended
 * we can decare more than one method call to be expected
 */
$mock = \Mockery::mock('MyClass');
$mock->shouldReceive([
'name_of_method_1'=> 'return value1',
'name_of_method-2'=>'return value 2',
]);

// there's also a shorthand way of setting up method call expectations and their return values:
$mock = \Mockery::mock('MyClass', ['name_of_method_1'=> 'return value 1', 'name_of_method_2'=>'return value 2']);

// all of these will adopt any additional chained expectations or constraints
// we can declare that a test double should not expect a call to the given method name

$mock = \Mockery::mock('MyClass');
$mock->shouldNotReceive('name_of_method');
// this method is a convenience method for calling shouldReceive()->never()

// Declaring method argument expectations

/**
 * for every method we declare expectation ofr, we can add constraints that the defined expectations
 * apply only to the method calls that match the expect ed argument list:
 */
$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('name_of_method')->with($arg1, $arg2, ...);
// or
$mock->shouldReceive('name_of_method')->withArgs([$arg1, $arg2, ...]);

/**
 * we can add a lot more flexibility to argument matching using the built in matcher classes
 * for example, \Mockery::any() matches any argument passed to that position in the with() parameter list.
 * Mockery also allows hamcrest library matchers
 * for example, the hamcrest function anything() is equivlent to \Mockery::any()
 * 
 * it's important to note that this means all expectations attached only apply to the given method
 * when it is called with these exact arguments
 */



// Create a mock object
$mock = \Mockery::mock(MyClass::class);

// Set an expectation using `any()` for a method with any argument
$mock->shouldReceive('someMethod')
->with(Mockery::any())
->andReturn('Mocked result');

// Invoke the method on the mock object
$result = $mock->someMethod('value');

// Assert the result
echo $result; // Output: "Mocked result"


$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('foo')->with('Hello');
$mock->foo('Goodbye'); // throw a NoMatchingExpectationException
// this allows for setting up differing expectations based on the arguments provided to expected calls.

// Argument matching with closures
/**
 * instead of providing a built-in mathcer for each argument, we can provide a closure that matches
 * all passed arguments at once;
 */

$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('name_of_method')->withArgus(closure);

/**
 * The given closure receives all the arguments passed in the call to expected method. 
 * in this way, this expectation only applies to method calls where passed arguments make the closure evaluate to true
 */  
$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('foo')->withArgs(function ($arg)){
if($arg %2 == 0){
return true;
}
return false;
});
$mock->foo(4); //matches the expectation
$mock->foo(3); // throws a NoMatching ExpectationException

// Argument matching with some of given values
/**
 * we can provide expected arguments that match passed arguments when mocked method is called
 */

$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('name_of_method')
->withSomeOfArgs(arg1, arg2, arg3, ...);

/**
 * the given expected arguments order doesn't matter, check if expected values are included or not
 * but type should be matched
 */

$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('foo')
->withSomeOfArgs(1,2);

$mock->foo(1,2,3); //matches the expectation
$mock->foo(3,2,1); //matches the expectation (passed order doesn't matter)
$mock->foo('1','2'); // throws a NoMatchingExpectationException (type should be matched)
$mock->foo(3); // throws a NoMatchingExpectationException

// Any, or no arguments
/**
 * we can declare that the expectation matches a method call regardless of what arguments are passed
 */
$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('name_of_method')->withAnyArgs();

/**
 * this is set by default unless otherwise specified
 * we can declare that the expectation matches method calls with zero arguments
 */

$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('name_of_method')->withNoArgs();

//  Declaring return value Expectations
/**
 * for mock objects, we can tell Mockery what return values to return from the expected method calls.
 * using andReturn() method
 */ 

$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('name_of_method')->andReturn($value);

/**
 * this sets a value to be returned from the expected method call
 * 
 * it is possible to set up expectation for multiple return values. by providing a sequence of return values, 
 * we tell mockery what value to return on every subsequent call to the method
 */

$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('name_of_method')->andReturn($value1, $value2, ...);
// the first call will return $vlue1 and the second call will return $value2....

/**
 * if we call the method more times than the number of return values we declared, 
 * Mockery will return the final value for any subsequent method call
 */

$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('foo')->andReturn(1,2,3);
$mock->foo(); // int(1)
$mock->foo(); // int(2)
$mock->foo(); // int(3)
$mock->foo(); // int(3)

/**
 * same can be achieved using the alternative syntax
 */

$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('name_of_method')->andReturnValues([$value1, $value2, ...]);

/**
 * it accpets a simple array instead of a list of parameters. the order of return is determined by 
* the numerical index of the given array with the last array member being returned on all calls 
* once previous return values are exhausted
*
* the following two options are primarily for communicationh with test readers:
*/
$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('name_of_method')->andReturnNull();
// or
$mock->shouldReceive('name_of_method')->andReturn([null]);

/**
 * they mark the mock object method call as returning null or nothing
 * 
 * sometimes we want to calculate the return results of the method calls, based on the arguments
 * passed to the method. we can do that with the andReturnUsing() method which accepts one or 
 * more closure
 */

$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('name_of_method')->andReturnUsing(closure, ...);


public function testR(){
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
echo $result2 = $mock->someMethod(-2);  // Returns "-4"
echo $result3 = $mock->someMethod(10);  // Returns "Fallback"
echo $result4 = $mock->someMethod(0);   // Returns "Fallback"
$this->assertSame('Positive', $result1);
$this->assertSame(-4, $result2);
$this->assertSame('Fallback', $result3);
$this->assertSame('Fallback', $result4);



/**
 * Closures can be queued by passing them as extra parameters as for andReturn() 
 * Occasionally, it can be useful to echo back one of the arguments that a method is called, with. 
 * in this case we can use the anrReturnArg() method; the argument to be returned is specified by 
 * its index in the arguments list
 */

$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('name_of_method')->andReturnArg(1); 
// this return the second argument(index #1) from the list of arguments when the method is called.

/**
 * if we are mocking fluid interfaces, the following method will be helpful
 */

$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('name_of_method')->andReturnSelf();
// it sets the return value to the mocked class name


// Throwing Exceptions
/**
 * we can tell the method of mock objects to throw exception;
 */
$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('name_of_method')->andThrow(new \Exception);

/**
 * it will throw the given exception object wehen called
 * 
 * rather an object, we can ass in the exception class, message and or
 * code to use when throwing an exception from the mocked method
 */

$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('name_of_method')->andThrow('exception_name','message', 123456);

// Setting Public Properties
/**
 * used with an expectation so that when a matching method is called,
 * we can cause a mock object's public property to be set to a specified value, by suing andSet() or set()
 */
$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('name_of_method')->andSet($property, $value);
// or 
$mock->shouldReceive('name_of_method')->set($property, $value);

/**
 * In cases where  we want to call the real method of the class that was mocked
 * and return its result, the passthru() method tells the expectation to bypass a return queue;
 */
passthru()
/**
 * it allows expectation matching and call count validation to be applied against real methods while still
 * calling the real class method with the expected arguments
 */
class MyClass {
public function doSomething() {
// 这里有一些复杂的逻辑
return '结果';
}
}

$mock = \Mockery::mock(MyClass::class);
$mock->shouldReceive('doSomething')
->passthru();

$result = $mock->doSomething();
echo $result; // 输出：结果

/**
 * 在上面的示例中，我们有一个MyClass类，其中包含一个doSomething()方法。我们使用Mockery创建了MyClass的一个模拟对象。
 * 然后，我们使用shouldReceive()和passthru()方法设置了期望。这样可以调用实际的doSomething()方法，并返回实际的结果。
 * 通过使用passthru()，期望仍然进行匹配和调用次数验证，但会执行实际的方法。这在你想要测试实际方法的行为，同时仍然对模拟对象进行控制时非常有用。
 * 请注意，passthru()仅适用于部分模拟，其中某些方法被模拟，而其他方法允许在实际对象上执行。
 */


//  Declaring call count expectations
/**
 * besides setting expectations on the arguments of the method calls, and the return values of those same calls, 
 * we can set expectation on how many times should any method be called.
 * 
 * when a call count expectation is not met a \Mockery\Expectation\InvalidCountException will be thrown
 * 
 * it is absolutely required to call \Mockery::close() at the end of our tests for example in the tearDown() method of phpUnit,
 * otherwise Mockery will not verify the calls made against our mock objects 
 * 
 * we can declare that the expected method may be called zero or more times
 * 
 */

$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('name_of_method')->zeroOrMoreTimes();

/**
 * this is the default for all methods unless otherwise set
* to tell Mockery to expect an exact number of calls to a method, we can use the following
*/

$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('name_of_method')->times($n);
// where $n is the number of times the method should be called

/**
 * a couple of most common cases got their shorthand methods
 * to declare that the expected method must be called one time only ->once(); ->twice(); ->never();
 */

//  call count modifiers
/**
 * the call count expectations can have modifiers set
 * 
 * if we want to tell mockery the minimum number of times a method should be called, we use atLeast();
 */

$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('name_of_method')->atLeast()->times(3);

/**
 * atLeast()->times(3)  means the call must be called at least three times(given matching method args) but never less than three times
 * 
 * similary, we can tell Mockery the maximum number of times a method should be called, using atMost();
 */

$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('name_of_method')->atMost()->times(3);

/**
 * atMost()->times(3) means the call must be called no m ore than three times. if the method gets no calls at all, the expectation will still be met
 * we can also set a range of call counts using between()
*/

$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('name_of_method')->between($min, $max);

/**
 * this is actually identical to using atLeast()->times($min)->atMost()->times($max)
 * but is provided as a shorthand. it may be followed by a times() call with no parameter to preserve the APIs natural language readability
 */


 //  Multiple calls with different Expectations

/**
 * if a method is expected to get called multiple times with different arugments and/or return values we can simply repeat
 * the expectations. the same of course also works if we expect multiple calls to different methods
 */
$mock = \Mockery::mock('MyClass');
// expectations  for the first call
$mock->shouldReceive('name_of_method')->once()->with('arg1')->andReturn($value1)
// second onwards call to the same method
    ->shoudReceive('name_of_method')->once()->with('arg2')->andReturn($value2)
    ->shouldReceive('name_of_method')->once()->with('arg3')->andReturn($value3);

// Expectation Declaration Utilities
/**
 * Declares that this method is expected to be called in a specific order in relation to similary marked methods
 */
ordered()
/**
 * the order is dictated  by the order in which this modifier is actually used when setting up mocks
 * 
 * declares the method as belonging to an order group(which can be named or numbered). 
 * methods within a group can be called in any order, but the ordered 
 * calls from outside the group are ordered in relation to the grup
 */
ordered(group)
/** 
 * we can set up so that method1 is called before group1 which is in turn called before method2
 * 
 * when called prior to ordered() or ordered(group), it declares this ordering
 * to apply across all mock objects(not just the current mock)
*/
globally()
/**
 * this allows for dictating order expectations across multiple mocks
 * 
 * the byDefault() marks an expectation as a default. default expectations are applied unless a
 * non-default expectations is created
 */
beDefault()
/**
 * these later expectations immediately replace the previously defined default. 
 * this is useful so we can setup default mocks in our unit test setup()
 * and later tweak them in specific tests as needed
 * 
 * returns the current mock object from an expectation chain:
 */
getMock()
/**
 * useful where we prefer to keep mock setups as a single statement.
 */
$mock = \Mockery::mock('MyClass')->shouldReceive('foo')->anReturn(1)->getMocke()

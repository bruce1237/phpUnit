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
 * method such as tearDown or _after(depending on whenther or not we're integrating mockery with another framework)
 * this static call cleans up the mockery container used by the current test, and run any verification tasks needed for our expectations.
 * 
 */
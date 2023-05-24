<?php
// Creating Partial Mocks

/**
 * partial mocks are useful when we only need to mock several methods of an object leaving the 
 * remainder free to respond to calls normally(i.e. as implemented). Mockery implements three distinct
 * strategies fro creating partials. each has specific advantages and disadvantages so which strategy
 * we use will depend on our own preferences and the source code in need of mocking
 * 
 * 
 * we have previously talked a bit about partial test doubles, but we'd  like to expand on the subject
 * a bit here
 * 1. runtime partial test doubles
 * 2. generated partial test doubles
 * 3. proxied partial mock
 */


//  Runtime partial test doubles

/**
 * a runtime partial test double, also known as a passive partial mock, is a kind of a default state 
 * of being for a mocked object
 */

 $mock = \Mockery::mock('MyClass')->makePartial();
/**
 * with a runtime partial, we assume that all methods will simply defer to the parent class(MyClass)
 * original methods unless a method call matches a known expectation. if we have no matching 
 * expectation for a specific method call, that call is deferred to the clas being mocked. since the 
 * division between mocked and unmocked calls depends entirely on the expectations we define,
 * there is no need to define which methods to mock in advance.
 * 
*/


// Generated Partial Test Double
/**
 * a generated partial test double, also known as a traditional partial mock, defines ahead
 * of time which methods of a class are to be mocked and which are to be left unmocked(i.ed callable as normal)
 * the syntax for creating traditional mocks is 
 */
$mock = \Mockery::mock('MyClass[foo, bar');
/**
 * in hte above example, the foo() and bar() methods of MyClass will be mocked but no other
 * MyClass methods are touched. we will need to define expectations for the foo() and bar() methods to
 * dictate their mocked behaviour
 * 
 * Don't forget that we can pass in constructor arugments since unmocked method my reply on those
 */
$mock = \Mockery::mock('MyNamespace\MyClass[foo]', array($arg1, $arg2));
// even though we support generated partial test doubles, we do not recommend using them


// Proxied Partial Mock
/**
 * a proxied partial mock is a partial of last resort. we may encounter a class which is simply not
 * capable of being mocked because it has been marked as final. similarly, we may find a class with 
 * method mared as final. in such a scenario, we cannot simply extend the class and override methods to mock
 * we need to get create
 */
$mock = \Mockery::mock(new MyClass);

/**
 * yes, the new mock is a p roxy, it intercepts calls and reroutes them to the proxied object(which
 * we construct and pass in) for methods which are not subject to any expectations. indirectly, this allows us to
 * mock methods marked final since the proxy is not subject oto those limitations.
 * the tradeoff should be obvious - a proxied partial will fail and typehint checks for the class being mocked 
 * since it cannot extend that class
 */


//  Special Internal Cases
/**
 * all mock objects, with the exception of proxied partials, allows us to make any expectation call to
 * the underlying real class method using the passthru() expectation call. this will return values from
 * the real call and bypass any mocked return queue(which can simply be omitted obviously).
 * 
 * there is a fourth kind of mock reserved for internal use. this is automatically generated
 * when we attempt to mock a class containing methods marked final. since we cannot override
 * such methods, they are simply left unmocked. typically, we don't need to worry about this but
 * if we really really must mock a final method, the only possible means is through a proxied partial mock.
 * splFileInfo, for example, is a common class subject ot this form of automatic internal partial
 * since it contains public final methods used internally.
 */



// Mocking Protected methods
/**
 * by default, mockery does not allow mocking protected methods, we do not recommend mocking
 * protected methods, but there are cases when there is no other solution.
 * 
 * for those cases, we have the shouldAllowMockingProtectedMethods() method.
 * it instructs mockery to specifically allow mocking of protected methods, for that one class ony
 */

class MyClass{
    Protected function foo(){}
}

$mock = \Mockery::mock('MyClass')->shouldAllowMockingProtectedMethods();

$mock->shouldReceive('foo');



// Mocking Public Properties
/**
 * mockery allows us to mocker properties in several ways, one way is that we can set a public property
 * and its value on any mock object. the second is the we can use the expectation methods 
 * set() and andSet() to set property values if that expectation is ever met.
 * 
 */

//  Setting Public Properties
/**
 * Used with an expectation so that when a matching method is called, we can cause a mock object's public
 * property to be set to a specified value by using andSet() or set()
 */
$mock = \Mockery::mock('MyClass');

$mock->shouldReceive('name_of_method')->andSet($property, $value);
//or
$mock->shouldReceive('name_of_method')->set($property, $value);
/**
 * in cases where we want to call the real method of the class that was mocked and return its result,
 * the passthru() method tells the expectation to bypass a return queue
 */
passthru()
/**
 * it allows expectation matching and call count validation to be applied against real methods
 * while still calling the real class method with the expected arguments
 */


//  Declaring call Count expectations
/**
 * besides setting expectations on the arguments of the method calls, and the return values of those
 * same calls, we can set expectations on how many times should any method be called.
 * 
 * when a call count expectation is not met, a \Mockery\Expectation\InvalidCountException will
 * be thrown
 * 
 * it is absolutely required to call \Mockery::close() at the end of our tests, for example in the 
 * tearDown() method of PHPUnit. otherwise mockery will not verify the calls made against our mock
 * objects.
 * 
 * we can declare that the expected method may be called zero or more times
 */

$mock = \Mockery::mock('MyClass');
$mock->shouldRecieve('name_of_method')->zeroOrMoreTimes();

/**
 * this is the default for all methods unless otherwise set.
 * 
 * to tell Mockery to expect an exact number of calls to a method, we can use the following
 */
$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('name_of_method')->times($n);

/**
 * where $n is  the number of times the method should be called.
 * a couple of most common cases got their shorthand method
 * once()
 * twice()
 * never()
 */

//  Call count modifiers
/**
 * the call count expectations can have modifiers set
 * 
 * if we want to tell Mockery the minimum number of times a method should be called, we use
 * atLeast()
 */
$mock->shouldReceive('name_of_method')->atLeast()->times(3);

/**
 * if we want the maximum number of times a method should be called, 
 * using atMost()
 */
$mock->shouldReceive('name_of_method')->atMost()->times(3);

/**
 * we can also define a range of number of calls made
 * between($min, $max)
 * which is identical to 
 * atLeast()->times($min)->atMost()->times($max)
 */
$mock->shouldReceive('name_of_method')->between($min, $max);






// Mocking public Static Method
/**
 * static method are not called on real objects, so normal mock object can't mock them. 
 * mockery supports class aliased mocks, mocks representing a class name which would normally be loaded
 * (via autoloading or a require statement) in the system under test. these aliases block that loading
 * (unless via a require statement - so please use autoloading) and allow mockery to intercept static method
 * calls and add expectations for them
 * 
 * 
 * Aliasing
 * prefixing the valid name of a class (which is NOT currently loaded) with alias: will generate an alias mock.
 * alias mocks create a class alias with the given classname to stdClass and are 
 * generally used to enable the mocking of public static methods. expectations set on the new mock object 
 * which refer to static methods will be used by all static calls to this class
 */
$mock = \Mockery::mock('alias:MyClass');
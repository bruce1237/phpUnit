<?php
// Spies

/**
 * spies are a type of test doubles, but they differ from stubs or mocks in that, that the spies record
 * any interaction between the spy and the SUT, and allow us to make assertions against those interactions 
 * after the face
 * 
 * creating a spy means we don't have to set up expectations for every method call the double might 
 * receive during the test, some of which may not be relevant to the current test. a spy allows us to 
 * make assertions about the calls we care about for this test only, reducing the chances of
 * over specificaton and making our tests more clear
 * 
 * spies also allows us to follow the more familar arrage-act-assert or given-when-then style
 * within our tests. with mocks, we have to follow a less failiar style, something along the lines
 * of arrange-expect-act-assert, where we have to tell our mocks what to expect before we act on the SUT,
 * then assert that those expectations where met
 */
// arrange
$mock = \Mockery::mock('MyDependency');
$sut = new MyClass($mock);

//expect
$mock->shouldReceive('foo')->once()->with('bar');

//act
$sut->callFoo();

// assert
\Mockery::close();

/**
 * spies allow us to skip the edxpect part and move the assertion to after we have acted on the SUT,
 * usually making our tests more readable
 */
// arrange
$spy = \Mockery::spy('MyDependency');
$sut = new MyClass($spy);

// act
$sut->callFoo();

// assert
$spy->shouldHaveReceived()->foo()->with('bar');

/**
 * on hte other hand, spies are far less restrictive than mocks, meaning testws are usually less precise, 
 * as they let us get away with more. this is usually a good thing, they should on be as precisse as 
 * they need to be, but while spies make our tests more intent-revealing, they do tend to reveal less
 * abou tthe design of the SUT. if we're having to setup lots of expectations for a mock, in lots of 
 * different tests, our tests are trying to tell us something - the SUT is doing too much and probably
 * should be refactored. we don't get this with epies, they simply ignore the calls that aren't relevant to them
 * 
 * another downside to using spies is debugging. when a mock receives a call that it wasn't
 * expecting, it immediately throws an exception(failling fast), giving us a nice stack trace or 
 * possibly even invoking our dubugger. with spies, we're simply asserting calls were made after the fact, so if the 
 * wrong calls were made, we don't have quite the same just in time context we have witht he mock
 * 
 * finally, if we need to define a return value for our test doule, we can't do that with a spy, only with a mock object
 * 
 * NOTE:
 * This documentation page is an adaption of the blog post titled 'Mockery Spies"
 */



//  Spies Reference

/**
 * to verify that a method wasa called on a spy, use the shouldHaveReceived() method
 */
$spy->shouldHaveReceived('foo');

/**
 * to Verify that a method was not called on a spy use shouldNotHaveReceived() method
 */
$spy->shouldNotHaveReceived('foo');
// we can also do argument matching with spies
$spy->shouldHaveReceived('foo')->with('bar');
// argument matching is alos possible by passing in an array of arguments to match
$spy->shouldHaveReceived('foo',['bar']);
// although when verifying a method was not called, the argument matching can nonly be done by
// supplying the array of arguments as the 2nd argument to the shouldNotHaveReceived() method
$psy->shouldNotHaveReceived('foo',['bar']);

// this is due to Mockery'sinternals

// Finally, when expecting calls that should have been received, we can also verify the number of calls
$spy->shouldHaveReceived('foo')->with('bar')->twice();


// Alternative shouldReceive syntax

/**
 * in cases of spies, this only applies to the shouldHaveReceived() method
 */
$spy->shouldHaveReceived()->foo('bar');

$spy->shouldHaveReceived()->foo('bar')->twice(); //with numbers

// NOTE: unfortunately, due to limitations we can't support the same syntax for the shouldNotHaveReceived() method
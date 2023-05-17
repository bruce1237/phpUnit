<?php

// Alternative shouldReceive syntax

/**
 * as of mockery 1.0.0, we support calling method as we would call any php method, and not as
 * string arguments to Mockery should* methods
 * 
 * the two mockery methods tat enable this are allows() and expects().
 */


//  allows()
/**
 * we use allows() when we create a stubs for methods that return a predefined return value, but 
 * for these method stubs we don't care how many times or if at all, were they called
 */

$mock = \Mockery::mock('MyClass');
$mock->allows([
    'name_of_method_1' => 'return value',
    'name_of_method_2' => 'return value',
]);
// this is equivalent with the following shouldReceive syntax
$mock = \Mockery::mock('MyClass');
$mock->shouldReceive([
    'name_of_method_1' => 'return value',
    'name_of_method_2' => 'return value',
]);

/**
 * Note that with this format, we also tell mockery that we don't care about the arguments to the stubbed methods,
 * 
 * if we do care about the arguments, we would do it like this
 */
$mock->allows()
    ->name_of_method_1($arg1)
    ->andReturn('return value');

// this is equivalent with the following 'shouldReceive' syntax
$mock->shouldReceive('name_of_method_1')->with($arg1)->andReturn('return value');


// Expects
/**
 * we use expects() when we want to verify that a particular method was called
 */
$mock->expects()
    ->name_of_method_1($arg1)
    ->andReturn('return value');

// shoudReceive syntax
$mock->shouldReceive('name_of_method_1')
    ->once()
    ->with($arg1)
    ->andReturn('return value');

/**
 * by default expects() sets up an expectation that the method should be called once and once only
 * if we expect more than one call to the method, we can change that expectation
 */
$mock->expects()
    ->name_of_method_1($arg1)
    ->twice()
    ->andReturn('return value');
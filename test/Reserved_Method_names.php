<?php
// Reserved Method Names

/**
 * as you may have noticed, mockery uses a number of methods called directly on all mock objects, for 
 * example shouldReceive(). such methods are necessary in order to setup expectations on the given mock, 
 * and so they cannot be implemented on the classes or objects being mocked without creating
 * a method name collision(reported as PHP fatal error). the methods reserved by Mockery are:
 * 
 * * shouldReceive()
 * * shouldNotReceive()
 * * allows()
 * * expects()
 * * shouldAllowMockingMethod()
 * * shouldIgnoreMissing()
 * * asUndefined()
 * * shouldAllowMockingProtectedMethods()
 * * makePartial()
 * * shouldHaveReceived()
 * * shouldHaveBeenCalled()
 * *shouldNotHaveReceived()
 * * shouldNotHaveBeenCalled()
 * 
 * in addition, all mocks utilise a set of added methods and protected properties which can not exist
 * on the class or object being mocked. these are far less likely to cause collisions.
 * all properties are prefixed with _mockery and all method names with mockery_
 */


/**
 * GOTCHAS
 * 
 * Mocking objects in PHP has its limitations and gotchas. some Functionality can't be mocked or can't be mocked YET!
 * 
 * 1. classes containing public __wakeup() methods can be mocked but the mocked __wakeup() method will perform no actions and
 * cannot have expectations set for it. this is necessary since mockery must serialize and unserialize objects to avoid some __construct() instanity
 * and attempting to mock a __wakeup() method as normal leads to a BadMethodCallException being thrown
 * 
 * 2. mockery has two scenarios where real classes are replaced: instance mocks and alias mocks.
 * both will generate php fatal errors if the real classed is loaded, usually via a require or include statement.
 * only use these two mock types where autoloading is in place and where classes are not explicitly loaded on a pre-file bassis using require(), require_once(), etc
 * 
 * 3. internal PHP classes are not entirely capable of being fully analysed using reflection.
 * for example, reflection can not reveal details of expected parameters to the methods of such internal classes. as a result, there will 
 * be problems where a method parameter is defined to accept a value by reference (mockery can not detect this condition and will assume a pass by value
 * on tscalars and arrays). if references as internal calss method parameters are needed, you should use the 
 * \Mockery\Configuration::setInternalClassMethodParamMap() method, NOTE: however that internal class parameter overriding is not avaliable in PHP8 since incompatible signatures
 * have been reclassifred as fatal errors
 * 
 * 4.creating a mock implementing a certain interface with incorrect case in the interface name, and then creating a second mock implementing the same
 * interface, but this time with the correct case, will h ave underfined behavior due to PHP's class_exists and related functions being cases insensitive.
 * using the ::class keyword in PHP can help you avoid these mistake
 * 
*/
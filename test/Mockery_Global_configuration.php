<?php
// Mockery Global Configuration
/**
 * to allow for a degree of fine-tuning, mockery utilizes a singleton configuration object to store a 
 * small subset of core behaviours. the three currently present include:
 * 
 * * Option to allow/Disallow the mocking of methods which do not actually exist fulfilled(i.e. unused)
 * 
 * * Setter/Getter for added a parameter map for internal PHP class methods(reflection can't detect these automatically)
 * 
 * * option to drive if quick definitions should define a stub or a mock with an at least once expectation
 * 
 * be default, the first behaviour is enabled, of course, there are situtations where this can lead to unitended consequences. 
 * the mocking of non-existent methods may allow mocks based on real classes/objects to fall out of sync with the actual implementations,
 * especially when some degree of integration testing (testing of object wiring) is not being performed
 * 
 * you may allow or disallow this behaviour(whether for whole test suites or just select tests) by using the following call:
 * 
 */

\Mockery::getConfiguration()->allowMockingNonExistentMethods(bool);

/**
 * passing a true allows the behaviour, false disallows it. it takes effect immediately until switched back.
 * if the behaviour is detected when not allowed, it will result in an exception being thrown at that point. 
 * note that disallowing this behaviour should be carefully considered since it necessarily removes at least 
 * some of mockery's flexibility
 * 
 * the other tow methods are
 */

\Mockery::getConfiguration()->setInternalClassMethodParamMap($class, $method, array $paramMap);
\Mockery::getConfiguration()->getInternalClassMethodParamMap($class, $method)

/**
 * these are used to define parameters(i.e. the signature string of each) for the methods of internal PHP classes
 * (e.g. SPL or PECL extension classes like ext/mongo's mMongoCollection). Reflection can not analyze the parameters
 * of internal classes. Most of the time, you never need to do this. it's mainly needed where an internal class 
 * method uses pass-by-reference for a parameter you must in such cases ensure the parameter signature include 
 * the & symbol correctly as Mockery won't correctly add it automatically for internal classes. note that internal
 * class overriding is not available in PHP8. this is because incopatible signatures have been reclassified as fatal errors.
 * 
 * Finally there is the possibility to change what a quick definition produces. by default quick definitions create
 * stubs but you can change this behaviour by asking mockery to use at least once expectations
 */
\Mockery::getConfiguration()->getQuickDefinitions()->shouldBeCalledAtLeastOnce(bool)

/**
 * passing a ture allows the behaviour, false disallow it. it takes effect immediately until switched back. 
 * by doing so you can avoid the proliferating of quick definitioons that accumulate overtime in 
 * your code since the test would fail in case the at least once expectation is not fulfilled
 */

// Disabling reflection caching
/**
 * Mockery heavily uses 'reflection' to do it's job, to speed up things, mockery caches internally the 
 * information it gathers via reflection. in some cases, this caching can cause problems
 * 
 * the only known situation when this occurs is when PHPUNIT --static-backup option is uesed.
 * if you use --static-backup and you get an error that looks like the following
 * Error: Internal error: failed to retrieve the reflection object
 * we suggest turning off the reflection cache as so:
 */
\Mockery::getConfiguration()->disableReflectionCache()
/**
 * turning it back on can be done like so
 */
\Mockery::getConfiguration()->enableReflectionCache();
/**
 * in no other situation should you be required turn this reflection cache off
 */
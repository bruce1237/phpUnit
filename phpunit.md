
# `<phpunit>` Element

## `backupGlobals` attribute
---
**possible values: `true` or `false` default: `false`**

phpunit can optionally backup all global and super-global variables before each test and restore this backup after each test.

This attribute configures this operation for all tests. This configuration can be overridden using the `@backupGlobals` annotation on the test case class and test method level.

---
## ` backupStaticAttributes` attribute
---
**possible values: `true` or `false` default: `false`**

phpunit can optionally backup all static attributes in all declared classes before each test and restore this backup after each test.

---
## `bootstrap` attribute
---
this attribute configures the bootstrap script that is loaded before the tests are executed. This script usually only registers the autoloader callback that is used to load the code under test.

---
## `cacheResult` attribute
---
**possible values: `true` or `false` default: `true`**

This attribute configures the caching of test results. This caching is required for certain other features to work.

---
## `cacheResultFile` attribute
---
this attribute configures the file in which the test result cache is stored.

---
## `colors` attribute
---
**possible values: `true` or `false` default: `false`**

this attribute configures whether colors are used in pupunit output.

---
## `columns` attribute
---
**possible values: integer or string max default: 80**

this attribute configures the number of columns to use for progress output

---
## `convertDeprecationsToExceptions` attribute
---
**possible values: `true` or `false` default: `false`**

this attribute configures whether `E_DEPRECATED` and `E_USER_DEPRECATED` events triggered by the code under test are converted to an exception and mark the test as error.

---
## `convertErrorsToExceptions` attribute
---
**possible vales: `true` or `false` default: `true`**

this attribute configure whether `E_ERROR` and `E_USER_ERROR` events triggered by the code under test are converted to an exception and mark the test as error

---
## convertNoticesToExceptions` attribute
---
**possible vales: `true` or `false` default: `true`**

This attribute configures whether `E_STRICT` , `E_NOTICE` and `E_USER_NOTICE` events triggered by the code under test are converted to an exceptions and mark the test as error.

----
## `convertWarningToExceptions` attribute
----
**possible vales: `true` or `false` default: `true`**
this attribute configures whether  `E_WARNING` and `E_USER_WARNING` events triggered by the code under test are converted to an exception and mark the test as error.

---
## `forceCoversAnnotation` attribute
---
**possible vales: `true` or `false` default: `false`**

this attribute configures whether a test will be marked as risk when it does not have a covers annotation.

---
## `printerClass` attribute
---
**default: `PHPUnit\TextUI\DefaultResultPrinter`**

this attribute configures the name of a class that implements the `PHPUnit\TextUI\ResultPrinter` interface. an object of this class is used to print progress and test result.

---
## `printerFile` attribute
---
this attribute can be used to configure the path to the sourcecode file that declares the class configured with `printerClass` in case the class cannot be autoloaded.

---
## `processIsolation` attribute
---
**possible vales: `true` or `false` default: `false`**
this attribute configures whether each test should be run in a separate PHP process for increased isolation.

---
## `stopOnError` attribute
----
**possible vales: `true` or `false` default: `false`**

this attirbute configures whether the test suite execution should be stopped after the first test finished with status "error"


---
## `stopOnFailure` attribute
---
**possible vales: `true` or `false` default: `false`**

this attribute configures whether the test suite execution should be stopped after the first test finished with status "failure"

---
## `stopOnIncomplete` attribute
---
**possible vales: `true` or `false` default: `false`**
this attribute configures whether the test suite execution should be stopped after the first  test finished with status "incomplete".

---
## `stopOnRisky` attribute
---
**possible vales: `true` or `false` default: `false`**

this attribute configures whether the test suite execution should be stopped after the first test finished with status "risky".

---
## `stopOnSkipped` attribute
---
**possible vales: `true` or `false` default: `false`**

this attribute configures whether the test suite execution should be stopped after the first test finished with status "risky".

---
## `stopOnWarning` attribute
---
**possible vales: `true` or `false` default: `false`**

this attribute configures whether the test suite execution should be stopped after the first test finished with status "Warning".

---
## `stopOnDefect` attribute
---
**possible vales: `true` or `false` default: `false`**

this attribute configures whether the test suite execution should be stopped after the first test finished with status "Error", "failure", "risky" or "warning".

---
## `failOnIncomplete` attribute
---
**possible vales: `true` or `false` default: `false`**

this attribute configures whether the PHPUit test runner should exit with a shell exit code that indicates failure when all tests are successful but there are tests that were marked as incomplete.

---
## `failOnRisky` attribute
---
**possible vales: `true` or `false` default: `false`**

this attribute configures whether the Phpunit test runner should exit with a shell exist code that indicates failure when all tests are successful but there are tests that were marked as risky.

---
## `failOnSkipped` attribute
---
**possible vales: `true` or `false` default: `false`**
this attribute configures whether the Php unit test runner should exit with aa shell exit code that indicates failure when all tests are successful but there are tests that were marked as kipped

---
## `failOnWarning` attribute
---
**possible vales: `true` or `false` default: `false`**
this attribute configures whether the Php unit test runner should exit with aa shell exit code that indicates failure when all tests are successful but there are tests that had warnings


---
## `stopOnDefect` attribute
---
**possible vales: `true` or `false` default: `false`**

This attribute configures whether the test suite execution should be stopped after the first test finished with a status "error", "failure", risky" or "warning"

---
## `failOnIncomplete` attribute
---
**possible vales: `true` or `false` default: `false`**

This attribute configures whether the PHPUnit test runner should exit with a shell exit code that indicates failure when all tests are successful but there are tests that were marked as incomplete.

---
## `failOnRisky` attribute
---
**possible vales: `true` or `false` default: `false`**

this attribute configures whether the PHPUnit test runner should exit with a shell exit code that indicates failure when all tests are successful but there are tests that were marked as risky

---
## `failOnSkipped` attribute
---
**possible vales: `true` or `false` default: `false`**

this attribute configures whether the PHPUnit test runner should exit with a shell exit code that indicates failure when all tests are successful but there are tests that were marked as skipped


---
## `failOnWarning` attribute
---
**possible vales: `true` or `false` default: `false`**

this attribute configures whether the PHPUnit test runner should exit with a shell exit code that indicates failure when all tests are successful but there are tests that had warning

---
## `beStrictAboutChangesToGlobalState` attribute
---
**possible vales: `true` or `false` default: `false`**

this attribute configures whether the PHPUnit should mark a test as risky when global state is manipulated by the code under test or the test code


---
## `beStrictAboutOutputDuringTests` attribute
---
**possible vales: `true` or `false` default: `false`**

this attribute configures whether PHPUnit should mark a test as risky when the code under test or the test code prints output


---
## `beStrictAboutResourceUsageDuringSmallTests` attribute
---
**possible vales: `true` or `false` default: `false`**

this attribute configures whether PHPUnit should mark a test that is annotated with @small as risky when it invokes a PHP builtin function or method that operates on resource variables.

---
## `beStrictAboutTestsThatDoNotTestAnything` attribute
---
**possible vales: `true` or `false` default: `true`**

this attribute configures whether PHPUnit should mark a test as risky when no assertions are performed expectations are also considered


---
## `beStrictAboutTodoAnnotatedTests` attribute
---
**possible vales: `true` or `false` default: `false`**

this attribute configures whether PHPUnit should mark a test as risky when is annotated with @todo

---
## `beStrictAboutCoversAnnotation` attribute
---
**possible vales: `true` or `false` default: `false`**

this attribute configures whether PHPUnit should mark a test as risky when it executes code that is not specified using @covers or @uses

---
## `enforceTimeLimit` attribute
---
**possible vales: `true` or `false` default: `false`**

this attribute configures whether time limits should be enforced

---
## `defaultTimeLimit` attribute
---
**possible vales: `integer` default: `0`**

this attribute configures the default time limit in seconds

---
## `timeoutForSmallTests` attribute
---
**possible vales: `integer`  default: `1`**

this attribute configures the time limit for tests annotated with @small in seconds

---
## `timeoutForMediumTests` attribute
---
**possible vales: `integer`  default: `10`**
@medium

---
## `timeoutForLargeTests` attribute
---
**possible vales: `integer`  default: `60`**
@large

---
## `testSuiteLoaderClass` attribute
---
**default: `PHPUnit\Runner\StandardTestSuiteLoader`**

this attribute configures the name of a class taht implements the `PHPUnit\Runner\TestSuiteLoader` interface, an object of this class is used to load the test suite.

---
## `testSuiteLoaderFile` attribute
---
this attribute can be used to configure the path to the source code file that declares the class configured with `testSuiteLoaderClass` in case that class cannot be autoloaded


---
## `defaultTestSuite` attribute
---
this attribute configures the name of the default test suite.


---
## `verbose` attribute
---
**possible vales: `true` or `false` default: `false`**

this attribute configures whether more verbose output should be printed

---
## `stderr` attribute
---
**possible vales: `true` or `false` default: `false`**

this attribute configures whether PHPUnit should print its output to `stderr` instead of `stdout`


---
## `reverseDefectList` attribute
---
**possible vales: `true` or `false` default: `false`**

this attribute configures whether tests that are not successful should be printed in reverse order.

---
## `registerMockObjectsFromTestArgumentsRecursively` attribute
---
**possible vales: `true` or `false` default: `false`**

this attribute configures whether arrays and object graphs that are passed from one test to another using the `@depends` annotation should be recursively scanned for mock objects.


---
## `extensionsDirectory` attribute
---
when `phpunit.phar` is used then this attribute may be used to configure a directory from which all `*.phar` files will be loaded as extensions fro the PHPUnit test runner.

---
## `executionOrder` attribute
---
**possible vales: `default`, `defects`, `depends` , `no-depends`, `duration` , `random` , `reverse`, `size`
using multiple values is possible. these need to be separated by `,`
this attribute configures the order in which tests are executed

---
## `resolveDependencies` attribute
---
**possible vales: `true` or `false` default: `true`**

this attribute configures whether dependencies between tests, expressed using the `@depends` annotation should be resolved.

---
## `testdox` attribute
---
**possible vales: `true` or `false` default: `false`**

this attribute configures whether the output should be printed in TestDox format

---
## `noInteraction` attribute
---
**possible vales: `true` or `false` default: `false`**
this attribute configures whether progress should be animated when TestDox format is used, for instance


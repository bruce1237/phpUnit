<?php
// PHPUnit Integration

/**
 * mockery was designed as a simple-to-use standalone mock object framework, so its need for 
 * integration with any testing framework is entirely optional. to intregrate mockery, we need to 
 * define a tearDown() method for our test containing the following (we may use a shorter \Mockery namespace alias):
 */

public function tearDown(){
    \Mockery::close();
}

/**
 * this static call cleans up the mockery container used by the current test, and run any verification tasks needed
 * for our expectations
 * 
 * for some added brevity when it comes to using mockery, we can also explicitly use the mockery
 * namespace with a shorter alias
 * 
 * for example
 */

use \Mockery as m;

class SimpleTest extends \PHPUnit\Framework\TestCase
{
    public function testSimpleMock(){
        $mock = m::mock('simplemock');
        $mock->shouldReceive('foo')->with(5, m::any())->once()->andReturn(10);

        $this->assertEquals(10, $mock->foo(5));
    }

    public function tearDown(){
        m::close();
    }
}

/**
 * mockery ships with an autoloader so we don't need to litter our tests with require_once() calls,
 * to use it, ensure mockery is on our include_path and add the following to our test suites'
 * Bootstrap.php or TestHeloper.php file
 */

 require_once 'Mockery/Loader.php';
 require_once 'Hamcrest/Hamcrest.php';

 $loader = new \Mockery\Loader;
 $loader->register();

/**
 * if we are using composer, we can simplify this to including the composer generated autoloader file
*/

require __DIR__.'/../vendor/autoload.php'; 

/**
 * CAUTION
 * prior to hamcrest 1.0.0, the Hamcrest.php file name had a small 'h' if upgrading
 * Hamcrest to 1.0.0 remember to check the filename is updated
 */

/**
 * To integrate mockery into phpunit and avoid having to call the close method and have mockery remove
 * itself from code coverage reports, have your test cases extends the 
 * \Mockery\Adapter\Phpunit\MockeryTestCase
 * 
 * an alternative is to use the supplied trait
 */

class MyTest extends \PHPUnit\Framework\TestCase
{
    use \Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
}

/**
 * extending mockeryTestCase or using the MockeryPHPunitIntegration trait is the recommended way 
 * of integrating mockery with phpUnit since mockery 1.0.0
 */




//  PHPUnit Listener
/**
 * before the 1.0.0 release, mockery provided a phpunit listener that would call Mockery::close()
 * for us at the end of a test. this has changed significantly since the 1.0.0 version
 * 
 * Now, Mockery provides a Phpunit listener that makes tests fial if mockery::close() has not been
 *  called, it can help identify tests where we've forgotten to include the trait or extends the MockeryTestCase.
 * 
 * if we are suing phpunit's xml configuration approach, we can include the following to load the TestListener:
 * <listeners>
 *  <listener class="\Mockery\Adapter\PHPUnit\TestListener"></listener>
 * </listeners>
 * 
 * make sure composer's or Mockery's autoloader is present int he bootstrap file or we will need to 
 * also define a file attribute pointing to the file of the TestListener class
 * 
 * if we creating the test suite programmatically we may add the listener like this
 */

 // create the suite
 $suite = new PHPUnit\Framework\TestSuite();

//  Create the listener and add it to the suite
$result = new PHPUnit\Framework\TestResult();
$result->addListener(new \Mockery\Adapter\Phpunit\TestListener());

// Runt the tests
$suite->run($result);

/**
 * CAUTION
 * PHPUnit provides a functionality that allows tests to run in a separated process, to ensure better isolation.
 * Mockery verifies the mocks expectations using the Mockery::close() method, and provides a phpunit listener,
 * that automatically calls this method for us after every test.
 * 
 * However, this listener is not called in the right process when using PHPUint's process isolation, 
 * resulting in expectations that might not be respected, but without raising any Mockery\Exception.
 * to vaoid this, we can not reply on the supplied mockery phpunit TestListener, and we need to explicitly call 
 * Mockery::close(). the easiest solution to include this call in the tearDown() method as explained previously.
 */
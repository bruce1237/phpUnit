<?php
// COOKBOOK

// Default Mock Expectations
/**
 * often in unit testing, we end up with sets of tests which use the same object dependency over and over again.
 * Rather than mocking this class/object within every single unit test(requiring a mountatin of duplicate code), we can instead
 * define reusable default mocks withini the test case's setup() method. this even woorks where unit tests use varying expectations 
 * on the same or similar mock object
 * 
 * how this works, is that you can define mocks with default expectations. then in a later unit test, you can add or fine-tune expectations for
 * that specific test. any expectation can be set as a default using the byDefault() declaration.
 */


// Detecting Mock Objects
/**
 * users may find it useful to check whether a given object is a real object or a simulated mock object
 * all mockery mocks implement the \Mockery\MockInterface interface which can be used in a type check
 */
assert($mightBeMocked instanceof \Mockery\MockInterface);

// Not Calling the original constructor
/**
 * when creating generated partial test doubles, mockery mocks out only the method which we specifically told it to.
 * this means that the original constructor of the class we are mocking will be called.
 * 
 * in some cases this is not a desired behavior, as the consturctor might issue calls to other methods,
 * or other object collaborators, and as such, can create undesired side-effects in the application's environment when running the test
 * 
 * if this happens, we need to use runtime partial test doubles, as they don't call the original consturctor.
 */

 class MyClass{
    public function __construct()
    {
        echo 'Original Constructor called.'.PHP_EOL;
        
    }
 }

 $mock = \Mockery::mock('MyClass[foo]');

 //a better approach is to u se runtime partial doubles

 $mock = \Mockery::mock('MyClass')->makePartial();
 $mock->shouldReceive('foo');

/**
 * this is one of the reason why we don't recommend using generated partial test doubles, but
 * if possible, always use the runtime partials
*/

// Mocking hard dependencies(new keyword)
/**
 * one prerequisite to mock hard dependencies is that the code we are trying to test uses autoloading 
 * let take the following code for an example
 */

namespace App;

class Service
{
    function callExternalService($param){
        $externalService = new Service\External($version = 5);
        $externalService->sendSomething($param);
        return $externalService->getSomething();
    }
}

/**
 * the way we can test this without doing any changes to the code itself is by creating instance mocks
 * by using the overload prefix
 */

namespace AppTest;
class ServiceTest extends \PHPUnit\Framework\TestCase
{
    public function testCallingExternalService(){
        $param = 'Testing';
        $externalMock = \Mockery::mock('overload::App\Service\External');
        $externalMock->shouldReceive('sendSomething')->once()->with($param);

        $externalMock->shouldReceive('getSomething')->once()->andReturn('Tested!');

        $service = new \App\Service();
        $result = $service->callExternalService($param);

        $this->assertSame('Tested!', $result);
    }
}

/**
 * if we run this test now, it should pass. Mockery does its job and our App\Service will use the mocked external service instead of the real one 
 * the problem with this is when we want to, for example, test the App\Service\External itself, or if we use that class somewhere else in our tests.
 * 
 * when mockery overloads a class, because of how PHP works with files, that overloaded class file must not be included otherwise mockery will throw a 
 * "class already exists" exception. this is where autoloading kicks in and makes our job a lot easier
 * 
 * to Make this possible, we'll tell phpunit to run the test that have overloaded classes in a separate processes and to not preserve global state. 
 * that way we'll avoid having the overloaded class included more thant once. of course this has its downsides as these tests will run slower
 * 
 * our test example from above now becomes:
 */

 namespace AppTest;
 class ServiceTest extends \PHPUnit\Framework\TestCase
 {
    /**
     * @runTestsInSeparateProcesses
     * @preserveGlobalState disabled
     */
    public function testCallingExternalService(){
        $param = 'Testing';

        $externalMock = \Mockery::mock('overload:App\Service\External');
        $externalMock->shouldReceive('sendSomething')->once()->with($param);

        $externalMock->shouldReceive('getSomething')->once()->andReturn('Tested!');

        $service = new \App\Service();
        $result = $service->callExternalService($param);
        
        $this->assertSame('Tested!', $result);
    }
 }


// Testing the constructor arguments of hard dependencies
/**
 * sometimes we might want to ensure t hat the hard dependency is instantiated with particular arguments. 
 * with overloaded mocks, we can set up expectations on the constructor
 */
namespace AppTest;

use PhpParser\Node\Expr\Cast\Bool_;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class ServiceTest extends \PHPUnit\Framework\TestCase
{
    public function testCallingExternalService()
    {
        $externalMock = \Mockery::mock('overload:App\Service\External');
        $externalMock->allows('sendSomething');
        $externalMock->shouldReceive('__construct')->once()->with(5);

        $service = new \App\Service();
        $result = $service->callExternalService(5);
    }
}

/**
 * for more straightforward and single-process tests oriented way check Mocking class within class
 */





// Class Constants
/**
 * when creating a test double for a class, mockery does not create stubs out of any class constants defined in the
 * class we are mocking. sometimes though, the non-existence of these class constants, setup of the test, and the application
 * code itself, it can lead to undersired behavior, and even a PHP error:
 * 
 * PHP Fatal error: Uncaught Error: Undefined class constant 'FOO' in ...
 * 
 * while supporting class constants in Mockery would be possible, it does require an awful lot of
 * work, for a small number of use cases.
 */

// * Named Mocks
/**
 * We can, however, deal with these constants in a way supported by Mockery by using Named Mocks
 * 
 * a named mock is a test double that has a name of the class wew want ot mock, but under it is a 
 * stubbed out class that m imic the real class with canned responses
 * 
 * let look at the following made up, but not impossible scenario:
 */

class Fetcher
 {
    const SUCCESS = 0;
    const FAILURE = 1;

    public static function fetch()
    {
        return self::SUCCESS;
    }
}

class MyClass
{
    public function doFetching()
    {
        $response = Fetcher::fetch();

        if($response == Fetcher::SUCCESS){
            echo "Thanks" . PHP_EOL;
        } else {
            echo "Try again!" . PHP_EOL;
        }
    }
}

/**
 * our MyClass Calls a Fetcher that fetches some resource from somewhere - maybe it downloads a file from a remote webservice.
 * our MyClass prints out a response message depending on the response from the Fetcher::fetch() call.
 * 
 * 
 * when testing MyClass we don't really want Fetcher to go and download random stuff from the internet every time we run test.
 * so we mock it out
 */

//  using alias: because fetch is called statically
\Mockery::mock('alias:Fetcher')->shouldReceive('fetch')->andReturn(0);

$myClass = new MyClass();
$myClass->doFetching();

/**
 * if we run this, our test will error out with a nasty
 * 
 * PHP Fatal error: Uncaught Error: undefined class constant 'SUCCESS' in ...
 * 
 * here's how a namedMock() can help us in a situtation like this.
 * 
 * we create a stub for the Fetch class, stubbing out the class constants, and then use
 * namedMock() to create a mock named Fetcher based on our stub:
 */

class FetcherStub
{
const SUCCESS = 0;
const FAILURE = 1;
}

\Mockery::namedMock('Fetcher', 'FetcherStub')->shouldReceive('fetch')->andReturn(0);

$myClass = new MyClass();
$myClass->doFetching();

/**
 * this works because under the hood, mockery creates a class called Fetcher thant extends FetcherStub.
 * the same approach will work even if Fetcher::fetch() is not a static dependency:
 */
class Fetcher
{
    const SUCCESS = 0;
    const FAILURE = 1;

    public function fetch()
    {
        return self::SUCCESS;
    }
}

class MyClass
{
    public function doFetching($fetcher){
        $response = $fetcher->fetch();

        if($response == Fetcher::SUCCESS){
            echo "thanks" . PHP_EOL;
        } else {
            echo 'Try again!' . PHP_EOL;
        }
    }
}

/**
 * and the test will have something like this:
 */
class FetcherStub
{
    const SUCCESS = 0;
    const FAILURE = 1;
}

$mock = \Mockery::mock('Fetcher', 'FetcherStub');
$mock->shouldReceive('fetch')->andReturn(0);

$myClass = new MyClass();
$myClass->doFetching($mock);




// Constants Map
/**
 * another way of mocking class constant can be with the use of the constants map configuration
 * 
 * given a class with constants
 */
class Fetcher
{
    const SUCCESS = 0;
    const FAILURE = 1;

    public function fetch()
    {
        return self::SUCCESS;
    }
}

/**
 * it can be mocked with:
 */
\Mockery::getConfiguration()->setConstantsMap([
    'Fetcher' => [
        'SUCCESS' => 'success',
        'FAILURE' => 'fail'
    ]
    ]);

$mock = \Mockery::mock('Fetcher');
var_dump($mock::SUCCESS); // (string) 'success'
var_dump($mock::FAILURE); // (string) 'fail'


// Big Parent Class
/**
 * in some application code, especially older legacy code, we can come across some classes that extend a big parent class
 * - a parent class that know and does too much
 */

class BigParentClass
{
    public function doesEverything()
    {
    }
}

class ChildClass extends BigParentClass
{
    public function doesOneThing()
    {
        $result = $this->doesEverything();
        return $result;
    }
}

/**
 * we want to test our ChildClas and its doesOneThing() method, but the problem is that it calls on 
 * BigParentClass::doesEverything(). one way to handle this would be to mock out all of the dependencies 
 * BigParentClass has and needs, and then finally actually test our doesOneThing() method. it's an awful lots of work to do
 * 
 * what we can do is to do something... unconventional. we can create a runtime partial test double of the ChildClass
 * itself and mock only the partent's doesEverything() method
 */
$childClass = \Mockery::mock('ChildClass')->makePartial();
$childClass->shouldReceive('doesEverything')->andReturn('some result from parent');

$childClass->doesOneThing(); // string("some result from parent");

/**
 * with this approach we mock out only the doesEverything() method, and all the unmocked method are called on the actual ChildClass instance
 */


// Complex Argument Matching with Mockery::on
/**
 * when we need to do a more complex argument matching for an expected method call. the \Mockery::on() matcher 
 * comes in really handy. it accepts a closure as an argument and that closure in turn receives the argument passed in to the method, 
 * when called. if the closure returns true, mockery will consider that the argument has paased the expectation.  if the closure returns
 * false, or a 'falsey' value, the expectation will not pass
 * 
 * the \Mockery::on() matcher can be used in various scenarios - validating an array argument based on multiple keys and values, 
 * complex string matching....
 * 
 * for example, we ahve the following code, it doesn't do much; publishes a post by setting the published flag in the database to 1 and
 * set the published_at to the current date and time
 *
 */

namespace Service;
class Post
{
    protected $model;
    public function __construct($model)
    {
        $this->model = $model;
    }

    public function publisPost($id)
    {
        $saveData = [
            'post_id' => $id,
            'published' => 1,
            'published_at' => gmdate('Y-m-d H:i:s'),
        ];
        $this->model->save($saveData);
    }
}

/**
 * in a test we would mock the model and set some expectations on the call of the save() method
 */

$postId = 42;

$modelMock = \Mockery::mock('Model');
$modelMock->shouldReceive('save')->once()
    ->with(\Mockery::on(function ($argument) use ($postId) {
        $postIdIsSet = isset($argument['post_id']) && $argument['post_id'] === $postId;
        $publishedFlagIsSet = isset($argument['published']) && $argument['published'] === 1;
        $publishedAtIsSet = isset($argument['published_at']);

        return $postIdIsSet && $publishedAtIsSet && $publishedFlagIsSet;

    }));
    
$service = new \Service\Post($modelMock);
$service->publisPost($postId);

\Mockery::close();

/**
 * the important part of the example is inside the closure we pass to the \Mockery::on() matcher.
 * the $arguemtn is actually the $saveData argument the save() method gets when it is called.
 * we check for a couple of things in this arguemnts
 * if any of these required is not satisfied, the closure will return false, the method call
 * expectation will not be met, and mockery will throw a NoMatchingExpectationException.
 */




// Mocking Class within class
/**
 * imagine a case where you need to create an instance of a class and use it within the same method
 */

namespace App;

use Exception;

class Point
{
    public function setPoint($x, $y)
    {
        echo "point ( $x , $y ) ".PHP_EOL;
    }
}

class Rectangle
{
    public function create($x1, $y1, $x2, $y2)
    {
        $a = new Point();
        $a->setPoint($x1, $y1);

        $b = new Point();
        $b->setPoint($x2, $y1);

        $c = new Point();
        $c->setPoint($x2, $y2);

        $d = new Point();
        $d->setPoint($x1, $y2);

        $this->draw([$a, $b, $c, $d]);
    }

    public function draw($points)
    {
        echo "do something with the points";
    }
}

/**
 * and that you want to test that a logic in rectangle->create() calls properly each used thing 
 * in this calse calls point->setPoint() but rectangle->draw() does some graphical stuff that you want to avoid calling
 * 
 * you set the mocks for App\Po9int and App\Rectangle:
 */
class MyTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate(){
        $point = \Mockery::mock('App\Point');
        $point->shouldReceive("setPoint")->andTrhow(Exception::class);

        $rect = \Mockery::mock('App\Rectangle')->makePartial();
        $rect->shouldReceive("draw");

        $rect->create(0,0,100,100);
        \Mockery::close();
    }
}

/**
 * and the test does NOT work, why? the mocking reles on the class not being present yet, but the class is
 * autoloaded therefore the mock alone for App\Point is useless wich you can see with echo being executed
 * 
 * mocks however work for the first class in the order of loading i.e. App\Rectangle, which loads the 
 * App\Point class. in more complex example that would be a single point that initiates the whole loading(use class) such as 
 * 
 * A        // main loading initiator
 * |- B     // another loading initiator
 * |  |-E
 * |  +-G
 * |
 * |- C     // another loading initiator
 * |  +-F
 * |
 * +- D
 * 
 * 
 * that basically means that the loading prevents mocking and for each such a loading initiator there needs to be implemented a workaround.
 * overloading is one approach, however it pollutes the global state.
 * in this case we try to completely avoid the global state pollution with custom new Class() behavior per loading initiator and that can be mocked 
 * easily in few critical places
 * 
 * that being said, although we can't stop loading, we can return mocks let look at Rectangle->create() method,
 * we carea a custom function to encapsulate new keyword that would otherwise just use the autoloaded class App\Point and 
 * in our test we mock that function so that it returns our mock:
 * 
 */
class MyTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate()
    {
        $point = \Mockery::mock("App\Point");
        // check if our mock is called
        $point->shouldReceive('setPoint')->andThrow(Exception::class);

        $rect = \Mockery::mock("App\Rectangle")->makePartial();
        $rect->shouldReceive("draw");

        // pass the App\Point mock into App\Rectangle as an alternative
        // to using new App\Point() in-place
        $rect->shouldReceive("newPoint")->andReturn($point);

        $this->expectException(Exception::class);
        $rect->create(0,0,100,100);
        \Mockery::close();
    }
}

/**
 * if we run this test now, it shuld pass. for more complex cases we'd find the next loader in the program flow and proceed with warpping 
 * and passing mock instances with predefined behavior into already existing classes.
 */
<?php
// Preserving Pass-by-Reference Method Parameter Behaviour

use Foo as GlobalFoo;
use PHPUnit\Framework\TestCase;

/**
 * php class method may accept parameters by reference. in this case, changes made to the
 * parameter (a reference to the original variable passed to the method) are reflected in the original
 * variable 
 * example
 */
class foo{
    public function bar(&$a){
        $a++;
    }
}

$baz = 1;
$foo = new foo();
$foo->bar($baz);

echo $baz; // integer 2

/**
 * in the example above, the variable $baz is passed by reference to Foo::bar()
 * any change bar() makes to the parameter reference is reflected in the original variable, $baz
 * 
 * Mockery handles references correctly for all methods where it can analyse the parameter
 * using reflection to see if it is passed by reference. to mock how a reference is manipulated by the class
 * method, we can use a closure argument matcher to manipulate it i.e. \Mockery::on()
 * 
 * there is an exception for internal PHP classes where Mockery cannot analyse method parameters
 * using reflection(a limitation in PHP). to work around this, we can explicitly declare method
 * parameters for an internal class using 
 * \Mockery\Configuration::setInternalClassMethodParamMap()
 * 
 * here's an example using MongoCollection::insert().
 * mongoCollection is an internal class offered by the mongo extension from PECL.
 * its insert() method accepts an array of data as the first parameter, 
 * and an optional options array as the second parameter, the opriginal data array is updated
 * (i.e. when a insert() pass-by-reference parameter) to include a new _id field.
 * we can mock this behaviour using a configured parameter map( to tell mockery to expect a pass by reference aparameter)
 * and a closure attached to the expected method parameter to be updated
 * 
 * here's a PHPuint unit test verifying that the pass-by-reference behaviour is preserved
 */

 public function testCanOverrideExpectedParametersOfInternalPHPClassesToPreserveRefs()
 {
    \Mockery::getConfiguration()->setInternalClassMethodParamMap(
        'MongoCollection',
        'insert',
        array('&$data', '$options=array()')
    );
    
    $mock = \Mockery::mock('MongoCollection');
    $mock->shouldReceive('insert')->with(
        \Mockery::on(function(&$data){
            if (!is_array($data)) {
                return false;
            }
            $data['_id'] = 123;
            return true;
        }),
        \Mockery::any()
    );

    $data = array('a'=>1, 'b'=>2);
    $m->insert($data);

    $this->assertTrue(isset($data['_id']));
    $this->assertEquals(123, $data['_id']);

    \Mockery::resetContainer();
 }



//  Protected Methods
/**
 * when dealing with protected methods, and trying to preserve pass by reference behavior for them,
 * a different approach is required
 */

class Model{
    public function test(&$data){
        return $this->doTest($data);
    }
    protected function doTest(&$data){
        $data['something'] = 'wrong';
        return $this;
    }
}

class Test extends TestCase
{
    public function testModel(){
        $mock = \Mockery::mock('Model[test]')->shouldAllowMockingProtectedMethods();

        $mock->shouldReceive('test')->with(\Mockery::on(function(&$data){
            $data['something'] = 'wrong';
            return true;
        }));

        $data = array('foo'=>'bar');

        $mock->test($data);
        $this->assertTrue(isset($data['something']));
        $this->assertEquals('wrong', $data['something']);
    }
}

/**
 * this is quite an edge case, so we need to change the original code a little bit, by creating a public method that will call our protected
 * method, and then mock tthat, instead of the protected method . 
 * this new public mehtod will act as a proxy to our protected method.
 */
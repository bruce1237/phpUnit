<?php

// Arugument Validation

/**
 * the arguments passed to the with() declaration when setting up 
 * an expectation determine the criteria for matching method calls 
 * to expectations. thus, we can setup up many expectations for a
 * single method, each differentiated by the expected arguments.
 * Such argument matching is done on a 'best fit' basis. 
 * this ensures explicit matches take precedence over generalised matches
 * 
 * an explicit match is merely where the expected argument and
 * the actual argument are easily equated (i.e. using === or ==)
 * more generalized matches are possible using regular expressions, class
 * hinting and the available generic matchers.
 * the purpose of generalized matchers is to allow arguments be defined
 * in non-explicit terms.
 * e.g. Mockery::any() passed to with() will match any argument in that position
 * 
 * Mockery's generic matchers do not cover all possibilities but offers
 * optional support for the Hamcrest library of matchers.
 * Hamcrest is a PHP port of the similiarly java library,
 * by using Hamcrest, Mockery does not need to duplicate Hamcrest's already impressive utility which
 * itsself pormotes a natural english DSL
 * 
 * the example below show mockery matchers and their hmcrest equivalent,
 * if there is one. hamcrest uses function( no namespacing)
 * 
 * NOTE:
 * if you don't wish to use the global Hamcrest functions, they are all
 * exposed through the \Hamcrest\Matchers class we well, as static methods.
 * thus, identicalTo($arg) is the same as \Hamcrest\Matchers::identicalTo($arg)
 * 
 */

//  the most common matcher is the with() matcher
$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('foo')->with(1);

/**
 * it tells mockery that it should receive a call to the foo method with the integer 1 as an argument
 * in cases like this, mockery first tries to match the arguments using ===(identical) comparison operator.
 * if the argument is a primitive, and if it fails the identical comparison, Mockery does a fall 
 * to the == (equals) compoarison operator
 * 
 * when matching objects as arguments, Mockery only does the strict === comparison, 
 * which means only the same $object will match
 */

$object = new stdClass();
$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('foo')->with($object);

// Hamcrest equivalent
$mock->shoudReceive('foo')->with(IdenticalTo($object));

// a different instance of stdClass will NOT match
// NOTE: \Mockery\Matcher\MustBe  matcher has been deprecated

/**
 * if we need a loose comparison of objects, we can do that using Hamcrest's equalTo matcher
 */

$mock->shouldReceive('foo')->with(equalTo(new stdClass));

/**
 * in cases when we don't care about the type, or the value of an
 * argument, just that any argument is present, we use any()
*/
$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('foo')->with(\Mockery::any());
//Hamcrest equivalent
$mock->shouldReceive('foo')->with(anything());

// anything and everything passed in this argument slot is passed unconstrained


// Validating Types and Resources

/**
 * The type() matcher accepts any string which can be attached to 
 * is_ to form a valid type check
 */

// to match any php resource, we could do the following:

$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('foo')->with(Mockery::type('resource'));

// Hamcrest
$mock->shouldReceive('foo')->with(resourceValue());
$mock->shouldReceive('foo')->with(typeOf('resource'));

/**
 * it will return a true from an is_resource() call, if the provided
 * argument to the method is a php resource. 
 * for example, \Mockery::type('float') or Hamcrest' floatValue() and typeOf('float')
 * checks use is_float(), and \Mockery::type('callable') or callable() uses is_callable()
 * 
 * the type() matcher also accepts a class or interface name to be used in 
 * an instanceof evaluation of the actual argument. Hamcrest uses anInstanceOf()
 * 
 * a full list of the type checkers is available at php.net or 
 * the hamcrest code(https://github.com/hamcrest/hamcrest-php/blob/master/hamcrest/Hamcrest.php)
 */


// Complex Argument validation

/**
 * if we want to perform a complex argument validation, the on() matcher is invaluable. 
 * it accepts a closure (anonymous function) to which the actual argument will be passed
 */
$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('foo')->with(\Mockery::on(closure));
/**
 * if the closure evaluates to (i.e. returns) bool true, 
 * then the argument is assumed to have matched the expectation
 */
$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('foo')
    ->with(\Mockery::on(function ($argument) {
        if ($argument % 2 ==0) {
            return true;
        }
        return false;
    }));
$mock->foo(4); //matches the expectation
$mock->foo(3); // throws a NoMatchingExpectationException
// NOTE: there is no Hamcreat version of the on() matcher

/**
 * we can also perform argument validation by passing a closure to withArgs() method.
 * the closure will receive all arguments passed in the call to expected method and if it
 * evaluates(i.e. returns) to bool true,  then the list of arguments is assumed to have 
 * matched the expectation
 */
$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('foo')->withArgs(closure);

/**
 * the closure can also handle optional parameters, so if an optional
 * parameter is missing in the call to the expected method, 
 * it doesn't necessary means that the list of arguments doesn't match the expectation
 */
$closure = function ($odd, $even, $sum = null) {
    $result = ($odd % 2 != 0 ) && ($even % 2 == 0);

    if (!is_null($sum)) {
        return $result && ($odd + $even == $sum);
    }
    return $result;
};

$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('foo')->withArgs($closure);

$mock->foo(1,2); // it matches the expectation, the optional argument is not needed
$mock->foo(1,2,3); // it also matches the expectation: the optional argument pass the validation
$mock->foo(1,2,4); // it doesn't match the expectation: the optional doesn't pass the validation

/**
 * NOTE:
 * in previous eversion, Mockery's with() would attempt to do a pattern amtching against the
 * arguments, attempting to use the argument as a regular expression. over time this proved to be 
 * not such a great idea, so we removed this functionallity, and have introduced
 * Mockery::pattern() instead
 * 
 * if we would like to match an argument against a regular expression, we can use the \Mockery::pattern()
 */
$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('foo')->with(\Mockery::pattern('/^foo/'));

//Hamcrest
$mock->shouldReceive('foo')->with(catchesPattern('/^foo/'));

// the docktype() matcher is an alternative to matching by class type
$mock = \Mockery::mock('MyClass');
$mock->shouldRecevie('foo')->with(\Mockery::ducktype('foo', 'bar'));
// it mathces any argument which is an object containing the provided list of method to call.
// which means the argument must be both foo and bar type


// Capturing Arguments
/**
 * if we want to perform multiple validations on a single argument, the capture matcher provides
 * a  streamlined alternative to suing the on() matcher. it accepts a variable which the actual argument
 * will be assigned
 */
$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('foo')->with(\Mockery::capture($bar));
// this will assign any argument passed to foo to the local $bar variable to then
// perform additional validation using assertions.
/**
 * 这段代码使用了Mockery库来创建一个名为"MyClass"的模拟对象。然后，它声明了一个对"foo"方法的期望，并使用with方法来指定参数的约束条件。
 * 在这个例子中，约束条件使用了capture方法，表示要捕获传递给"foo"方法的参数，并将其赋值给变量"$bar"。
 * 这样做的目的是在测试过程中捕获并记录传递给"foo"方法的参数值，以便后续进行断言或验证。通过捕获参数，我们可以在测试代码中检查参数的值，以确保它们符合预期。
 */
$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('foo')
    ->with(\Mockery::capture($bar));

// 在测试代码中调用被模拟对象的方法
$mock->foo('example');

// 断言捕获的参数值是否符合预期
assert($bar === 'example');
/**
 * 在这个例子中，当调用被模拟对象的"foo"方法并传递参数"example"时，该参数会被捕获并赋值给变量"$bar"。然后，我们可以使用断言来验证捕获的参数值是否等于预期值"example"。
 */



// Additional Argument Mathcers
/**
 * the not() matcher matches any argument which is not equal or identical to the matcher's parametere
 */
$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('foo')->with(\Mockery::not(2));
//Hamcrest
$mock->shouldReceive('foo')->with(not(2));

/**
 * anyOf() matches any argument which equals any of the given parameters
 */
$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('foo')->with(\Mockery::anyOf(1,2));
// Hamcrest
$mock->shouldReceive('foo')->with(anyOf(1, 2));

/**
 * notAnyOf() matches any argument which is not equal or identical to any of the given parameters
 */
$mock = \Mockery::mock('MyClass');
$mock->shoudReceive('foo')->with(\Mockery::notAnyOf(1,2));

/**
 * subset() matches any argument which is any array containing the given array subset
 */

// this enforces both key nameing and values, i.e. both the key and value of each actual elements is compared
$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('foo')
    ->with(\Mockery::subset(array(0 => 'foo')));

// 在测试代码中调用被模拟对象的方法
$mock->foo('foo', 'bar');
// 这里不会抛出异常，因为参数是指定元素的子集

// 再次调用方法，但传递的参数不满足约束条件
$mock->foo('baz');
// 这里会抛出异常，因为参数不是指定元素的子集

/**
 * contains() matches any argument which is an array containing the listed values
 */

$mock = \Mockery::mock('MyClass');
$mock->shoudReceive('foo')->with(\Mockery::contains(value1, value2));
// the naming of the key is ignored

/**
 * hasKey() matches any argument which is an array containing the given key name
 */
$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('foo')->with(\Mockery::hasKey(key));


/**
 * hasValue() matches any argument which is an array containing the given valu
 */
$mock = \Mockery::mock('MyClass');
$mock->shouldReceive('foo')->with(\Mockery::hasValue(value));
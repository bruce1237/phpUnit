<?php
// Dealing with final Classes/Methods

/**
 * one of the primary restrictions of mock objects in PHP, is that mocking classes or method marked
 * final is hard. the ffinal keyword prevents methods so marked from being replaced in subclasses
 * (subcalssing is how mock objects can inherit the type of the class or object being mocked)
 * 
 * The simplest solution is to implement an interface in your final calss and typehint against /mock this
 * 
 * however this may not be possible in some thrid party libraries. mockery does allow creating 
 * "proxy mocks" from classes marked final, or from classes with methods marked final. this offers all the usual
 * mock object godness but the resulting mock will not inherit the class type of the object being mocked. 
 * i.e. it will not pass any instanceof comparison. methods marked as final will be proxied to the  original method. 
 * i.e., final methods can't be mocked.
 * 
 * we can create a proxy mock by passing the instantiated object we wish to mock into \Mockery::mock()
 * i.e. Mockery will then generate a proxy to the real object and selectively intercept method calls for
 * the purposes of setting and meeting expectations
 * 
 */




// PHP Magic Methods
/**
 * php magic methods which are prefiexed with a double underscore, e.g. __set(), pose a particular
 * problem in mocking and unit testing in general. it is strongly recommended that 
 * unit tests and mock object do not directly refer to magic methods. 
 * instaead, refer only to the virtual methods and properties these magic method simulate
 * 
 * following this piece of advice will ensure we are testing the real API of classes and also
 * ensures there is no confilct should mockery override these mgaic methods, which it will inevitably do 
 * in order to support its role in intercepting method calls and properties.
 */
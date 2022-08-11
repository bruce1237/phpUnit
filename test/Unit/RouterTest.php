<?php

namespace test;

use app\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{

    /**
     * Testing Router->Register() funciton
     */

    // the following line indicate the following method is a test function 
    // if the function name doesn't have prefix test_
    /** @test */
    public function isRegisterARoute(): void
    {
        //given that we have a router object
        $router = new Router();

        //when call a register method
        $router->register('get', '/users', ['Users', 'index']);

        $expected = [
            'get' => [
                '/users' => ['Users', 'index'],
            ]
        ];
        //then assert route was registerd
        $this->assertEquals($expected, $router->routes());
    }

    //this function has prefix test_ to indicate that's a test method
    public function testIsRegisterARoute(): void
    {
        //given that we have a router object
        $router = new Router();

        //when call a register method
        $router->register('get', '/users', ['Users', 'index']);

        $expected = [
            'get' => [
                '/users' => ['Users', 'index'],
            ]
        ];
        //then assert route was registerd
        $this->assertEquals($expected, $router->routes());
    }

    public function testIsRegisterGetRoute(): void
    {
        $router = new Router();
        $router->get('/users', ['Users','index']);

        $expected = [
            'get' =>[
                '/users'=>['Users','index'],
            ],
        ];
        $this->assertEquals($expected,$router->routes());
    }

    public function testIsRegisterPostRoute(): void
    {
        $router = new Router();
        $router->post('/users',['Users','index']);

        $expected = [
            'post'=>[
                '/users'=>['Users','index'],
            ],
        ];
        $this->assertEquals($expected, $router->routes());

            
    }
}

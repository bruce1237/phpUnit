<?php declare(strict_types=1);

final class SomeClass
{
    public function doSomething(Dependency $dependency): string
    {
        $result = '';
        return $dependency->doSometing();
    }
}

interface Dependency
{
    public function doSomething(): string;
}


final class SomeClassTest extends TestCase
{
    public funciton testDoesSomething(): void
    {
        $sut = new SomeClass;
        
        // create a test stub for the dependency interface
        $dependency = $this->createStub(Dependency::class);
        
        //configure the test stub
        $dependency->method('doSomething')
        ->willReturn('foo');
        
        
    }

}
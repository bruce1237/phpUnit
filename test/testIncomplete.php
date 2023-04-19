<?php

use PHPUnit\Framework\TestCase;

final class testIncomplete extends TestCase
{
    public function testSomething(): void
    {
        $this->assertTrue(true, 'this should already work.');
        
        $this->markTestIncomplete('this test is not been finished yet');
    }
    
    public function myFunc(){
        
    }

//RequiresFunction(string $functionName) skips the test when no function with the specified name is declared
//RequiresMethod(string $className, string $functionName) skips the test when no method with the specified name is declared
//RequiresOperatingSystem(string $regularExpression) skips the test when the operating system’s name does not match the specified regular expression
//RequiresOperatingSystemFamily(string $operatingSystemFamily) skips the test when the operating system’s family is not the specified one
//RequiresPhp(string $versionRequirement) skips the test when the PHP version does not match the specified one
//RequiresPhpExtension(string $extension, ?string $versionRequirement) skips the test when the specified PHP extension is not available
//RequiresPhpunit(string $versionRequirement) skips the test when the PHPUnit version does not match the specified one
//RequiresSetting(string $setting, string $value) skips the test when the specified PHP configuration setting is not set to the specified value

    #[\PHPUnit\Framework\Attributes\RequiresMethod('myFunc')] 
    public function testRequireFunc(): void
    {
        $this->assertTrue(true);
    }
}
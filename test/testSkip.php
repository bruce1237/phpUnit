<?php

use PHPUnit\Framework\TestCase;

final class testSkip extends TestCase
{
    public function testSomething(): void
    {
       if (!extension_loaded('pdo_pgsql')) {
           $this->markTestSkipped('The PostgreSQL extension is not available');
       }
    }
}
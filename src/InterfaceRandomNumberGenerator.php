<?php
namespace bo\src;

interface InterfaceRandomNumberGenerator{
    public function generate(int $numberOfDigits):string; 
}
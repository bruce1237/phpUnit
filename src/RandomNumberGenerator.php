<?php
namespace bo\src;

class RandomNumberGenerator implements InterfaceRandomNumberGenerator{
    public function generate(int $length):string
    {
        return "0123";
    }
}
<?php
namespace bo\src;

class UseGenerator{
    public function __construct(public $generator)
    {
        
    }
    public function preFix(string $num)
    {


        return "ABCD".$this->generator->generate(4);
    }
}
<?php

class abc{
    public $a='a';
    
    
}

$a = new abc();

$c = clone $a;

$b = $a;

$c->a='c';

$b->a='b';

var_dump($a);
var_dump($b);
var_dump($c);
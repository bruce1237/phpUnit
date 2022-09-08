<?php
namespace bo\src;

use Exception;

class Queue{
    private $isEmpty = true;
    public function isEmpty():bool
    {
        return $this->isEmpty;
    }

    public function add(string $person)
    {
        $this->isEmpty=false;
    }

    public function size():int
    {
        return 0;
    }

    public function pop()
    {    
        throw new Exception("Can not pop empty queue");
    }
}
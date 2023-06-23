<?php
namespace bo\src;

class BigParentClass
{
    public function doesEverything()
    {
    }
}

class ChildClass extends BigParentClass
{
    public function doesOneThing()
    {
        $result = $this->doesEverything();
        return $result;
    }
}


class testClass
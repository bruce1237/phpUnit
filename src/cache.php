<?php
namespace bo\src;

use Redis;

class cache{
    public function __construct(private Redis $redis)
    {}

    public function setMulti(array $data):bool{
        $result = [];
        foreach($data as $key=>$value){
            $result[$key] = false;
            if($this->redis->set($key, $value)){
                $result[$key]=true;
            }
        }
        return true;
    }

    public function getValue(string $key):string
    {
        return $this->redis->get($key);
    }
}
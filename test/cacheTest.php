<?php

use bo\src\cache;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\Mock;
use PHPUnit\Framework\TestCase;

class cacheTest extends MockeryTestCase{
    private \Redis|Mock $redisMock;
    private cache $cache;

    protected function setup():void
    {
        $this->redisMock = Mockery::mock(\Redis::class);
        $this->cache = new cache($this->redisMock);
    }

    public function testGetValue(){
        $key = 'KK';
        $value = "VV";

        $this->redisMock->shouldReceive('get')
            ->with($key)
            ->andReturn($value);

        $this->assertEquals($value, $this->cache->getValue($key));
    }

    public function testSetMulti(){
        $data =[
            "k1"=>"v1",
            "k2"=>"v2",
            "k3"=>"v3",
            "k4"=>"v4"
        ];

        $this->redisMock
            ->shouldReceive('set')
            ->times(4)
            ->andReturn(true);
        
        $this->assertTrue( $this->cache->setMulti($data));
        
    }

    
}
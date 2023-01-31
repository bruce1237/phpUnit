<?php

use PHPUnit\Framework\TestCase;

class dataProviderTest extends TestCase
{


    /**
     * @dataProvider provideData
     *
     * @param integer $i
     * @param array $a
     * @return void
     */
    public  function testDataProvidor(int $i, array $a)
    {
        $this->assertTrue(is_int($a));
    }


    public function provideData(): array
    {
        return [
            'already out of time' => [
                -1,
                [100]
            ],
            'times out after polling once' =>
            [
                1,
                [100, 102]
            ],
            'times out after polling 5 times' =>
            [
                10,
                [100, 101, 102, 103, 120]
            ]
        ];
    }
}

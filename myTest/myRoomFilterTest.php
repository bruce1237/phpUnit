<?php

use myTest\myRoomFilter;
use PHPUnit\Framework\TestCase;

include "../autoload.php";



class myRoomFilterTest extends TestCase
{

    public function testFilter ()
    {
        $resultArray  = $this->makeResultArray();
        $requestArray = $this->makeRequestArray($resultArray);

        
        file_put_contents('result.txt', print_r($resultArray,true));
        file_put_contents('request.txt', print_r($requestArray,true));
        
        $myRoomFilter = new myRoomFilter();
    
        $timeStart = microtime(true);
        $filterResult = $myRoomFilter->filter($requestArray);
        $timer = (microtime(true)-$timeStart)*1000;
        file_put_contents('timer.txt',$timer."\r\n",FILE_APPEND);
        
        // echo '\n------------------\n';
        file_put_contents('filterresult.txt', print_r($filterResult,true));
        

    
    $this->assertEquals($resultArray, $filterResult);



        # code...
    }

    private function makeResultArray()
    {
        // $size = mt_rand(5, 20);
        $size = mt_rand(5, 20);
        $resultArray = array();
        for ($i = 0; $i < $size; $i++) {
            $room = mt_rand(10000, 99999);
            $resultArray[$room] = 'getContractRoomTypeID';
        }


        return $resultArray;
    }


    private function makeRequestArray($resultArray)
    {
        $requestArray = array();
        $numOfRequest = mt_rand(2, 4);
        // $numOfRequest = 1;
        

        for ($i = 0; $i < $numOfRequest; $i++) {
            $requestArray[$i] = array();
            // $numofRooms = mt_rand(10, 99);
            $numofRooms = mt_rand(2, 5);
            $insert = (int) $numofRooms / 2;
            $insert = 1;

            for ($a = 0; $a <= $numofRooms; $a++) {
                $room = ['getContractRoomTypeID' => mt_rand(10000, 99999)];
                array_push($requestArray[$i], $room);

                if ($a == $insert) {
                    foreach($resultArray as $key=>$value){
                        $pre_room = ['getContractRoomTypeID' => $key];
                        array_push($requestArray[$i], $pre_room);
                
                    }

                }
            }
        }

        return $requestArray;
    }
}

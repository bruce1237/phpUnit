<?php
//test
class myRoomFilterTest
{

    public function testFilter()
    {
        print_r($this->makeResultArray());

        # code...
    }

    private function makeResultArray()
    {
        $size = mt_rand(5, 20);
        $resultArray = array();
        for ($i = 0; $i < $size; $i++) {
            $room = mt_rand(10000, 99999);
            $resultArray[$room] = 'getContractRoomTypeID';
        }

        return $this->makeRequestArray($resultArray);
    }


    private function makeRequestArray($resultArray)
    {
        $requestArray = array();
        $numOfRequest = mt_rand(1, 4);
        $numOfRequest = 4;

        for ($i = 0; $i < $numOfRequest; $i++) {
            $requestArray[$i] = array();
            $numofRooms = mt_rand(10, 99);
            $insert = (int) $numofRooms / 2;

            for ($a = 0; $a < $numofRooms; $a++) {
                $room = ['getContractRoomTypeID' => mt_rand(10000, 99999)];
                array_push($requestArray[$i], $room);

                if ($i == $insert) {
                    array_push($requestArray[$i], $resultArray);
                }
            }
        }

        return $requestArray;
    }
}

// $a = new myRoomFilterTest();
// $a->testFilter();


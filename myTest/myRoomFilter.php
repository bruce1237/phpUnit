<?php

namespace myTest;

class myRoomFilter
{
    public function filter($searchResult)
    {

        // echo $result[0][0]['getContractRoomTypeID'];

        $result = array();
        for ($i = 0; $i < count($searchResult); $i++) {

            foreach ($searchResult[$i] as $key => $value) {
                // var_dump($value['getContractRoomTypeID']);exit;
                $result[$i][$value['getContractRoomTypeID']] = $key;
            }
        }

        // var_dump($searchResult[0][0]['getContractRoomTypeID']);exit;

        // print_r($result);
        for ($i = 0; $i < count($result); $i++) {
            foreach ($result  as $key => $value) {
                $tmp[] = array_diff_key($result[$i], $result[$key]);
            }
        }

        // print_r($tmp);

        foreach ($tmp as $key => $tmpp) {
            foreach ($tmpp as $roomTypeID => $k) {

                foreach ($searchResult as $kk => $value) {
                    foreach ($value as $kkk => $vvv) {


                        if ($vvv['getContractRoomTypeID'] == $roomTypeID) {
                            unset($searchResult[$kk][$kkk]);
                        }
                    }
                }
            }
        }

        return $this->refineResult($searchResult);
        return $searchResult;
    }



    private function refineResult($inputArray){
        $result = array();

        foreach($inputArray as $key=>$value){
            foreach($value as $kk=>$vv){
                
                
              
                foreach($vv as $k=>$v){
                    $result[$v]=$k;
                }
            }
        }

        return $result;
    }


}

$searchResult = [
    [ //result of roomRequest1
        ['getContractRoomTypeID' =>     38219,],
        ['getContractRoomTypeID' =>     38220,],
        ['getContractRoomTypeID' =>     38221,],
        ['getContractRoomTypeID' =>     38222,],
        ['getContractRoomTypeID' =>     38223,],
        ['getContractRoomTypeID' =>     38229,],
        ['getContractRoomTypeID' =>     38230,],
        ['getContractRoomTypeID' =>     38231,],
        ['getContractRoomTypeID' =>     38232,],
        ['getContractRoomTypeID' =>     38233,],
        ['getContractRoomTypeID' =>     38234,],
        ['getContractRoomTypeID' =>     38235,],
        ['getContractRoomTypeID' =>     38236,],

    ],
    [ //result of roomRequest2
        ['getContractRoomTypeID' =>     38222,],
        ['getContractRoomTypeID' =>     38221,],
        ['getContractRoomTypeID' =>     38223,],
        ['getContractRoomTypeID' =>     38224,],
        ['getContractRoomTypeID' =>     38225,],
        ['getContractRoomTypeID' =>     38226,],
        ['getContractRoomTypeID' =>     38227,],
        ['getContractRoomTypeID' =>     38228,],
        ['getContractRoomTypeID' =>     38229,],
        ['getContractRoomTypeID' =>     38230,],
        ['getContractRoomTypeID' =>     38231,],
        ['getContractRoomTypeID' =>     38232,],
        ['getContractRoomTypeID' =>     38235,],
        ['getContractRoomTypeID' =>     38236,],
        ['getContractRoomTypeID' =>     38237,],
        ['getContractRoomTypeID' =>     38238,],
        ['getContractRoomTypeID' =>     38239,],
        ['getContractRoomTypeID' =>     38240,],
        ['getContractRoomTypeID' =>     38241,],

    ],
    [ //result of roomRequest3
        ['getContractRoomTypeID' =>     38222,],
        ['getContractRoomTypeID' =>     38223,],
        ['getContractRoomTypeID' =>     38224,],
        ['getContractRoomTypeID' =>     38225,],
        ['getContractRoomTypeID' =>     38226,],
        ['getContractRoomTypeID' =>     38227,],
        ['getContractRoomTypeID' =>     38228,],
        ['getContractRoomTypeID' =>     38229,],
        ['getContractRoomTypeID' =>     38230,],
        ['getContractRoomTypeID' =>     38231,],
        ['getContractRoomTypeID' =>     38232,],
        ['getContractRoomTypeID' =>     38233,],
        ['getContractRoomTypeID' =>     38234,],
        ['getContractRoomTypeID' =>     38235,],
        ['getContractRoomTypeID' =>     38236,],
        ['getContractRoomTypeID' =>     38237,],
        ['getContractRoomTypeID' =>     38238,],
        ['getContractRoomTypeID' =>     38239,],
        ['getContractRoomTypeID' =>     38240,],
        ['getContractRoomTypeID' =>     38241,],
        ['getContractRoomTypeID' =>     38242,],
        ['getContractRoomTypeID' =>     38243,],
        ['getContractRoomTypeID' =>     38244,],
        ['getContractRoomTypeID' =>     38245,],


    ],
    [ //result of roomRequest4
        ['getContractRoomTypeID' =>     38229,],
        ['getContractRoomTypeID' =>     38230,],
        ['getContractRoomTypeID' =>     38231,],
        ['getContractRoomTypeID' =>     38232,],
        ['getContractRoomTypeID' =>     38233,],
        ['getContractRoomTypeID' =>     38234,],
        ['getContractRoomTypeID' =>     38235,],
        ['getContractRoomTypeID' =>     38236,],
        ['getContractRoomTypeID' =>     38238,],
        ['getContractRoomTypeID' =>     38239,],
        ['getContractRoomTypeID' =>     38240,],
        ['getContractRoomTypeID' =>     38241,],
        ['getContractRoomTypeID' =>     38242,],
        ['getContractRoomTypeID' =>     38243,],
        ['getContractRoomTypeID' =>     38244,],
        ['getContractRoomTypeID' =>     38245,],

    ],
];

$a = new myRoomFilter();
// var_dump($a->filter($searchResult));

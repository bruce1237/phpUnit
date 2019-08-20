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

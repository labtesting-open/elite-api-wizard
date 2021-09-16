<?php

namespace Elitesports;
//Rivest, Shamir y Adleman
class RSA
{
    private $privatekey;
    private $publicKey;

    public function __construct($publicKey=null, $privateKey=null)
    {
        $this->privatekey = $privateKey;
        $this->publicKey = $publicKey;
    }

    public function getPrivateKey()
    {
        return $this->privatekey;
    }

    public function setPrivateKey($privatekey)
    {
        $this->privatekey = $privatekey;
    }

    public function getPublicKey()
    {
        return $this->publicKey;
    }

    public function setPublicKey($publicKey)
    {
        $this->publicKey = $publicKey;
    }

    private function applyPublicKey($binWordsList){
        $newList = array();
        $count = 0;
        foreach($binWordsList as $key=> $word){
            $count++;
            if($count > strlen($this->publicKey)){
                array_push($newList,$word);
            }    
        }
        return $newList;
    }

    private function applyPrivateKey($binList){
        
    }

    public function decode($binList){

        $listWords = $this->getArrayWords($binList);

        $binListPublicKey = $this->applyPublicKey($listWords);

        //$binListPrivateKey = $this->applyPrivateKey($binListPublicKey);   

        return $this->binToWords($binListPublicKey);
    }


    public function getArrayWords($binList){
        
        $arrayBin = array();
        $numCount = 0;
        $binNumAcum = null;             

        for($item = 0; $item < strlen($binList); $item++ ){
            $numCount++;
            if($numCount <= 7){
                $binNumAcum.= $binList[$item];
            }else{
                array_push($arrayBin,$binNumAcum);
                $binNumAcum = $binList[$item];
                $numCount = 1;
            }
        }

        return $arrayBin;        
    }

    public function binToWords($binList){

        $newarray= array();
       // $wordList = $this->getArrayWords($binList);

        foreach($binList as $key =>$bin){
            array_push($newarray,chr(bindec($bin)));
        }

        return $newarray;

    }







}
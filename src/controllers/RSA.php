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

    private function applyPrivateKey($binWordsList){

        $newList = array();
        $limit = count($binWordsList) - strlen($this->privatekey);
        $count = 0;
        foreach($binWordsList as $key=> $word){
            
            if($count <= $limit){
                array_push($newList,$word);
            }    
            $count++;
        }
        return $newList;
        
    }

    private function decodeWithKeys($passDecodedBase64){
        
        $passwithoutPublicKey = null;
        $publicKey = null;

        $passLen = strlen($passDecodedBase64) - strlen($this->publicKey);    
        
        $chinesseChars = preg_replace(array('/[^\p{Han}？]/u', '/(\s)+/'), array('', '$1'), $passDecodedBase64);

        if($chinesseChars != ''){
            
            $passwithoutPublicKey = $chinesseChars;

        }else{

            $passDecodedBase64 = $this->replaceEspecialChars($passDecodedBase64);

            if($passLen > strlen($this->publicKey)){
            
                $limitPublicKey = strlen($this->publicKey) * 2;
                
                for ($i = 0; $i < strlen($passDecodedBase64); $i++) {
    
                    if( $i < $limitPublicKey){
        
                        if( $i % 2 == 0){
                            $publicKey .= $passDecodedBase64[$i];     
                        }else{
                            $passwithoutPublicKey .= $passDecodedBase64[$i];
                        }
                    }else{
                        $passwithoutPublicKey .= $passDecodedBase64[$i];
                    }
                }
            }      

            if($passLen <= strlen($this->publicKey)){
    
                $limitPublicKey = strlen($this->publicKey);
    
                for ($i = 0; $i < strlen($passDecodedBase64) ; $i++) {
    
                    //echo "$i-$passDecodedBase64[$i],";
                    if( $i < $passLen*2){
        
                        if( $i % 2 == 0){
                            $publicKey .= $passDecodedBase64[$i];     
                        }else{
                            $passwithoutPublicKey .= $passDecodedBase64[$i];
                        }
                    }
                }
            }
        }        

        return $passwithoutPublicKey;

    }


    private function replaceEspecialChars($s) {

        $s = str_replace("[áàâãª]","a",$s);
        $s = str_replace("[ÁÀÂÃ]","A",$s);
        $s = str_replace("[éèê]","e",$s);
        $s = str_replace("[ÉÈÊ]","E",$s);
        $s = str_replace("[íìî]","i",$s);
        $s = str_replace("[ÍÌÎ]","I",$s);
        $s = str_replace("[óòôõº]","o",$s);
        $s = str_replace("[ÓÒÔÕ]","O",$s);
        $s = str_replace("[úùû]","u",$s);
        $s = str_replace("[ÚÙÛ]","U",$s);
        $s = str_replace(" ","-",$s);
        $s = str_replace("ñ","n",$s);
        $s = str_replace("Ñ","N",$s);

        return $s;
    }

    public function decodeBin($binList){

        $binWordsList = $this->getArrayWords($binList);

        $binListPublicKey = $this->applyPublicKey($binWordsList);

        $binListPrivateKey = $this->applyPrivateKey($binListPublicKey);   

        $arrayWords =  $this->binToWords($binListPrivateKey);

        return implode($arrayWords); 
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

        foreach($binList as $key =>$bin){
            array_push($newarray,chr(bindec($bin)));
        }

        return $newarray;

    }


    public function decodeBase64($pass){

        $passReturned = null;
         
        $passDecoded = base64_decode($pass, true);

        if($passDecoded){           
            $passDecodedWithPublicKey = $this->decodeWithKeys($passDecoded);
            $passReturned = $passDecodedWithPublicKey;
        }

        return $passReturned;
    }







}
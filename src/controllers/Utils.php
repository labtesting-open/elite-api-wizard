<?php

namespace Elitesports;

class Utils
{

    public static function getStringArray($data, $value)
    {

        $stringArray = array();

        foreach ($data as $item) {
            array_push($stringArray, $item[$value]);
        }

        return $stringArray;
    }


    public static function filter($str)
    {

        $toReplace = array("'",'/', '\\');
        return str_replace($toReplace, '-', $str);
    }

    public static function checkIssetEmptyNumeric()
    {
        foreach (func_get_args() as $arg) {
            if (isset($arg) && !empty($arg) && is_numeric($arg)) {
                continue;
            } else {
                return false;
            }
        }
        return true;
    }

    public static function getkey($keyList, $target, $type=null){
        
        $matchResult = null;

        if(isset($target) && isset($keyList)){
            foreach($keyList as $key =>$value){
                if(strtolower($key) == $target){
                    $matchResult = $value;
                }
            }
        }

        if(isset($type) && $type == 'Bearer'){
            $matchResult = substr($matchResult,strlen($type));
        }

        return trim($matchResult);
    }    

}

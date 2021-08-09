<?php

namespace Elitesports;

class Utils{

    public static function getStringArray($data, $value){

        $stringArray = array();

        foreach($data as $item){
            array_push($stringArray, $item[$value]);
        }  

        return $stringArray;

    }


    public static function filter($str){

        $toReplace = array("'","/", "\\");
        return str_replace($toReplace, "-", $str);

    }

    public static function checkIssetEmptyNumeric(){
        foreach(func_get_args() as $arg)
            if(isset($arg) && !empty($arg) && is_numeric($arg))
                continue;
            else
                return false;
        return true;
    }


}
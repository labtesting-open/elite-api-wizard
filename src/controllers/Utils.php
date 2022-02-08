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
            if (!isset($arg) || empty($arg) || !is_numeric($arg)) {
                return false;
            }
        }
        return true;
    }


    private static function notEmptyAndNumeric($listKeys, $key)
    {

        $result = false;

        foreach ($listKeys as $param => $value) {
            if ($param == $key && !empty($value) && is_numeric($value)) {
                $result = true;
                break;
            }
        }

        return $result;
    }

    public static function checkParamsIssetAndNumeric($paramList, $keyList)
    {
        $utils = new Utils();

        $checkResult = true;

        if (count($paramList) > 0 && count($keyList) > 0) {
            foreach ($keyList as $key) {
                $chekValue = $utils->notEmptyAndNumeric($paramList, $key);

                if (!$chekValue) {
                    $checkResult = false;
                    break;
                }
            }
        } else {
            $checkResult = false;
        }

        return $checkResult;
    }


    public static function getkey($keyList, $target, $type = null)
    {
        
        $matchResult = null;

        if (isset($target) && isset($keyList)) {
            foreach ($keyList as $key => $value) {
                if (strtolower($key) == $target) {
                    $matchResult = $value;
                }
            }
        }

        if (isset($type) && $type == 'Bearer') {
            $matchResult = substr($matchResult, strlen($type));
        }

        return trim($matchResult);
    }
    
    
    public static function getAllParams($requestList, $outputMode = null)
    {

        $paramList = array();

        foreach ($requestList as $key => $value) {
            $paramList[$key] = $value;
        }

        if (isset($outputMode) && $outputMode == OutputsTypes::JSON) {
            $paramList = json_encode($paramList, true);
        }
        return $paramList;
    }
    

    public static function normalizerParams($received, $acepted)
    {
        $normalized = array();

        if (!empty($received)) {
            foreach ($acepted as $key => $value) {
                if (array_key_exists($key, $received)) {
                    if ($key == 'limit' && (!is_numeric($received[$key]) || $received[$key] <= 0)) {
                        $normalized[$key] = 100;
                    } else {
                        $normalized[$key] = $received[$key];
                    }
                } else {
                    $normalized[$key] = $value;
                }
            }
        } else {
            $normalized = $acepted;
        }

        return $normalized;
    }

    public static function getPaginateInfo($totalRows, $limit)
    {
        $totalPages = ceil($totalRows / $limit);

        $paginate  = array(
            'rows' => $totalRows,
            'pages' => $totalPages
        );

        return $paginate;
    }


    public static function getPaginateInfoWithTypeItem($totalRows, $limit, $typeItem = null)
    {
        $totalPages = ceil($totalRows / $limit);

        $paginate  = array(
            'rows' => $totalRows,
            'pages' => $totalPages,
            'type_item' => $typeItem
        );

        return $paginate;
    }


    public static function isImage($fileType)
    {
        
        if (strpos($fileType, 'image') !== false) {
            return true;
        }
        
        return false;
    }
}

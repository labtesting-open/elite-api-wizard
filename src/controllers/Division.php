<?php

namespace Elitesports;

use stdClass;

class Division
{
    private $division;
    private $token;
    private $respuestas;

    public function __construct()
    {
        $host = new HostConnection();
        $this->division = new \Elitelib\Division($host->getParams());
        $this->respuestas  = new Respuestas();
        $this->token = new Token();
    }


    public function checkTokenAndReturnResponse($json)
    {
        return $this->token->checkAndReturnResponseInBody($json);
    }

    
    public function getAvailableDivisions($json)
    {
        $paramsReceived = json_decode($json, true);

        $paramsAcepted = array(
            'continent_code' => null,
            'country_code' => null,
            'category_id' => null,
            'division_id' => null
        );

        $paramsNormaliced = Utils::normalizerParams($paramsReceived, $paramsAcepted);        

        $result = $this->division->getAvailableDivisions(
            $paramsNormaliced['continent_code'],
            $paramsNormaliced['country_code'],
            $paramsNormaliced['category_id'],
            $paramsNormaliced['division_id']
        );

        $responseHttp = $this->respuestas->standarSuccess($result);       

        return $responseHttp;
    }


    public function getAllDivisions($json)
    {

        $responseHttp = $this->checkTokenAndReturnResponse($json);

        if (is_null($responseHttp)) {
            $datos = json_decode($json, true);
           
            $countryCode = null;
            if (isset($datos['country_code']) &&  !empty($datos['country_code'])) {
                $countryCode = $datos['country_code'];
            }
            $categoryId = null;
            if (isset($datos['category_id']) &&  !empty($datos['category_id'])) {
                $categoryId = $datos['category_id'];
            }
            
            $info = $this->division->getAllDivisions(
                $countryCode,
                $categoryId
            );

            $resultado = new stdClass();
            $resultado->status = 'ok';
            $resultado->result = new stdClass();
            $resultado->result = $info;
                    
            $responseHttp =  $resultado;
        }

        return $responseHttp;
    }
}

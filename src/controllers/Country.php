<?php

namespace Elitesports;

use stdClass;

class Country
{
    private $country;
    private $token;
    private $respuestas;

    public function __construct()
    {
        $host = new HostConnection();
        $this->country = new \Elitelib\Country($host->getParams());
        $this->respuestas  = new Respuestas();
        $this->token = new Token();
    }


    public function checkTokenAndReturnResponse($json)
    {
        return $this->token->checkAndReturnResponseInBody($json);
    }

    
    public function getAvailableCountries($json)
    {
        $paramsReceived = json_decode($json, true);

        $paramsAcepted = array(
            'continent_code' => null,
            'country_code' => null,
            'category_id' => null,
            'division_id' => null
        );

        $paramsNormaliced = Utils::normalizerParams($paramsReceived, $paramsAcepted);

        $result = $this->category->getAvailableCountries(
            $paramsNormaliced['continent_code'],
            $paramsNormaliced['country_code'],
            $paramsNormaliced['category_id'],
            $paramsNormaliced['division_id']
        );

        return $this->respuestas->standarSuccess($result);
    }


    public function getAllCountries()
    {
        $info = $this->country->get();

        $resultado = new stdClass();
        $resultado->status = 'ok';
        $resultado->result = new stdClass();
        $resultado->result = $info;

        return $resultado;
    }
}

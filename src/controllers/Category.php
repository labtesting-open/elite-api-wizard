<?php

namespace Elitesports;

use stdClass;

class Category
{
    private $category;
    private $token;
    private $respuestas;

    public function __construct()
    {
        $host = new HostConnection();
        $this->category = new \Elitelib\Category($host->getParams());
        $this->respuestas  = new Respuestas();
        $this->token = new Token();
    }


    public function checkTokenAndReturnResponse($json)
    {
        return $this->token->checkAndReturnResponseInBody($json);
    }

    
    public function getAvailableCategories($json)
    {
        $paramsReceived = json_decode($json, true);

        $paramsAcepted = array(
            'continent_code' => null,
            'country_code' => null,
            'category_id' => null,
            'division_id' => null
        );

        $paramsNormaliced = Utils::normalizerParams($paramsReceived, $paramsAcepted);

        $result = $this->category->getAvailableCategories(
            $paramsNormaliced['continent_code'],
            $paramsNormaliced['country_code'],
            $paramsNormaliced['category_id'],
            $paramsNormaliced['division_id']
        );

        $responseHttp = $this->respuestas->standarSuccess($result);

        return $responseHttp;
    }


    public function getAllCategories()
    {
        $info = $this->category->getAll();

        $resultado = new stdClass();
        $resultado->status = 'ok';
        $resultado->result = new stdClass();
        $resultado->result = $info;

        return $resultado;
    }
}

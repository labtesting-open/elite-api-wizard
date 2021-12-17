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

        $responseHttp = $this->checkTokenAndReturnResponse($json);

        if (is_null($responseHttp)) {
            $datos = json_decode($json, true);

            $continentCode = null;
            if (isset($datos['continent_code']) &&  !empty($datos['continent_code'])) {
                $continentCode = $datos['continent_code'];
            }
            $countryCode = null;
            if (isset($datos['country_code']) &&  !empty($datos['country_code'])) {
                $countryCode = $datos['country_code'];
            }
            $categoryId = null;
            if (isset($datos['category_id']) &&  !empty($datos['category_id'])) {
                $categoryId = $datos['category_id'];
            }
            $divisionId = null;
            if (isset($datos['division_id']) &&  !empty($datos['division_id'])) {
                $divisionId = $datos['division_id'];
            }            
            
            $info = $this->category->getAvailableCategories(
                $continentCode,
                $countryCode,
                $categoryId,
                $divisionId               
            );

            $resultado = new stdClass();
            $resultado->status = 'ok';
            $resultado->result = new stdClass();
            $resultado->result = $info;
                    
            $responseHttp =  $resultado;
        }

        return $responseHttp;
    }


    public function getAllCategories()
    { 
        $info = $this->category->getAll();

        $resultado = new stdClass();
        $resultado->status = 'ok';
        $resultado->result = new stdClass();
        $resultado->result = $info;
                
        $responseHttp =  $resultado;

        return $responseHttp;
    }

}

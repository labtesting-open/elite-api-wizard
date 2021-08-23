<?php

namespace Elitesports;

use Elitesports\Respuestas;
use stdClass;

class Club
{
    private $club;
    private $token;
    private $respuestas;

    public function __construct()
    {
        $this->club = new \Elitelib\Club();
        $this->token = new \Elitelib\Token();
        $this->respuestas  = new Respuestas();
    }

    public function getInfo($json)
    {
           
        $datos = json_decode($json, true);

        if (!isset($datos['token'])) {
            return $this->respuestas->error401();
        } else {
            $testToken = $this->token->checkToken($datos['token']);

            if ($testToken) {
                if (isset($datos['club_id']) && is_numeric($datos['club_id'])) {
                    $info = $this->club->getBasicInfo($datos['club_id']);

                    $resultado = new stdClass();
                    $resultado->status = 'ok';
                    $resultado->result = new stdClass();
                    $resultado->result = $info;
                        
                    return $resultado;
                } else {
                    return $this->respuestas->error200('Data incorrect or incomplete');
                }
            } else {
                return $this->respuestas->error401('Token invalid or expired');
            }
        }
    }
    
    public function getInfoWithFilters($json)
    {
           
        $datos = json_decode($json, true);

        if (!isset($datos['token'])) {
            return $this->respuestas->error401();
        } else {
            $testToken = $this->token->checkToken($datos['token']);

            if ($testToken) {
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
                $page = 1;
                if (isset($datos['page']) &&  is_numeric($datos['page'])) {
                    $page = $datos['page'];
                }
                $cant = 100;
                if (isset($datos['cant']) &&  is_numeric($datos['cant'])) {
                    $cant = $datos['cant'];
                }
                
                $info = $this->club->getClubsByFilters(
                    $continentCode,
                    $countryCode,
                    $categoryId,
                    $divisionId,
                    $page,
                    $cant
                );

                $resultado = new stdClass();
                $resultado->status = 'ok';
                $resultado->result = new stdClass();
                $resultado->result = $info;
                        
                return $resultado;
            } else {
                return $this->respuestas->error401('Token invalid or expired');
            }
        }
    }
}

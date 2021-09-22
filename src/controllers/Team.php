<?php

namespace Elitesports;

use stdClass;

class Team
{

    private $team;
    private $club;
    private $token;
    private $respuestas;

    public function __construct()
    {
        $this->team = new \Elitelib\Team();
        $this->token = new Token();
        $this->respuestas  = new Respuestas();
        $this->club = new \Elitelib\Club();
    }



    public function getClubTeams($json)
    {
        $responseHttp = $this->respuestas->error200(ResponseHttp::DATAINCORRECTORINCOMPLETE);
       
        $datos = json_decode($json, true);

        if (isset($datos['club_id']) && is_numeric($datos['club_id'])) {
            $countryCode   = (isset($datos['country_code'])) ? $datos['country_code'] : null;

            $info = $this->team->getTeams($datos['club_id'], $countryCode);

            $infoTeams = new stdClass();
            $infoTeams = $info;
            $responseHttp = $this->respuestas->standarResponse('ok', $infoTeams);
        }
        
        return $responseHttp;
    }


    public function getInfoWithFilters($token, $json)
    {
        $responseHttp = $this->respuestas->error200(ResponseHttp::DATAINCORRECTORINCOMPLETE);

        $params = json_decode($json, true); 

        $continentCode = null;
        if (isset($params['continent_code']) &&  !empty($params['continent_code'])) {
            $continentCode = $params['continent_code'];
        }
        $countryCode = null;
        if (isset($params['country_code']) &&  !empty($params['country_code'])) {
            $countryCode = $params['country_code'];
        }
        $categoryId = null;
        if (isset($params['category_id']) &&  !empty($params['category_id'])) {
            $categoryId = $params['category_id'];
        }
        $divisionId = null;
        if (isset($params['division_id']) &&  !empty($params['division_id'])) {
            $divisionId = $params['division_id'];
        }
        $page = 1;
        if (isset($params['page']) &&  is_numeric($params['page'])) {
            $page = $params['page'];
        }
        $cant = 100;
        if (isset($params['cant']) &&  is_numeric($params['cant'])) {
            $cant = $params['cant'];
        }
        $order = null;
        if (isset($params['order']) &&  !empty($params['order'])) {
            $order = $params['order'];
        }
        $orderSense = null;
        if (isset($params['order_sense']) &&  !empty($params['order_sense'])) {
            $orderSense = $params['order_sense'];
        }
        $translateCode = 'GB';
        if (isset($params['language_id']) &&  !empty($params['language_id'])) {
            $translateCode = $params['language_id'];
        }
        
        $info = $this->team->getTeamsByFilters(
            $continentCode,
            $countryCode,
            $categoryId,
            $divisionId,
            $page,
            $cant,
            $order,
            $orderSense,
            $translateCode
        );

        $infoTeams = new stdClass();
        $infoTeams = $info;
        $responseHttp = $this->respuestas->standarResponse('ok', $infoTeams);

        return $responseHttp;
    }



    public function getAvailableFilters($json)
    {
        $responseHttp = $this->respuestas->error200(ResponseHttp::DATAINCORRECTORINCOMPLETE);
        
        $datos = json_decode($json, true);

        if (isset($datos['target']) && $this->checkTarget($datos['target'])) {

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

            $result = new stdClass();
            
            if ($datos['target'] == 'continents') {
                $result = $this->club->getAvailableContinents(
                    $continentCode,
                    $countryCode,
                    $categoryId,
                    $divisionId
                );
            }
            
            if ($datos['target'] == 'countries') {
                $result = $this->club->getAvailableCountries(
                    $continentCode,
                    $countryCode,
                    $categoryId,
                    $divisionId
                );
            }
            
            if ($datos['target'] == 'categories') {
                $result = $this->team->getAvailableCategories(
                    $continentCode,
                    $countryCode,
                    $categoryId,
                    $divisionId
                );
            }
            
            if ($datos['target'] == 'divisions') {
                $result = $this->club->getAvailableDivisions(
                    $continentCode,
                    $countryCode,
                    $categoryId,
                    $divisionId
                );
            }
            
            if ($datos['target'] == 'all') {
                $result->continents = $this->club->getAvailableContinents(
                    $continentCode,
                    $countryCode,
                    $categoryId,
                    $divisionId
                );

                $result->countries  = $this->club->getAvailableCountries(
                    $continentCode,
                    $countryCode,
                    $categoryId,
                    $divisionId
                );

                $result->categories = $this->team->getAvailableCategories(
                    $continentCode,
                    $countryCode,
                    $categoryId,
                    $divisionId
                );

                $result->divisions  = $this->club->getAvailableDivisions(
                    $continentCode,
                    $countryCode,
                    $categoryId,
                    $divisionId
                );
            }

            $responseHttp = $this->respuestas->standarResponse('ok', $result);
        }

        return $responseHttp;
    }


    private function checkTarget($target)
    {
        $filters = array('continents', 'countries', 'categories', 'divisions', 'all');

        return in_array(strtolower($target), $filters);
    }
}

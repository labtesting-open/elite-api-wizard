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

        $responseHttp = $this->token->checkAndReturnResponse($json);

        if ($responseHttp == null) {
            $datos = json_decode($json, true);

            if (isset($datos['club_id']) && is_numeric($datos['club_id'])) {
                $countryCode   = (isset($datos['country_code'])) ? $datos['country_code'] : null;

                $info = $this->team->getTeams($datos['club_id'], $countryCode);

                $resultado = new stdClass();
                $resultado->status = 'ok';
                $resultado->result = new stdClass();
                $resultado->result = $info;

                $responseHttp = $resultado;
            } else {
                $responseHttp = $this->respuestas->error200(ResponseHttp::DATAINCORRECTORINCOMPLETE);
            }
        }

        return $responseHttp;
    }


    public function getInfoWithFilters($json)
    {

        $responseHttp = $this->token->checkAndReturnResponse($json);

        if ($responseHttp == null) {
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
            $page = 1;
            if (isset($datos['page']) &&  is_numeric($datos['page'])) {
                $page = $datos['page'];
            }
            $cant = 100;
            if (isset($datos['cant']) &&  is_numeric($datos['cant'])) {
                $cant = $datos['cant'];
            }
            $order = null;
            if (isset($datos['order']) &&  !empty($datos['order'])) {
                $order = $datos['order'];
            }
            $orderSense = null;
            if (isset($datos['order_sense']) &&  !empty($datos['order_sense'])) {
                $orderSense = $datos['order_sense'];
            }
            $translateCode = 'GB';
            if (isset($datos['language_id']) &&  !empty($datos['language_id'])) {
                $translateCode = $datos['language_id'];
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

            $resultado = new stdClass();
            $resultado->status = 'ok';
            $resultado->result = new stdClass();
            $resultado->result = $info;

            $responseHttp = $resultado;
        }

        return $responseHttp;
    }



    public function getAvailableFilters($json)
    {
        $responseHttp = $this->token->checkAndReturnResponse($json);

        if ($responseHttp == null) {
            $datos = json_decode($json, true);

            if (isset($datos['target']) && $this->checkTarget($datos['target'])) {
                $resultado = new stdClass();
                $resultado->status = 'ok';
                $resultado->result = new stdClass();

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

                $resultado->result = $result;

                $responseHttp = $resultado;
            } else {
                $responseHttp = $this->respuestas->error200(ResponseHttp::DATAINCORRECTORINCOMPLETE);
            }
        }

        return $responseHttp;
    }


    private function checkTarget($target)
    {
        $filters = array('continents', 'countries', 'categories', 'divisions', 'all');

        return in_array(strtolower($target), $filters);
    }
}

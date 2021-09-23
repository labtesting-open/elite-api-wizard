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
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);
       
        $datos = json_decode($json, true);

        if (isset($datos['club_id']) && is_numeric($datos['club_id'])) {
            $countryCode   = (isset($datos['country_code'])) ? $datos['country_code'] : null;

            $infoTeams = $this->team->getTeams($datos['club_id'], $countryCode);

            $responseHttp = $this->respuestas->standarSuccess($infoTeams);
        }
        
        return $responseHttp;
    }


    public function getInfoWithFilters($json)
    {
        $paramsReceived = json_decode($json, true);

        $paramsAcepted = array(
            'continent_code' => null,
            'country_code' => null,
            'category_id' => null,
            'division_id' => null,
            'page' => 1,
            'limit' => 100,
            'order' => null,
            'order_sense' => null,
            'translate_code' => 'GB'
        );

        $paramsNormaliced = Utils::normalizerParams($paramsReceived, $paramsAcepted);
        
        $infoTeams = $this->team->getTeamsByFilters(
            $paramsNormaliced['continent_code'],
            $paramsNormaliced['country_code'],
            $paramsNormaliced['category_id'],
            $paramsNormaliced['division_id'],
            $paramsNormaliced['page'],
            $paramsNormaliced['limit'],
            $paramsNormaliced['order'],
            $paramsNormaliced['order_sense'],
            $paramsNormaliced['translate_code']
        );

        return $this->respuestas->standarSuccess($infoTeams);
    }



    public function getAvailableFilters($json)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);
        
        $paramsReceived = json_decode($json, true);

        if (isset($paramsReceived['target']) && $this->checkTarget($paramsReceived['target'])) {
            $paramsAcepted = array(
                'continent_code' => null,
                'country_code' => null,
                'category_id' => null,
                'division_id' => null
            );

            $paramsNormaliced = Utils::normalizerParams($paramsReceived, $paramsAcepted);

            $result = new stdClass();
            
            if ($paramsReceived['target'] == 'continents') {
                $result = $this->club->getAvailableContinents(
                    $paramsNormaliced['continent_code'],
                    $paramsNormaliced['country_code'],
                    $paramsNormaliced['category_id'],
                    $paramsNormaliced['division_id']
                );
            }
            
            if ($paramsReceived['target'] == 'countries') {
                $result = $this->club->getAvailableCountries(
                    $paramsNormaliced['continent_code'],
                    $paramsNormaliced['country_code'],
                    $paramsNormaliced['category_id'],
                    $paramsNormaliced['division_id']
                );
            }
            
            if ($paramsReceived['target'] == 'categories') {
                $result = $this->team->getAvailableCategories(
                    $paramsNormaliced['continent_code'],
                    $paramsNormaliced['country_code'],
                    $paramsNormaliced['category_id'],
                    $paramsNormaliced['division_id']
                );
            }
            
            if ($paramsReceived['target'] == 'divisions') {
                $result = $this->club->getAvailableDivisions(
                    $paramsNormaliced['continent_code'],
                    $paramsNormaliced['country_code'],
                    $paramsNormaliced['category_id'],
                    $paramsNormaliced['division_id']
                );
            }
            
            if ($paramsReceived['target'] == 'all') {
                $result->continents = $this->club->getAvailableContinents(
                    $paramsNormaliced['continent_code'],
                    $paramsNormaliced['country_code'],
                    $paramsNormaliced['category_id'],
                    $paramsNormaliced['division_id']
                );

                $result->countries  = $this->club->getAvailableCountries(
                    $paramsNormaliced['continent_code'],
                    $paramsNormaliced['country_code'],
                    $paramsNormaliced['category_id'],
                    $paramsNormaliced['division_id']
                );

                $result->categories = $this->team->getAvailableCategories(
                    $paramsNormaliced['continent_code'],
                    $paramsNormaliced['country_code'],
                    $paramsNormaliced['category_id'],
                    $paramsNormaliced['division_id']
                );

                $result->divisions  = $this->club->getAvailableDivisions(
                    $paramsNormaliced['continent_code'],
                    $paramsNormaliced['country_code'],
                    $paramsNormaliced['category_id'],
                    $paramsNormaliced['division_id']
                );
            }

            $responseHttp = $this->respuestas->standarSuccess($result);
        }

        return $responseHttp;
    }


    private function checkTarget($target)
    {
        $filters = array('continents', 'countries', 'categories', 'divisions', 'all');

        return in_array(strtolower($target), $filters);
    }
}

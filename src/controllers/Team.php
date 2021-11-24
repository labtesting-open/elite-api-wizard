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
        $host = new HostConnection();
        $this->team = new \Elitelib\Team($host->getParams());
        $this->token = new Token();
        $this->respuestas  = new Respuestas();
        $this->club = new \Elitelib\Club($host->getParams());
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

    public function addTeam($json)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);

        $params = json_decode($json, true);

        $keys = array('club_id', 'division_id', 'category_id');

        if (Utils::checkParamsIssetAndNumeric($params, $keys) && isset($params['team_name'])) {
            $imgTeam = (isset($params['img_team'])) ? $params['img_team'] : null;
            
            $actionResult = $this->team->add(
                $params['club_id'],
                $params['category_id'],
                $params['division_id'],
                $params['team_name'],
                $imgTeam
            );

             $responseHttp = $this->respuestas->standarSuccess($actionResult);
        }

        return $responseHttp;
    }


    public function updateTeam($json)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);

        $params = json_decode($json, true);

        $keys = array('team_id', 'club_id', 'division_id', 'category_id');

        if (Utils::checkParamsIssetAndNumeric($params, $keys) && isset($params['team_name'])) {
            $imgTeam = (isset($params['img_team'])) ? $params['img_team'] : null;
            
            $actionResult = $this->team->update(
                $params['team_id'],
                $params['club_id'],
                $params['category_id'],
                $params['division_id'],
                $params['team_name'],
                $imgTeam
            );

             $responseHttp = $this->respuestas->standarSuccess($actionResult);
        }

        return $responseHttp;
    }


    public function deleteTeam($json)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);

        $params = json_decode($json, true);

        $keys = array('team_id');

        if (Utils::checkParamsIssetAndNumeric($params, $keys)) {
            $matchesPlayed = $this->team->getNumberOfMatchesPlayedByTeam($params['team_id']);

            if ($matchesPlayed[0]['matches'] == 0) {
                $nacionalities = $this->team->deleteAllPlayersNacionalitiesFromTeam($params['team_id']);
    
                $injuries = $this->team->deleteAllPlayersInjuriesFromTeam($params['team_id']);
    
                $socialMedia = $this->team->deleteAllPlayersSocialMediaFromTeam($params['team_id']);
    
                $mapPositionsSecondary = $this->team->deleteAllPlayersMapPositionSecondaryFromTeam($params['team_id']);
    
                $teamPlayers = $this->team->deleteTeamPlayers($params['team_id']);
                
                $team = $this->team->delete($params['team_id']);

                $affected = array(
                    'nacionalities' => $nacionalities,
                    'injuries' => $injuries,
                    'socialMedia' => $socialMedia,
                    'mapPositionsSecondary' => $mapPositionsSecondary,
                    'teamPlayers' => $teamPlayers,
                    'team' => $team
                );

                $responseHttp = $this->respuestas->standarSuccess($affected);
            } else {
                $responseHttp = $this->respuestas->error401('The team has matches played, delete is not allowed');
            }
        }

        return $responseHttp;
    }


    public function getTeamsWithFilters($json)
    {
        $paramsReceived = json_decode($json, true);

        $paramsAcepted = array(
            'continent_code' => null,
            'country_code' => null,
            'category_id' => null,
            'division_id' => null,
            'page' => 1,
            'limit' => 100,
            'order' => 'club_name',
            'order_sense' => 'DESC',
            'language_code' => 'GB'
        );

        $paramsNormaliced = Utils::normalizerParams($paramsReceived, $paramsAcepted);
        
        $infoTeams = $this->team->getAvailableTeamsWithFilters(
            $paramsNormaliced['continent_code'],
            $paramsNormaliced['country_code'],
            $paramsNormaliced['category_id'],
            $paramsNormaliced['division_id'],
            $paramsNormaliced['order'],
            $paramsNormaliced['order_sense'],
            $paramsNormaliced['page'],
            $paramsNormaliced['limit'],
            $paramsNormaliced['language_code']
        );

        $totalRows = $this->team->getAvailableTeamsWithFiltersTotalRows(
            $paramsNormaliced['continent_code'],
            $paramsNormaliced['country_code'],
            $paramsNormaliced['category_id'],
            $paramsNormaliced['division_id'],
            $paramsNormaliced['order'],
            $paramsNormaliced['order_sense'],
            $paramsNormaliced['page'],
            $paramsNormaliced['limit'],
            $paramsNormaliced['language_code']
        );

        $paginate = Utils::getPaginateInfo($totalRows, $paramsNormaliced['limit']);

        return $this->respuestas->standarSuccessPaginate($infoTeams, $paginate);
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

    public function getTeamToEdit($json)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);
        
        $params = json_decode($json, true);

        $keys = array('team_id');

        if (Utils::checkParamsIssetAndNumeric($params, $keys)) {
            $result = new stdClass();

            $team = $this->team->getTeam($params['team_id']);

            $result->team = $team[0];

            $result->categories = $this->team->getAvailableCategories(
                null,
                $team[0]['country_code'],
                null,
                null
            );

            $result->divisions  = $this->club->getAvailableDivisions(
                null,
                $team[0]['country_code'],
                null,
                null
            );
            

            $responseHttp = $this->respuestas->standarSuccess($result);
        }

        return $responseHttp;
    }
}

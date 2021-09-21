<?php

namespace Elitesports;

use Elitesports\Respuestas;
use stdClass;
use Elitesports\Utils;

class Player
{
    

    private $token;
    private $player;
    private $club;
    private $team;
    private $respuestas;

    public function __construct()
    {
        $this->player = new \Elitelib\Player();
        $this->token = new \Elitelib\Token();
        $this->club = new \Elitelib\Club();
        $this->team = new \Elitelib\Team();
        $this->respuestas  = new Respuestas();
    }


    public function getTeamSeasonPlayers($json)
    {

        $responseHttp = $this->respuestas->error200(ResponseHttp::DATAINCORRECTORINCOMPLETE);
       
        $params = json_decode($json, true);

        $keys = array('club_id', 'team_id');

        if (Utils::checkParamsIssetAndNumeric($params, $keys)) {
           
            $countryCode   = (isset($params['country_code'])) ? $params['country_code'] : null;

            $categories = array();

            $categoriesList = $this->player->getCategoriesByLanguage($countryCode);

            for ($positionId = 1; $positionId <= 4; $positionId++) {
                if (isset($params['season_id']) && $params['season_id'] != '') {
                        $playersList = $this->player->getTeamPlayersInfoAndStaticsByPosition(
                            $params['club_id'],
                            $params['team_id'],
                            $params['season_id'],
                            $countryCode,
                            $positionId,
                            'players.name',
                            null
                        );
                } else {
                        $playersList = $this->player->getTeamPlayersInfoByPosition(
                            $params['club_id'],
                            $params['team_id'],
                            $countryCode,
                            $positionId,
                            'players.name',
                            null
                        );
                }

                $itemPlayersCategory = new stdClass();
                $itemPlayersCategory->name = $categoriesList[$positionId - 1]['name'];
                $itemPlayersCategory->players = $playersList;
                
                array_push($categories, $itemPlayersCategory);
            }

            $playersResult = new stdClass();
            $playersResult->categories = $categories;
            
            $responseHttp = $this->respuestas->standarResponse('ok', $playersResult);
        }

        return $responseHttp;

    }


    public function getTeamSeasonPlayerStatics($json)
    {
        $responseHttp = $this->respuestas->error200(ResponseHttp::DATAINCORRECTORINCOMPLETE);

        $params = json_decode($json, true);

        $keys = array('id');            
           
        if (Utils::checkParamsIssetAndNumeric($params, $keys)) {

            $actions = array();
            $countryCode   = (isset($params['country_code'])) ? $params['country_code'] : null;
            $positionId = $this->player->getPosition_id($params['id']);
            $actionList = $this->player->getActionIdList($positionId);
            $actionNameList = $this->player->getActionNameList($actionList, $countryCode);
            $i = 0;
            
            foreach ($actionList as $actionId) {
                $actionsObtained = $this->player->getPlayerActionsByAction_id($params['id'], $actionId);
                $itemPlayersAction = new stdClass();
                $itemPlayersAction->name  = $actionNameList[$i]['name'];
                $itemPlayersAction->items = $actionsObtained;
                $i++;
                array_push($actions, $itemPlayersAction);
            }

            $playersResult = new stdClass();
            $playersResult->actions = $actions;
            
            $responseHttp = $this->respuestas->standarResponse('ok', $playersResult);
        }

        return $responseHttp;
    }


    public function getTeamSeasonPlayersSearch($json)
    {

        $responseHttp = $this->respuestas->error200(ResponseHttp::DATAINCORRECTORINCOMPLETE);
       
        $params = json_decode($json, true);

        $keys = array('club_id', 'team_id', 'season_id');            
           
        if (Utils::checkParamsIssetAndNumeric($params, $keys)) {

            $countryCode   = (isset($params['country_code'])) ? $params['country_code'] : null;

            $categories = array();
                    
            $categoriesList = $this->player->getCategoriesByLanguage($countryCode);

            $find = (!isset($params['find'])) ? null : $params['find'];
                    
            for ($positionId = 1; $positionId <= 4; $positionId++) {
                $playersList = $this->player->getTeamPlayersInfoAndStaticsByPosition(
                    $params['club_id'],
                    $params['team_id'],
                    $params['season_id'],
                    $countryCode,
                    $positionId,
                    'players.name',
                    $find
                );
                
                $itemPlayersCategory = new stdClass();
                $itemPlayersCategory->name = $categoriesList[$positionId - 1]['name'];
                $itemPlayersCategory->players = $playersList;
                
                array_push($categories, $itemPlayersCategory);
            }

            $playersResult = new stdClass();
            $playersResult->categories = $categories;
            
            $responseHttp = $this->respuestas->standarResponse('ok', $playersResult);
        }

        return $responseHttp;
        
    }


    public function getPerfil($json)
    {

        $responseHttp = $this->respuestas->error200(ResponseHttp::DATAINCORRECTORINCOMPLETE);

        $params = json_decode($json, true);

        $keys = array('id');            
           
        if (Utils::checkParamsIssetAndNumeric($params, $keys)) {
       
            $countryCode   = (isset($params['country_code'])) ? $params['country_code'] : null;
            
            $playerPerfil = $this->player->getPlayerPerfil($params['id'], $countryCode);
            $playerSecondaryPositions = $this->player->getSecondaryPositions($params['id'], $countryCode);
            $playerHistoryInjuries = $this->player->getInjuriesHistory($params['id'], $countryCode);

            $playerInfo = new stdClass();
            $playerInfo->perfil = $playerPerfil[0];
            $playerInfo->map_secondary_position = $playerSecondaryPositions;
            $playerInfo->history_injuries = $playerHistoryInjuries;
            
            $responseHttp = $this->respuestas->standarResponse('ok', $playerInfo);

        }

        return $responseHttp;

    }
    

    private function checkTarget($target)
    {
        $filters = array('continents', 'countries', 'categories', 'divisions', 'all');

        return in_array(strtolower($target), $filters);
    }
    
    public function getAvailableFilters($json)
    {
        $datos = json_decode($json, true);
        
        if (!isset($datos['token'])) {
            return $this->respuestas->error401();
        } else {
            $testToken = $this->token->checkToken($datos['token']);
            
            if ($testToken) {
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
                    
                    return $resultado;
                } else {
                    return $this->respuestas->error200(ResponseHttp::DATAINCORRECTORINCOMPLETE);
                }
            } else {
                return $this->respuestas->error401(ResponseHttp::TOKENINVALIDOREXPIRED);
            }
        }
    }
}

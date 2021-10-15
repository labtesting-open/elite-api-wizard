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
        $host = new HostConnection();
        $this->player = new \Elitelib\Player($host->getParams());
        $this->token = new \Elitelib\Token($host->getParams());
        $this->club = new \Elitelib\Club($host->getParams());
        $this->team = new \Elitelib\Team($host->getParams());
        $this->respuestas  = new Respuestas();
    }


    public function getTeamSeasonPlayers($json)
    {

        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);
       
        $params = json_decode($json, true);

        $keys = array('club_id', 'team_id');

        if (Utils::checkParamsIssetAndNumeric($params, $keys)) {
            $countryCode   = (isset($params['country_code'])) ? $params['country_code'] : 'GB';

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
            
            $responseHttp = $this->respuestas->standarSuccess($playersResult);
        }

        return $responseHttp;
    }


    public function getTeamSeasonPlayerStatics($json)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);

        $params = json_decode($json, true);

        $keys = array('id');
           
        if (Utils::checkParamsIssetAndNumeric($params, $keys)) {
            $actions = array();
            $countryCode   = (isset($params['country_code'])) ? $params['country_code'] : 'GB';
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
            
            $responseHttp = $this->respuestas->standarSuccess($playersResult);
        }

        return $responseHttp;
    }


    public function getTeamSeasonPlayersSearch($json)
    {

        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);
       
        $params = json_decode($json, true);

        $keys = array('club_id', 'team_id', 'season_id');
           
        if (Utils::checkParamsIssetAndNumeric($params, $keys)) {
            $countryCode   = (isset($params['country_code'])) ? $params['country_code'] : 'GB';

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
            
            $responseHttp = $this->respuestas->standarSuccess($playersResult);
        }

        return $responseHttp;
    }


    public function getPerfil($json)
    {

        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);

        $params = json_decode($json, true);

        $keys = array('id');
           
        if (Utils::checkParamsIssetAndNumeric($params, $keys)) {
            $countryCode   = (isset($params['country_code'])) ? $params['country_code'] : 'GB';
            
            $playerPerfil = $this->player->getPlayerPerfil($params['id'], $countryCode);
            $playerSecondaryPositions = $this->player->getSecondaryPositions($params['id'], $countryCode);
            $playerHistoryInjuries = $this->player->getInjuriesHistory($params['id'], $countryCode);

            $playerInfo = new stdClass();
            $playerInfo->perfil = $playerPerfil[0];
            $playerInfo->mapSecondaryPosition = $playerSecondaryPositions;
            $playerInfo->historyInjuries = $playerHistoryInjuries;
            
            $responseHttp = $this->respuestas->standarSuccess($playerInfo);
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
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);

        $params = json_decode($json, true);
            
        if (isset($params['target']) && $this->checkTarget($params['target'])) {
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

            $clubId = null;
            if (isset($params['club_id']) &&  !empty($params['club_id'])) {
                $clubId = $params['club_id'];
            }

            $nationalityCode = null;
            if (isset($params['nationality_code']) &&  !empty($params['nationality_code'])) {
                $nationalityCode = $params['nationality_code'];
            }
            
            $result = new stdClass();
            
            if ($params['target'] == 'continents') {
                $result = $this->club->getAvailableContinents(
                    $continentCode,
                    $countryCode,
                    $categoryId,
                    $divisionId
                );
            }

            if ($params['target'] == 'countries') {
                $result = $this->club->getAvailableCountries(
                    $continentCode,
                    $countryCode,
                    $categoryId,
                    $divisionId
                );
            }
            
            if ($params['target'] == 'categories') {
                $result = $this->team->getAvailableCategories(
                    $continentCode,
                    $countryCode,
                    $categoryId,
                    $divisionId
                );
            }

            if ($params['target'] == 'divisions') {
                $result = $this->club->getAvailableDivisions(
                    $continentCode,
                    $countryCode,
                    $categoryId,
                    $divisionId
                );
            }
            
            if ($params['target'] == 'all') {
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

                $result->clubs  = $this->club->getAvailableClubs(
                    $continentCode,
                    $countryCode,
                    $categoryId,
                    $divisionId,
                    $clubId,
                    $nationalityCode
                );

                $result->nationalities  = $this->player->getAvailableNationalities(
                    $continentCode,
                    $countryCode,
                    $categoryId,
                    $divisionId,
                    $clubId,
                    $nationalityCode
                );
            }
            
             $responseHttp = $this->respuestas->standarSuccess($result);
        }
        return $responseHttp;
    }
}

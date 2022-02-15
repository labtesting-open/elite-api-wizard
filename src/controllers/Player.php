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
    private $category;
    private $division;
    private $respuestas;

    public function __construct()
    {
        $host = new HostConnection();
        $this->player = new \Elitelib\Player($host->getParams());
        $this->token = new \Elitelib\Token($host->getParams());
        $this->club = new \Elitelib\Club($host->getParams());
        $this->team = new \Elitelib\Team($host->getParams());
        $this->category = new \Elitelib\Category($host->getParams());
        $this->division = new \Elitelib\Division($host->getParams());
        $this->respuestas  = new Respuestas();
    }

    public function getTeamPlayersWithStatics($json)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);
       
        $paramsReceived = json_decode($json, true);

        $keys = array('club_id', 'team_id', 'season_id');

        if (Utils::checkParamsIssetAndNumeric($paramsReceived, $keys) ) {            

            $paramsAcepted = array(
                'club_id' => null,
                'team_id' => null,
                'season_id' => null,
                'position_id' => null,
                'language_code' => 'GB',
                'order' => 'player_name',
                'order_sense' => 'DESC',
                'find' => null
            );

            $paramsNormaliced = Utils::normalizerParams($paramsReceived, $paramsAcepted);

            if( isset($paramsNormaliced['position_id'])){

                $playersList = $this->player->getTeamPlayersInfoAndStaticsByPositionV2(
                    $paramsNormaliced['club_id'],
                    $paramsNormaliced['team_id'],
                    $paramsNormaliced['season_id'],
                    $paramsNormaliced['position_id'],
                    $paramsNormaliced['language_code'],
                    $paramsNormaliced['order'],                
                    $paramsNormaliced['order_sense'],                
                    $paramsNormaliced['find']
                );

                $positions = array();

                $categoriesList = $this->player->getCategoriesByLanguage($paramsNormaliced['language_code']);

                $itemPlayersCategory = new stdClass();
                $itemPlayersCategory->name = $categoriesList[$paramsNormaliced['position_id'] - 1]['name'];
                $itemPlayersCategory->players = $playersList;
                
                array_push($positions, $itemPlayersCategory);
                
                $playersResult = new stdClass();
                $playersResult->positions = $positions;
                
                $responseHttp = $this->respuestas->standarSuccess($playersResult);

            }else{
                
                $positions = array();

                $categoriesList = $this->player->getCategoriesByLanguage($paramsNormaliced['language_code']);

                for ($positionId = 1; $positionId <= 4; $positionId++)
                {
                    $playersList = $this->player->getTeamPlayersInfoAndStaticsByPositionV2(
                        $paramsNormaliced['club_id'],
                        $paramsNormaliced['team_id'],
                        $paramsNormaliced['season_id'],
                        $positionId,
                        $paramsNormaliced['language_code'],
                        $paramsNormaliced['order'],                
                        $paramsNormaliced['order_sense'],                
                        $paramsNormaliced['find']
                    );

                    $itemPlayersCategory = new stdClass();
                    $itemPlayersCategory->name = $categoriesList[$positionId - 1]['name'];
                    $itemPlayersCategory->players = $playersList;
                    
                    array_push($positions, $itemPlayersCategory);
                }

                $playersResult = new stdClass();
                $playersResult->positions = $positions;
                
                $responseHttp = $this->respuestas->standarSuccess($playersResult);

            }

        }
       
        return $responseHttp;
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

            $languageCode = null;
            if (isset($params['language_code']) &&  !empty($params['language_code'])) {
                $languageCode = $params['language_code'];
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
                $result = $this->category->getAvailableCategories(
                    $continentCode,
                    $countryCode,
                    $categoryId,
                    $divisionId
                );
            }

            if ($params['target'] == 'divisions') {
                $result = $this->division->getAvailableDivisions(
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
                
                $result->categories = $this->category->getAvailableCategories(
                    $continentCode,
                    $countryCode,
                    $categoryId,
                    $divisionId
                );

                $result->divisions  = $this->division->getAvailableDivisions(
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

                $result->primaryPositions = $this->player->getAllPrimaryPositions(
                    null,
                    null,
                    $languageCode
                );

                $result->secondaryPositions = $this->player->getAllSecondaryPositions(
                    null,
                    null,
                    $languageCode
                );

                $result->rangeMeasures = $this->player->getPlayersRangesOfMeasures();
            }
            
             $responseHttp = $this->respuestas->standarSuccess($result);
        }
        return $responseHttp;
    }

    public function getPlayersWithFilters($json)
    {
        $paramsReceived = json_decode($json, true);

        $paramsAcepted = array(
            'continent_code' => null,
            'country_code' => null,
            'category_id' => null,
            'division_id' => null,
            'club_id' => null,
            'nationality_code' => null,
            'position_id' => null,
            'second_positions_codes' => null,
            'age_range' => null,
            'height_range' => null,
            'weight_range' => null,
            'foot' => null,
            'order' => 'player_name',
            'order_sense' => 'ASC',
            'page' => 1,
            'limit' => 100,
            'language_code' => 'GB'
        );

        $paramsNormaliced = Utils::normalizerParams($paramsReceived, $paramsAcepted);
        
        $infoTeams = $this->player->getAvailablePlayersWithFilters(
            $paramsNormaliced['continent_code'],
            $paramsNormaliced['country_code'],
            $paramsNormaliced['category_id'],
            $paramsNormaliced['division_id'],
            $paramsNormaliced['club_id'],
            $paramsNormaliced['nationality_code'],
            $paramsNormaliced['position_id'],
            $paramsNormaliced['second_positions_codes'],
            $paramsNormaliced['age_range'],
            $paramsNormaliced['height_range'],
            $paramsNormaliced['weight_range'],
            $paramsNormaliced['foot'],
            $paramsNormaliced['order'],
            $paramsNormaliced['order_sense'],
            $paramsNormaliced['page'],
            $paramsNormaliced['limit'],
            $paramsNormaliced['language_code']
        );

        $totalRows = $this->player->getAvailablePlayersWithFiltersTotalRows(
            $paramsNormaliced['continent_code'],
            $paramsNormaliced['country_code'],
            $paramsNormaliced['category_id'],
            $paramsNormaliced['division_id'],
            $paramsNormaliced['club_id'],
            $paramsNormaliced['nationality_code'],
            $paramsNormaliced['position_id'],
            $paramsNormaliced['second_positions_codes'],
            $paramsNormaliced['age_range'],
            $paramsNormaliced['height_range'],
            $paramsNormaliced['weight_range'],
            $paramsNormaliced['foot'],
            $paramsNormaliced['order'],
            $paramsNormaliced['order_sense'],
            $paramsNormaliced['page'],
            $paramsNormaliced['limit'],
            $paramsNormaliced['language_code']
        );

        $paginate = Utils::getPaginateInfo($totalRows, $paramsNormaliced['limit']);

        return $this->respuestas->standarSuccessPaginate($infoTeams, $paginate);
    }
}

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
      
        $datos = json_decode($json, true);
        $responseHttp = $this->respuestas->error401();

        if (isset($datos['token'])) {
            $testToken = $this->token->checkToken($datos['token']);
            
            if ($testToken) {
                if (Utils::checkIssetEmptyNumeric($datos['club_id'], $datos['team_id'])) {
                    $languageId = (!isset($datos['language_id'])) ? 'GB' : $datos['language_id'];
                    $resultado = new stdClass();
                    $resultado->status = 'ok';
                    $resultado->result = new stdClass();
                    $categories = array();
                    
                    $categoriesList = $this->player->getCategoriesByLanguage($languageId);
                    
                    for ($positionId = 1; $positionId <= 4; $positionId++) {
                        if (isset($datos['season_id']) && $datos['season_id'] != '') {
                                $playersList = $this->player->getTeamPlayersInfoAndStaticsByPosition(
                                    $datos['club_id'],
                                    $datos['team_id'],
                                    $datos['season_id'],
                                    $languageId,
                                    $positionId,
                                    'players.name',
                                    null
                                );
                        } else {
                                $playersList = $this->player->getTeamPlayersInfoByPosition(
                                    $datos['club_id'],
                                    $datos['team_id'],
                                    $languageId,
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

                    $resultado->result->categories = $categories;
                    
                    $responseHttp = $resultado;
                } else {
                    $responseHttp = $this->respuestas->error200(ResponseHttp::DATAINCORRECTORINCOMPLETE);
                }
            } else {
                $responseHttp = $this->respuestas->error401(ResponseHttp::TOKENINVALIDOREXPIRED);
            }
        }
        return $responseHttp;
    }


    public function getTeamSeasonPlayerStatics($json)
    {
        
        $datos = json_decode($json, true);
        $responseHttp = $this->respuestas->error401();

        if (isset($datos['token'])) {
            $testToken = $this->token->checkToken($datos['token']);
            
            if ($testToken) {
                if (Utils::checkIssetEmptyNumeric($datos['id'])) {
                    $languageId = (!isset($datos['language_id'])) ? 'GB' : $datos['language_id'];
                    $resultado = new stdClass();
                    $resultado->status = 'ok';
                    $resultado->result = new stdClass();
                    $actions = array();
                    $positionId = $this->player->getPosition_id($datos['id']);
                    $actionList = $this->player->getActionIdList($positionId);
                    $actionNameList = $this->player->getActionNameList($actionList, $languageId);
                    $i = 0;
                    
                    foreach ($actionList as $actionId) {
                        $actionsObtained = $this->player->getPlayerActionsByAction_id($datos['id'], $actionId);
                        $itemPlayersAction = new stdClass();
                        $itemPlayersAction->name  = $actionNameList[$i]['name'];
                        $itemPlayersAction->items = $actionsObtained;
                        $i++;
                        array_push($actions, $itemPlayersAction);
                    }
                    
                    $resultado->result->actions = $actions;
                    
                    $responseHttp = $resultado;
                } else {
                    $responseHttp = $this->respuestas->error200(ResponseHttp::DATAINCORRECTORINCOMPLETE);
                }
            } else {
                $responseHttp = $this->respuestas->error401(ResponseHttp::TOKENINVALIDOREXPIRED);
            }
        }
        return $responseHttp;
    }


    public function getTeamSeasonPlayersSearch($json)
    {
       
        $datos = json_decode($json, true);
        
        if (!isset($datos['token'])) {
            return $this->respuestas->error401();
        } else {
            $testToken = $this->token->checkToken($datos['token']);
            
            if ($testToken) {
                if (Utils::checkIssetEmptyNumeric($datos['season_id'], $datos['club_id'], $datos['team_id'])) {
                    $languageId = (!isset($datos['language_id'])) ? 'GB' : $datos['language_id'];
                    $resultado = new stdClass();
                    $resultado->status = 'ok';
                    $resultado->result = new stdClass();
                    $categories = array();
                    
                    $categoriesList = $this->player->getCategoriesByLanguage($languageId);
                    $find = (!isset($datos['find'])) ? null : $datos['find'];
                    
                    for ($positionId = 1; $positionId <= 4; $positionId++) {
                        $playersList = $this->player->getTeamPlayersInfoAndStaticsByPosition(
                            $datos['club_id'],
                            $datos['team_id'],
                            $datos['season_id'],
                            $languageId,
                            $positionId,
                            'players.name',
                            $find
                        );
                        
                        $itemPlayersCategory = new stdClass();
                        $itemPlayersCategory->name = $categoriesList[$positionId - 1]['name'];
                        $itemPlayersCategory->players = $playersList;
                        
                        array_push($categories, $itemPlayersCategory);
                    }
                    
                    $resultado->result->categories = $categories;
                    
                    return $resultado;
                } else {
                    return $this->respuestas->error200(ResponseHttp::DATAINCORRECTORINCOMPLETE);
                }
            } else {
                return $this->respuestas->error401(ResponseHttp::TOKENINVALIDOREXPIRED);
            }
        }
    }


    public function getPerfil($json)
    {
        $datos = json_decode($json, true);
        
        if (!isset($datos['token'])) {
            return $this->respuestas->error401();
        } else {
            $testToken = $this->token->checkToken($datos['token']);
            
            if ($testToken) {
                if (Utils::checkIssetEmptyNumeric($datos['id'])) {
                    $languageId = (!isset($datos['language_id'])) ? 'GB' : $datos['language_id'];
                    $resultado = new stdClass();
                    $resultado->status = 'ok';
                    $resultado->result = new stdClass();
                    $resultado->result->perfil = new stdClass();
                    $resultado->result->history_injuries = new stdClass();
                    $playerPerfil = $this->player->getPlayerPerfil($datos['id'], $languageId);
                    $playerSecondaryPositions = $this->player->getSecondaryPositions($datos['id'], $languageId);
                    $playerHistoryInjuries = $this->player->getInjuriesHistory($datos['id'], $languageId);
                    $resultado->result->perfil = $playerPerfil[0];
                    $resultado->result->map_secondary_position = $playerSecondaryPositions;
                    $resultado->result->history_injuries = $playerHistoryInjuries;
                    
                    return $resultado;
                } else {
                    return $this->respuestas->error200(ResponseHttp::DATAINCORRECTORINCOMPLETE);
                }
            } else {
                return $this->respuestas->error401(ResponseHttp::TOKENINVALIDOREXPIRED);
            }
        }
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

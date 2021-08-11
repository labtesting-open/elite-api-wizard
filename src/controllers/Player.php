<?php

namespace Elitesports;


use Elitesports\Respuestas;
use stdClass;
use Elitesports\Utils;


class Player{
    

    private $token;
    private $player;
    private $club;
    private $team;

    public function __construct(){

        $this->player = new \Elitelib\Player();
        $this->token = new \Elitelib\Token();
        $this->club = new \Elitelib\Club();
        $this->team = new \Elitelib\Team();
        $this->respuestas  = new Respuestas();
    }


    public function getTeamSeasonPlayers($json){
      
        $datos = json_decode($json, true);

        if( !isset($datos['token'])){
            return $this->respuestas->error_401();
        }else{
                            
            $testToken = $this->token->checkToken($datos['token']);               

            if($testToken){

                if( Utils::checkIssetEmptyNumeric(                        
                    $datos['club_id'],
                    $datos['team_id']
                    )
                ){

                    $language_id = (!isset($datos['language_id']))?'GB': $datos['language_id'];     
                    
                    $resultado = new stdClass(); 
                    $resultado->status = "ok";                       
                    $resultado->result = new stdClass();
                    $categories = array(); 
                    
                    $categoriesList = $this->player->getCategoriesByLanguage($language_id);                         

                        for ($position_id = 1; $position_id <= 4; $position_id++) {

                            if( isset($datos['season_id']) && $datos['season_id'] != ''){

                                $playersList = $this->player->getTeamPlayersInfoAndStaticsByPosition(
                                    $datos['club_id'],
                                    $datos['team_id'],
                                    $datos['season_id'],
                                    $language_id ,
                                    $position_id,
                                    'players.name',
                                    null                          
                                );

                            }else{

                                $playersList = $this->player->getTeamPlayersInfoByPosition(
                                    $datos['club_id'],
                                    $datos['team_id'],                                        
                                    $language_id ,
                                    $position_id,
                                    'players.name',
                                    null                          
                                );

                            }                               

                            $itemPlayersCategory = new stdClass();                            
                            $itemPlayersCategory->name= $categoriesList[$position_id - 1]['name'];
                            $itemPlayersCategory->players = $playersList;                                 
                             
                            array_push($categories, $itemPlayersCategory);

                        }  
                                       
                     
                    $resultado->result->categories = $categories;
                    
                    return $resultado; 

                }else{
                    return $this->respuestas->error_200("Data incorrect or incomplete");
                }                      
                  
            
            }else{
                return $this->respuestas->error_401("Token invalid or expired");
            }

        }           

    }


    public function getTeamSeasonPlayerStatics($json){
        
        $datos = json_decode($json, true);

        if( !isset($datos['token'])){
            return $this->respuestas->error_401();
        }else{
                            
            $testToken = $this->token->checkToken($datos['token']);               

            if($testToken){

                if( Utils::checkIssetEmptyNumeric($datos['id'])
                ){

                    $language_id = (!isset($datos['language_id']))?'GB': $datos['language_id'];   
                    
                    $resultado = new stdClass(); 
                    $resultado->status = "ok";                       
                    $resultado->result = new stdClass();
                    $actions = array();                        
                    
                    $positionId = $this->player->getPosition_id($datos['id']);
                    
                    $actionList = $this->player->getActionIdList($positionId);
                    
                    $actionNameList = $this->player->getActionNameList($actionList, $language_id );

                    $i=0;
                    foreach($actionList as $actionId){

                        $actionsObtained = $this->player->getPlayerActionsByAction_id($datos['id'], $actionId);
                        
                        $itemPlayersAction = new stdClass();
                        $itemPlayersAction->name  = $actionNameList[$i]['name'];
                        $itemPlayersAction->items = $actionsObtained;
                        $i++;
                        array_push($actions, $itemPlayersAction);

                    }                                                  
                     
                    $resultado->result->actions = $actions;                       
                 

                   return $resultado;

                    

                }else{
                    return $this->respuestas->error_200("Data incorrect or incomplete");
                }                      
                  
            
            }else{
                return $this->respuestas->error_401("Token invalid or expired");
            }

        }           

    }


    public function getTeamSeasonPlayersSearch($json){
       
        $datos = json_decode($json, true);

        if( !isset($datos['token'])){
            return $this->respuestas->error_401();
        }else{
                            
            $testToken = $this->token->checkToken($datos['token']);               

            if($testToken){

                if( Utils::checkIssetEmptyNumeric(
                    $datos['season_id'],
                    $datos['club_id'],
                    $datos['team_id']
                    )
                ){

                    $language_id = (!isset($datos['language_id']))?'GB': $datos['language_id'];     
                    
                    $resultado = new stdClass(); 
                    $resultado->status = "ok";                       
                    $resultado->result = new stdClass();
                    $categories = array(); 
                    
                    $categoriesList = $this->player->getCategoriesByLanguage($language_id); 

                    $find = (!isset($datos['find']))?null: $datos['find'];

                    for ($position_id = 1; $position_id <= 4; $position_id++) {

                        $playersList = $this->player->getTeamPlayersInfoAndStaticsByPosition(
                            $datos['club_id'],
                            $datos['team_id'],
                            $datos['season_id'],
                            $language_id ,
                            $position_id,
                            'players.name',
                            $find                          
                        );

                        $itemPlayersCategory = new stdClass();                            
                        $itemPlayersCategory->name= $categoriesList[$position_id - 1]['name'];
                        $itemPlayersCategory->players = $playersList; 
                        
                         
                        array_push($categories, $itemPlayersCategory);

                    }                         
                     
                    $resultado->result->categories = $categories;
                    
                    return $resultado; 

                }else{
                    return $this->respuestas->error_200("Data incorrect or incomplete");
                }                      
                  
            
            }else{
                return $this->respuestas->error_401("Token invalid or expired");
            }

        }           

    }


    public function getPerfil($json){
        
        $datos = json_decode($json, true);

        if( !isset($datos['token'])){
            return $this->respuestas->error_401();
        }else{
                            
            $testToken = $this->token->checkToken($datos['token']);               

            if($testToken){

                if( Utils::checkIssetEmptyNumeric($datos['id'])
                ){

                    $language_id = (!isset($datos['language_id']))?'GB': $datos['language_id'];   
                    
                    $resultado = new stdClass(); 
                    $resultado->status = "ok";                       
                    $resultado->result = new stdClass();
                    $resultado->result->perfil = new stdClass();                        
                    $resultado->result->history_injuries = new stdClass();
                    
                    $player_perfil = $this->player->getPlayerPerfil($datos['id'], $language_id ); 
                    $player_secondary_positions = $this->player->getSecondaryPositions($datos['id'], $language_id);
                    $player_history_injuries = $this->player->getInjuriesHistory($datos['id'], $language_id);

                    $resultado->result->perfil = $player_perfil[0];
                    $resultado->result->map_secondary_position = $player_secondary_positions;
                    $resultado->result->history_injuries = $player_history_injuries;

                   return $resultado;
                    

                }else{
                    return $this->respuestas->error_200("Data incorrect or incomplete");
                }                      
                  
            
            }else{
                return $this->respuestas->error_401("Token invalid or expired");
            }

        }           

    }


    private function checkTarget($target){
            
        $result = false;

        if($target == 'continents' || $target == 'countries' || $target == 'categories' || $target == 'divisions' || $target == 'all'){
            $result = true;
        }

        return $result;

    }


    public function getAvailableFilters($json){        

        $datos = json_decode($json, true);

        if( !isset($datos['token'])){
            return $this->respuestas->error_401();
        }else{
                            
            $testToken = $this->tokens->checkToken($datos['token']);               

            if($testToken){                    

                if(isset($datos['target']) && $this->checkTarget($datos['target']) ){

                    $resultado = new stdClass(); 
                    $resultado->status = "ok";                       
                    $resultado->result = new stdClass();

                    $continent_code = ( isset($datos['continent_code']) &&  !empty($datos['continent_code']))? $datos['continent_code'] : null;
                    $country_code   = ( isset($datos['country_code']) &&  !empty($datos['country_code']))? $datos['country_code'] : null;
                    $category_id    = ( isset($datos['category_id']) &&  !empty($datos['category_id']))? $datos['category_id'] : null;
                    $division_id    = ( isset($datos['division_id']) &&  !empty($datos['division_id']))? $datos['division_id'] : null;

                    if($datos['target'] == 'continents'){                           

                        $result = $this->club->getAvailableContinents(
                            $continent_code, 
                            $country_code, 
                            $category_id,
                            $division_id
                        );
                    }

                    if($datos['target'] == 'countries'){

                        $result = $this->club->getAvailableCountries(
                            $continent_code, 
                            $country_code, 
                            $category_id, 
                            $division_id
                        );
                    }                        

                    if($datos['target'] == 'categories'){    

                        $result = $this->team->getAvailableCategories(
                            $continent_code, 
                            $country_code, 
                            $category_id, 
                            $division_id
                        );                           

                    }

                    if($datos['target'] == 'divisions'){ 

                        $result = $this->club->getAvailableDivisions(
                            $continent_code, 
                            $country_code, 
                            $category_id, 
                            $division_id
                        );    

                    }    
                    
                    if($datos['target'] == 'all'){                             
                                      
                        $result = new stdClass();
                   
                        $result->continents = $this->club->getAvailableContinents(
                            $continent_code, 
                            $country_code, 
                            $category_id,
                            $division_id
                        );
                        
                        $result->countries  = $this->club->getAvailableCountries(
                            $continent_code, 
                            $country_code, 
                            $category_id,
                            $division_id
                        );                           
                        
                        $result->categories = $this->team->getAvailableCategories(
                            $continent_code, 
                            $country_code, 
                            $category_id, 
                            $division_id
                        );

                        $result->divisions  = $this->club->getAvailableDivisions(
                            $continent_code, 
                            $country_code, 
                            $category_id, 
                            $division_id
                        );
                       
                    } 
                    
                    $resultado->result = $result;
                    
                    return $resultado; 

                }else{
                    return $this->respuestas->error_200("Data incorrect or incomplete");
                }                      
                  
            
            }else{
                return $this->respuestas->error_401("Token invalid or expired");
            }

        }           

    }



}

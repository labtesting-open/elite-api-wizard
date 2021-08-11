<?php

namespace Elitesports;

use Elitesports\Respuestas;
use stdClass;


    class Search
    {        
        private $token;
        private $respuestas;
        private $player;
        private $club;        


        public function __construct()
        {
            $this->player = new \Elitelib\Player();
            $this->club = new \Elitelib\Club();
            $this->token = new \Elitelib\Token();
            $this->respuestas = new Respuestas();
        }


        public function find($json){
          
            $datos = json_decode($json, true);

            if( !isset($datos['token'])){
                return $this->respuestas->error_401();
            }else{
                                
                $arrayToken = $this->token->checkToken($datos['token']);               

                if($arrayToken){

                    if( isset($datos['find'])){   
                        
                        $find = $datos['find'];

                        $language_id = (!isset($datos['language_id']))?'GB': $datos['language_id'];                        

                        $page = (isset($datos["page"]))? $datos["page"] : 1;                       

                        $modeFast = (isset($datos['fast']))? $datos['fast']: 0;

                        $limit = (isset($datos["limit"]))? $datos["limit"] : 10;                      

                        $resultPlayers = array();
                        $resultClubs   = array();

                        if(!$modeFast){
                            $resultPlayers = $this->player->findPlayers($find, $language_id, $page);
                            $resultClubs   = $this->club->findClubs($find, $language_id, $page);
                        }else if( isset($find) && !empty($find)){                            
                            $resultPlayers = $this->player->findPlayersFast($find, $language_id, $limit);
                            $resultClubs   = $this->club->findClubsFast($find, $language_id, $page);
                        }    
                       
                        $resultado = new stdClass(); 
                        $resultado->status = "ok";                       
                        $resultado->result = new stdClass();
                        $resultado->result->players = $resultPlayers;
                        $resultado->result->clubs = $resultClubs;
                        
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
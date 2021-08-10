<?php

namespace Elitesports;

use Elitelib\Connect;
use Elitesports\Respuestas;
use stdClass;
use Elitesports\Utils;



    class Season{  
        
        private $Season;
        private $token;
        private $respuestas;


        public function __construct()
        {
            $this->Season = new \Elitelib\Season();
            $this->token = new \Elitelib\Token();
            $this->respuestas = new Respuestas(); 
        }


        public function getAvailableSeasons($json){            

           
            $datos = json_decode($json, true);

            if( !isset($datos['token'])){
                return $this->respuestas->error_401();
            }else{
                                
                $arrayToken = $this->token->checkToken($datos['token']);               

                if($arrayToken){

                    if( Utils::checkIssetEmptyNumeric(                        
                        $datos['club_id'],
                        $datos['team_id']
                        )
                    ){

                        $seasons = $this->Season->getSeasonsByClubTeam($datos['club_id'], $datos['team_id']); 
                       
                        $resultado = new stdClass(); 
                        $resultado->status = "ok";                       
                        $resultado->result = new stdClass();
                        $resultado->result = $seasons;
                        
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
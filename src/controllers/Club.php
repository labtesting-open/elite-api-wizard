<?php

namespace Elitesports;


use Elitesports\Respuestas;
use stdClass;


    class Club
    {
        private $club;
        private $token;
        private $respuestas;
        private $path_flag;
        private $folder_club;  

        public function __construct()
        {
            $this->club = new \Elitelib\Club();
            $this->token = new \Elitelib\Token();
            $this->respuestas  = new Respuestas();
            $this->path_flag   = "imgs/svg/";
            $this->folder_club ="imgs/clubs_logo/";  

        }

        public function getInfo($json){           
           
            $datos = json_decode($json, true);

            if( !isset($datos['token'])){
                return $this->respuestas->error_401();
            }else{
                                
                $testToken = $this->token->checkToken($datos['token']);               

                if($testToken){

                    if(isset($datos['club_id']) && is_numeric($datos['club_id'])){
                        
                        $info = $this->club->getBasicInfo($datos['club_id']);

                        $resultado = new stdClass(); 
                        $resultado->status = "ok";                       
                        $resultado->result = new stdClass();
                        $resultado->result = $info;
                        
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

            if($target == 'continents' || $target == 'countries' || $target == 'divisions'){
                $result = true;
            }

            return $result;

        }


        public function getInfoWithFilters($json){
           
            $datos = json_decode($json, true);

            if( !isset($datos['token'])){
                return $this->respuestas->error_401();
            }else{
                                
                $testToken = $this->token->checkToken($datos['token']);               

                if($testToken){

                        $continent_code = ( isset($datos['continent_code']) && !empty($datos['continent_code']) )? $datos['continent_code']:null;
                        $country_code   = ( isset($datos['country_code']) && !empty($datos['country_code']) )? $datos['country_code']:null;
                        $division_id    = ( isset($datos['division_id']) && !empty($datos['division_id']) )? $datos['division_id']:null;
                        $category_id    = ( isset($datos['category_id']) && !empty($datos['category_id']) )? $datos['category_id']:null;
                        $page           = ( isset($datos['page']) && is_numeric($datos['page']) )? $datos['page']:1;
                        $cant           = ( isset($datos['cant']) && is_numeric($datos['cant']) )? $datos['cant']:100;

                        $info = $this->club->getClubsByFilters(
                            $continent_code, 
                            $country_code, 
                            $category_id,
                            $division_id, 
                            $page,
                            $cant
                        );

                        $resultado = new stdClass(); 
                        $resultado->status = "ok";                       
                        $resultado->result = new stdClass();
                        $resultado->result = $info;
                        
                        return $resultado; 

                                     
                      
                
                }else{
                    return $this->respuestas->error_401("Token invalid or expired");
                }

            }           

        }


    }
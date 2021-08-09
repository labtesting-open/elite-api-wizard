<?php

    namespace Elitesports;

    use Elitelib\Connect;
    use Elitesports\Respuestas;
    use stdClass;
    use Elitesports\Utils;


    class Team extends Connect{

        private $table = "teams";  
        private $path ="imgs/teams/"; 
        private $team;
        private $club;
        private $token;
        private $respuestas;
        private $path_flag;
        private $folder_club;  
        private $folder_team;

        public function __construct()
        {
            $this->team = new \Elitelib\Team();
            $this->token = new \Elitelib\Token();
            $this->respuestas  = new Respuestas();
            $this->club = new \Elitelib\Club();
            $this->path_flag   = "imgs/svg/";
            $this->folder_club = "imgs/clubs_logo/";  
            $this->folder_team ="imgs/teams_profile/";

        }



        public function getClubTeams($json){          

            
            $datos = json_decode($json, true);

            if( !isset($datos['token'])){
                return $this->respuestas->error_401();
            }else{
                                
                $testToken = $this->token->checkToken($datos['token']);               

                if($testToken){

                    if(isset($datos['club_id']) && is_numeric($datos['club_id'])){

                        $country_code   = ( isset($datos['country_code']) && !empty($datos['country_code']) )? $datos['country_code']:null;

                        $info = $this->team->getTeams($datos['club_id'], $country_code);

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


        

        


        public function getInfoWithFilters($json){
            
            $datos = json_decode($json, true);

            if( !isset($datos['token'])){
                return $this->respuestas->error_401();
            }else{
                                
                $testToken = $this->token->checkToken($datos['token']);               

                if($testToken){

                        $continent_code = ( isset($datos['continent_code']) && !empty($datos['continent_code']) )? $datos['continent_code']:null;
                        $country_code   = ( isset($datos['country_code']) && !empty($datos['country_code']) )? $datos['country_code']:null;
                        $category_id    = ( isset($datos['category_id']) && !empty($datos['category_id']) )? $datos['category_id']:null;
                        $division_id    = ( isset($datos['division_id']) && !empty($datos['division_id']) )? $datos['division_id']:null;
                        $page           = ( isset($datos['page']) && is_numeric($datos['page']) )? $datos['page']:1;
                        $cant           = ( isset($datos['cant']) && is_numeric($datos['cant']) )? $datos['cant']:100;
                        $order          = ( isset($datos['order']) && !empty($datos['order']) )? $datos['order']:null; 
                        $order_sense     = ( isset($datos['order_sense']) && !empty($datos['order_sense']) )? strtoupper($datos['order_sense']):null;
                        $translate_code   = ( isset($datos['language_id']) && !empty($datos['language_id']) )? $datos['language_id']:'GB';

                        $info = $this->team->getTeamsByFilters(
                            $continent_code, 
                            $country_code,
                            $category_id, 
                            $division_id, 
                            $page,
                            $cant,
                            $order,
                            $order_sense,
                            $translate_code
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



        public function getAvailableFilters($json){          
            

            $datos = json_decode($json, true);

            if( !isset($datos['token'])){
                return $this->respuestas->error_401();
            }else{
                                
                $testToken = $this->token->checkToken($datos['token']);               

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


        private function checkTarget($target){
            
            $result = false;

            if($target == 'continents' || $target == 'countries' || $target == 'categories' || $target == 'divisions' || $target == 'all'){
                $result = true;
            }

            return $result;

        }



    }
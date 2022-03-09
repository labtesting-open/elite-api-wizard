<?php

namespace Elitesports;

use stdClass;

class FavouritePlayer
{
    private $favouritePlayer;    
    private $respuestas;
    private $token;

    public function __construct()
    {
        $host = new HostConnection();       
        $this->favouritePlayer = new \Elitelib\FavouritePlayer($host->getParams());
        $this->respuestas  = new Respuestas();
        $this->token = new \Elitelib\Token($host->getParams());      
        
    }

    public function getUserId($token)
    {
        $user_id = null;

        if(isset($token)){
            $arrayToken = $this->token->checkToken($token);            
    
            if ($arrayToken)
            {
                $user_id = $arrayToken[0]['user_id'];
            }
        }        

        return $user_id;
    }



    public function getPlayers($json, $token)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);
       
        //$params = json_decode($json, true);

        $user_id = $this->getUserId($token);

        if (!is_null($user_id))
        {

            $players = $this->favouritePlayer->getFavouritePlayersByUser($user_id);

            $responseHttp = $this->respuestas->standarSuccess($players);
        }
        
        return $responseHttp;
    }
   

    public function addPlayer($params, $token)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);

        $user_id = $this->getUserId($token);

        if (!is_null($user_id))
        {
            $keys = array('player_id');

            if (Utils::checkParamsIssetAndNumeric($params, $keys) )
            {           
                $affected = 0;
               
                $affected = $this->favouritePlayer->add(
                    $user_id,
                    $params['player_id']
                );
    
                if ($affected) {                
                    $responseHttp = $this->respuestas->customResult('ok', $affected);
                } else {
                    $responseHttp = $this->respuestas->error409();
                }
            }
        }

        return $responseHttp;
    }
    


    public function deletePlayer($json, $token)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);

        $user_id = $this->getUserId($token);

        if (!is_null($user_id)) 
        {
            $params = json_decode($json, true);

            $keys = array('player_id');
    
            if (Utils::checkParamsIssetAndNumeric($params, $keys)) {                         
                    
                $affected = $this->favouritePlayer->delete($user_id, $params['player_id']);               
    
                if ($affected) {                
                    $responseHttp = $this->respuestas->customResult('ok', $affected);
                } else {
                    $responseHttp = $this->respuestas->error410();
                }                
            }
        }       

        return $responseHttp;
    }


    public function updateFavouriteList($list, $token)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);

        $user_id = $this->getUserId($token);

        if (!is_null($user_id))
        {             
            $affected = 0;          

            $arrayTempIN = Utils::getValueItemsFromArray($list, true);
            $arrayTempOut = Utils::getValueItemsFromArray($list, false);       
           


            if ($affected) {                
                $responseHttp = $this->respuestas->customResult('ok', $affected, $arrayTempIN);
            } else {
                $responseHttp = $this->respuestas->error409();
            }
           
        }

        return $responseHttp;
    }


   

}

<?php

namespace Elitesports;

use stdClass;

class FavouriteAction
{
    private $favouriteAction;    
    private $respuestas;
    private $token;

    public function __construct()
    {
        $host = new HostConnection();       
        $this->favouriteAction = new \Elitelib\FavouriteAction($host->getParams());
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



    public function getActions($json, $token)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);
       
        //$params = json_decode($json, true);

        $user_id = $this->getUserId($token);

        if (!is_null($user_id))
        {

            $actions = $this->favouriteAction->getActionsByUser($user_id);

            $responseHttp = $this->respuestas->standarSuccess($actions);
        }
        
        return $responseHttp;
    }
   

    public function addFavotite($params, $token)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);

        $user_id = $this->getUserId($token);

        if (!is_null($user_id))
        {
            $keys = array('match_action_id');

            if (Utils::checkParamsIssetAndNumeric($params, $keys) )
            {           
                $affected = 0;
               
                $affected = $this->favouriteAction->add(
                    $user_id,
                    $params['match_action_id']
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
    


    public function deleteFavourite($json, $token)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);

        $user_id = $this->getUserId($token);

        if (!is_null($user_id)) 
        {
            $params = json_decode($json, true);

            $keys = array('match_action_id');
    
            if (Utils::checkParamsIssetAndNumeric($params, $keys)) {                         
                    
                $affected = $this->favouriteAction->delete($user_id, $params['match_action_id']);               
    
                if ($affected) {                
                    $responseHttp = $this->respuestas->customResult('ok', $affected);
                } else {
                    $responseHttp = $this->respuestas->error410();
                }                
            }
        }       

        return $responseHttp;
    }  


   

}

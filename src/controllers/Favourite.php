<?php

namespace Elitesports;

use stdClass;

class Favourite
{
    private $favourite;    
    private $respuestas;    

    public function __construct()
    {
        $host = new HostConnection();       
        $this->favourite = new \Elitelib\Favourite($host->getParams());
        $this->respuestas  = new Respuestas();       
        
    }



    public function getActions($json)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);
       
        $params = json_decode($json, true);

        if (isset($params['user_id']) && is_numeric($params['user_id'])) {

            $actions = $this->favourite->getActionsByUser($params['user_id']);

            $responseHttp = $this->respuestas->standarSuccess($actions);
        }
        
        return $responseHttp;
    }
   

    public function addFavotite($params)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);

        $keys = array('user_id', 'match_action_id');

        if (Utils::checkParamsIssetAndNumeric($params, $keys) )
        {           
            $affected = 0;
           
            $affected = $this->favourite->add(
                $params['user_id'],
                $params['match_action_id']
            );

            if ($affected) {                
                $responseHttp = $this->respuestas->customResult('ok', $affected);
            } else {
                $responseHttp = $this->respuestas->error500('error on save');
            }
        }

        return $responseHttp;
    }
    


    public function deleteFavourite($json)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);

        $params = json_decode($json, true);

        $keys = array('user_id', 'match_action_id');

        if (Utils::checkParamsIssetAndNumeric($params, $keys)) {                         
                
            $affected = $this->favourite->delete($params['user_id'], $params['match_action_id']);               

            if ($affected) {                
                $responseHttp = $this->respuestas->customResult('ok', $affected);
            } else {
                $responseHttp = $this->respuestas->error500('error on save');
            }
            
        }

        return $responseHttp;
    }  


   

}

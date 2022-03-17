<?php

namespace Elitesports;

use Elitesports\Respuestas;
use Elitesports\User;
use Elitesports\Utils;
use Elitesports\TargetSearch;

class SavedSearch
{
        private $savedSearch;        
        private $user;
        private $respuestas;


    public function __construct()
    {
        $host = new HostConnection();
        $this->user = new User();
        $this->savedSearch = new \Elitelib\SavedSearch($host->getParams());
        $this->token = new \Elitelib\Token($host->getParams());
        $this->respuestas = new Respuestas();
        
    }
    
    public function validTarget($target)
    {
        $valid = false;       

        if(!empty($target) && ( 
        $target == TargetSearch::PLAYER || 
        $target == TargetSearch::ACTION || 
        $target == TargetSearch::TEAM   ||
        $target == TargetSearch::CLUB )
        )
        {
            $valid = true;
        }

        return $valid;
    }
    

    public function get($json, $token)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);
        
        $paramsReceived = json_decode($json, true);
        
        $userId = $this->user->getUserId($token);

        $target = ( isset($paramsReceived['target']) && $this->validTarget($paramsReceived['target']))? $paramsReceived['target']: null;      

        $saved_search_id = !empty($paramsReceived['saved_search_id'])? $paramsReceived['saved_search_id']: null;

        if(!empty($userId))
        {
            $data = $this->savedSearch->get($userId, $target, $saved_search_id);
            
            $paginate = Utils::getPaginateInfo(count($data), 100);

            return $this->respuestas->standarSuccessPaginate($data, $paginate);
        }
        
        return $responseHttp;
    }

    public function save($json, $token)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);

        $paramsReceived = json_decode($json, true);       

        $userId = $this->user->getUserId($token);

        $target = !empty($paramsReceived['target'])? $paramsReceived['target']: null;

        $searchResult = !empty($paramsReceived['result'])? $paramsReceived['result'] : 0;

        $searchName = !empty($paramsReceived['search_name'])? $paramsReceived['search_name'] : null;

        if(!empty($userId) && $this->validTarget($target))
        {
            $responseHttp = $this->savedSearch->add($userId, $target, $json, $searchName, $searchResult);            
        }

        return $responseHttp;
    }

    public function delete($json, $token)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);
        
        $paramsReceived = json_decode($json, true);
        
        $userId = $this->user->getUserId($token);             

        $saved_search_id = !empty($paramsReceived['saved_search_id'])? $paramsReceived['saved_search_id']: null;

        if(!empty($userId) && !empty($saved_search_id))
        {
            $responseHttp = $this->savedSearch->delete($saved_search_id, $userId, null);            
        }
        
        return $responseHttp;
    }

    public function update($json, $token)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);

        $paramsReceived = json_decode($json, true);       

        $userId = $this->user->getUserId($token); 
        
        $saved_search_id = !empty($paramsReceived['saved_search_id'])? $paramsReceived['saved_search_id']: null;

        $searchResult = !empty($paramsReceived['result'])? $paramsReceived['result'] : null;

        $searchName = !empty($paramsReceived['search_name'])? $paramsReceived['search_name'] : null;

        if(!empty($userId) && !empty($saved_search_id))
        {
            $responseHttp = $this->savedSearch->update(
                $saved_search_id, 
                $json,
                $searchResult,
                $searchName
            );            
        }

        return $responseHttp;
    }

}
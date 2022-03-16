<?php

namespace Elitesports;

use stdClass;

class NewsFavouritePlayer
{
    private $NewsFavouritePlayer;    
    private $respuestas;
    private $token;

    public function __construct()
    {
        $host = new HostConnection();       
        $this->NewsFavouritePlayer = new \Elitelib\FavouritePlayer($host->getParams());
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

    public function getNewsList($json, $token)
    {
        $paramsReceived = json_decode($json, true);

        $paramsAcepted = array(
            'user_id' => null,
            'player_id' => null,           
            'order' => 'player_name',
            'order_sense' => 'ASC',
            'page' => 1,
            'limit' => 100,
            'language_code' => 'GB'
        );

        $paramsNormaliced = Utils::normalizerParams($paramsReceived, $paramsAcepted);

        $arrayToken = $this->token->checkToken($token);

        $user_id = null;

        if ($arrayToken)
        {
            $user_id = $arrayToken[0]['user_id'];
        }

        $news = $this->NewsFavouritePlayer->getPlayerNews(
            $user_id,            
            $paramsNormaliced['language_code']
        );

        $newsCount = $this->NewsFavouritePlayer->getTotalNewActions($user_id);

        $dataRows = new stdClass();
        $dataRows->data = $news;
        $dataRows->totalActions = $newsCount;

        // $totalRows = $this->favouritePlayer->getFavouritePlayersTotalRows(
        //     $user_id,
        //     $paramsNormaliced['player_id'],
        //     $paramsNormaliced['order'],
        //     $paramsNormaliced['order_sense'],
        //     $paramsNormaliced['page'],
        //     $paramsNormaliced['limit'],
        //     $paramsNormaliced['language_code']
        // );


        $paginate = Utils::getPaginateInfo(count($news), $paramsNormaliced['limit']);

        return $this->respuestas->standarSuccessPaginate($dataRows, $paginate);

    }
    
   

    public function setViewed($params, $token)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);

        $user_id = $this->getUserId($token);

        if (!is_null($user_id))
        {
            $keys = array('match_action_id');

            if (Utils::checkParamsIssetAndNumeric($params, $keys) )
            {           
                $affected = 0;
               
                $affected = $this->NewsFavouritePlayer->setActionAsViewed(
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

    
    public function setListViewed($list, $token)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);

        $user_id = $this->getUserId($token);

        $matchActionIdListNormaliced = null;

        if (!empty($list['match_action_id_list']))
        {
            $matchActionIdListNormaliced = Utils::normalizerStringList($list['match_action_id_list'], OutputsTypes::NUMBER);
        }

        if (!is_null($user_id) && !empty($matchActionIdListNormaliced))
        {

            $matchActionIdListNormalicedArr = explode(',',$matchActionIdListNormaliced);

            $affected = 0;                              
           
            $affected = $this->NewsFavouritePlayer->setActionListAsViewed($user_id, $matchActionIdListNormalicedArr);

            if ($affected) {                
                $responseHttp = $this->respuestas->customResult('ok', $affected, null);
            } else {
                $responseHttp = $this->respuestas->error409();
            }
           
        }

        return $responseHttp;
    }


    public function updateDataCheckNews($params, $token)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);

        $user_id = $this->getUserId($token);

        if (!is_null($user_id)) 
        {            
    
            $paramsAcepted = array(                
                'player_id' => null 
            );
    
            $paramsNormaliced = Utils::normalizerParams($params, $paramsAcepted);
                
            $dateChecked = null;

            if(!empty($params['date_checked']) && Utils::validateDate($params['date_checked'])){
                $dateChecked = $params['date_checked'];
            }
                
            $affected = $this->NewsFavouritePlayer->updateDateChecked($user_id, $paramsNormaliced['player_id'], $dateChecked);               

            if ($affected) {                
                $responseHttp = $this->respuestas->customResult('ok', $affected);
            } else {
                $responseHttp = $this->respuestas->error410();
            }                
            
        }       

        return $responseHttp;
    }


    


   

}

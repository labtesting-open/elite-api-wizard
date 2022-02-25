<?php

namespace Elitesports;

use stdClass;

class MatchActions
{
    private $matchActions;    
    private $respuestas;
    
   

    public function __construct()
    {
        $host = new HostConnection();
        $this->matchActions = new \Elitelib\MatchActions($host->getParams());      
        $this->respuestas  = new Respuestas();       
    }    


    public function getAvailableFilters($json)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);
        
        $paramsReceived = json_decode($json, true);

        $keys = array('player_id');
        
        if (Utils::checkParamsIssetAndNumeric($paramsReceived, $keys)) {
        
            $paramsAcepted = array(
                'season_id' => null,
                'match_id' => null,
                'match_id_list' => null,
                'action_id_list' => null,
                'order' => null,
                'order_sense' => null
            );

            $paramsNormaliced = Utils::normalizerParams($paramsReceived, $paramsAcepted);

            $result = new stdClass();

            $result->seasons = $this->matchActions->getSeasons(
                $paramsReceived['player_id'],
                null,
                $paramsNormaliced['season_id'],
                null,
                null,
                null
            );

            $result->matches = $this->matchActions->getMatches(
                $paramsReceived['player_id'],
                $paramsNormaliced['season_id'],
                null,
                $paramsNormaliced['match_id_list'],
                'match_date',
                'DESC'
            );

            $result->actions = $this->matchActions->getActions(
                $paramsReceived['player_id'],
                $paramsNormaliced['season_id'],
                $paramsNormaliced['match_id_list'],
                $paramsNormaliced['action_id_list'],
                $paramsNormaliced['order'],
                $paramsNormaliced['order_sense']
            );

            $responseHttp = $this->respuestas->standarSuccess($result);

        }       

        return $responseHttp;
    }   

    
}

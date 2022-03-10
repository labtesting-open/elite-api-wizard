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
        $host = new HostConnection();
        $this->player = new \Elitelib\Player($host->getParams());
        $this->club = new \Elitelib\Club($host->getParams());
        $this->token = new \Elitelib\Token($host->getParams());
        $this->respuestas = new Respuestas();
    }   


    public function findV2($json, $token= null)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);
       
        $paramsReceived = json_decode($json, true);
        
        $paramsAcepted = array(
            'find' => null,
            'limit' => 10,               
            'language_code' => 'GB',
            'order' => 'name',
            'order_sense' => 'DESC'               
        );

        $arrayToken = $this->token->checkToken($token);

        $user_id = null;

        if ($arrayToken)
        {
            $user_id = $arrayToken[0]['user_id'];
        }

        $paramsNormaliced = Utils::normalizerParams($paramsReceived, $paramsAcepted);

        $resultPlayers = array();
        $resultClubs   = array();

        $resultPlayers = $this->player->searchQuick(
            $paramsNormaliced['find'], 
            $paramsNormaliced['limit'],
            $paramsNormaliced['language_code'],
            $paramsNormaliced['order'],
            $paramsNormaliced['order_sense'],
            $user_id
        );

        $resultClubs = $this->club->searchQuick(
            $paramsNormaliced['find'], 
            $paramsNormaliced['limit'],
            $paramsNormaliced['language_code'],
            $paramsNormaliced['order'],
            $paramsNormaliced['order_sense']
        );           

        $searchResult = new stdClass();
        $searchResult->players = $resultPlayers;
        $searchResult->clubs = $resultClubs;
        
        $responseHttp = $this->respuestas->standarSuccess($searchResult);

        return $responseHttp;
       
    }


}

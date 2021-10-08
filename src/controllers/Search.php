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
        $this->player = new \Elitelib\Player();
        $this->club = new \Elitelib\Club();
        $this->token = new \Elitelib\Token();
        $this->respuestas = new Respuestas();
    }


    public function find($json)
    {
          
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);
       
        $params = json_decode($json, true);

        if (isset($params['find'])) {

            $find = $params['find'];            
           
            $modeFast = (isset($params['fast'])) ? $params['fast'] : 0;
            $page = (isset($params['page'])) ? $params['page'] : 1;
            $limit = (isset($params['limit'])) ? $params['limit'] : 10;
            $countryCode   = (isset($params['country_code'])) ? $params['country_code'] : 'GB';

            $resultPlayers = array();
            $resultClubs   = array();

            if (!$modeFast) {
                $resultPlayers = $this->player->findPlayers($find, $countryCode, $page);
                $resultClubs   = $this->club->findClubs($find, $countryCode, $page);
            } elseif (isset($find) && !empty($find)) {
                $resultPlayers = $this->player->findPlayersFast($find, $countryCode, $limit);
                $resultClubs   = $this->club->findClubsFast($find, $countryCode, $limit);
            }

            $searchResult = new stdClass();
            $searchResult->players = $resultPlayers;
            $searchResult->clubs = $resultClubs;
            
            $responseHttp = $this->respuestas->standarSuccess($searchResult);
        }

        return $responseHttp;
    }
}

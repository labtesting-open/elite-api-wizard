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
          
        $responseHttp = $this->respuestas->error200(ResponseHttp::DATAINCORRECTORINCOMPLETE);
       
        $params = json_decode($json, true);

        if ( isset($params['find'])) {

            $find = $params['find'];
            $countryCode   = (isset($params['country_code'])) ? $params['country_code'] : null;
            $page = (isset($datos['page'])) ? $datos['page'] : 1;
            $modeFast = (isset($datos['fast'])) ? $datos['fast'] : 0;
            $limit = (isset($datos['limit'])) ? $datos['limit'] : 10;

            $resultPlayers = array();
            $resultClubs   = array();

            if (!$modeFast) {
                $resultPlayers = $this->player->findPlayers($find, $countryCode, $page);
                $resultClubs   = $this->club->findClubs($find, $countryCode, $page);
            } elseif (isset($find) && !empty($find)) {
                $resultPlayers = $this->player->findPlayersFast($find, $countryCode, $limit);
                $resultClubs   = $this->club->findClubsFast($find, $countryCode, $page);
            }

            $searchResult = new stdClass();
            $searchResult->players = $resultPlayers;
            $searchResult->clubs = $resultClubs;
            
            $responseHttp = $this->respuestas->standarResponse('ok', $searchResult);
        }

        return $responseHttp;
        
    }
}

<?php

namespace Elitesports;

use Elitesports\Respuestas;
use stdClass;
use Elitesports\Utils;

class Season
{

  
        
        private $season;
        private $token;
        private $respuestas;


    public function __construct()
    {
        $this->season = new \Elitelib\Season();
        $this->token = new \Elitelib\Token();
        $this->respuestas = new Respuestas();
    }


    public function getAvailableSeasons($json)
    {
        $responseHttp = $this->respuestas->error200(ResponseHttp::DATAINCORRECTORINCOMPLETE);
       
        $params = json_decode($json, true);

        $keys = array('club_id', 'team_id');

        if (Utils::checkParamsIssetAndNumeric($params, $keys)) {
           
            $seasons = $this->season->getSeasonsByClubTeam($params['club_id'], $params['team_id']);

            $infoSeasons = new stdClass();
            $infoSeasons = $seasons;
            $responseHttp = $this->respuestas->standarResponse('ok', $infoSeasons);
        }
        
        return $responseHttp;
       
    }
}

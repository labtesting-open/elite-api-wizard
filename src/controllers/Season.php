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
        $host = new HostConnection();
        $this->season = new \Elitelib\Season($host->getParams());
        $this->token = new \Elitelib\Token($host->getParams());
        $this->respuestas = new Respuestas();
    }


    public function getAvailableSeasons($json)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);

        $params = json_decode($json, true);

        $keys = array('club_id', 'team_id');

        $onlyWithMatches = ( isset($params['with_matches']))? $params['with_matches'] : 0;

        if (Utils::checkParamsIssetAndNumeric($params, $keys)) {

            $seasons = $this->season->getSeasonsWithMatchesByClubTeam(
                $params['club_id'], 
                $params['team_id'], 
                $onlyWithMatches
            );

            $responseHttp = $this->respuestas->standarSuccess($seasons);
        }

        return $responseHttp;
    }

    public function getAllSeasons()
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);
       
        $seasons = $this->season->getAllSeasons();

        $responseHttp = $this->respuestas->standarSuccess($seasons);
        
        return $responseHttp;
    }
}

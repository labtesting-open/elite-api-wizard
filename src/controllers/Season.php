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

           
        $datos = json_decode($json, true);
        $responseHttp = $this->respuestas->error401();

        if (isset($datos['token'])) {
            $arrayToken = $this->token->checkToken($datos['token']);

            if ($arrayToken) {
                if (Utils::checkIssetEmptyNumeric($datos['club_id'], $datos['team_id'])) {
                    $seasons = $this->season->getSeasonsByClubTeam($datos['club_id'], $datos['team_id']);
                       
                    $resultado = new stdClass();
                    $resultado->status = 'ok';
                    $resultado->result = new stdClass();
                    $resultado->result = $seasons;
                        
                    $responseHttp = $resultado;
                } else {
                    $responseHttp = $this->respuestas->error200(ResponseHttp::DATAINCORRECTORINCOMPLETE);
                }
            } else {
                $responseHttp = $this->respuestas->error401(ResponseHttp::TOKENINVALIDOREXPIRED);
            }
        }
        return $responseHttp;
    }
}

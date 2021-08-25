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
          
        $datos = json_decode($json, true);
        $responseHttp = $this->respuestas->error401();

        if (isset($datos['token'])) {
            $arrayToken = $this->token->checkToken($datos['token']);

            if ($arrayToken) {
                if (isset($datos['find'])) {
                    $find = $datos['find'];

                    $languageId = (!isset($datos['language_id'])) ? 'GB' : $datos['language_id'];

                    $page = (isset($datos['page'])) ? $datos['page'] : 1;

                    $modeFast = (isset($datos['fast'])) ? $datos['fast'] : 0;

                    $limit = (isset($datos['limit'])) ? $datos['limit'] : 10;

                    $resultPlayers = array();
                    $resultClubs   = array();

                    if (!$modeFast) {
                        $resultPlayers = $this->player->findPlayers($find, $languageId, $page);
                        $resultClubs   = $this->club->findClubs($find, $languageId, $page);
                    } elseif (isset($find) && !empty($find)) {
                        $resultPlayers = $this->player->findPlayersFast($find, $languageId, $limit);
                        $resultClubs   = $this->club->findClubsFast($find, $languageId, $page);
                    }
                       
                    $resultado = new stdClass();
                    $resultado->status = 'ok';
                    $resultado->result = new stdClass();
                    $resultado->result->players = $resultPlayers;
                    $resultado->result->clubs = $resultClubs;
                        
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

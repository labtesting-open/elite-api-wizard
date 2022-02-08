<?php

namespace Elitesports;

use stdClass;

class Club
{
    private $club;
    private $token;
    private $respuestas;

    public function __construct()
    {
        $host = new HostConnection();
        $this->club = new \Elitelib\Club($host->getParams());
        $this->respuestas  = new Respuestas();
        $this->token = new Token();
    }


    public function checkTokenAndReturnResponse($json)
    {
        return $this->token->checkAndReturnResponseInBody($json);
    }


    public function getInfo($json)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);

        $datos = json_decode($json, true);

        if (isset($datos['club_id']) && is_numeric($datos['club_id'])) {
            $infoClub = $this->club->getBasicInfo($datos['club_id']);
            $responseHttp = $this->respuestas->standarSuccess($infoClub);
        }

        return $responseHttp;
    }
    
    public function getInfoWithFilters($json)
    {

        $responseHttp = $this->checkTokenAndReturnResponse($json);

        if (is_null($responseHttp)) {
            $datos = json_decode($json, true);

            $continentCode = null;
            if (isset($datos['continent_code']) &&  !empty($datos['continent_code'])) {
                $continentCode = $datos['continent_code'];
            }
            $countryCode = null;
            if (isset($datos['country_code']) &&  !empty($datos['country_code'])) {
                $countryCode = $datos['country_code'];
            }
            $categoryId = null;
            if (isset($datos['category_id']) &&  !empty($datos['category_id'])) {
                $categoryId = $datos['category_id'];
            }
            $divisionId = null;
            if (isset($datos['division_id']) &&  !empty($datos['division_id'])) {
                $divisionId = $datos['division_id'];
            }
            $page = 1;
            if (isset($datos['page']) &&  is_numeric($datos['page'])) {
                $page = $datos['page'];
            }
            $cant = 100;
            if (isset($datos['cant']) &&  is_numeric($datos['cant'])) {
                $cant = $datos['cant'];
            }
            
            $info = $this->club->getClubsByFilters(
                $continentCode,
                $countryCode,
                $categoryId,
                $divisionId,
                $page,
                $cant
            );

            $resultado = new stdClass();
            $resultado->status = 'ok';
            $resultado->result = new stdClass();
            $resultado->result = $info;
                    
            $responseHttp =  $resultado;
        }

        return $responseHttp;
    }


    public function getClubsWithFilters($json)
    {
        $paramsReceived = json_decode($json, true);

        $paramsAcepted = array(
            'continent_code' => null,
            'country_code' => null,            
            'page' => 1,
            'limit' => 100,
            'order' => 'club_name',
            'order_sense' => 'DESC',
            'language_code' => 'GB'
        );

        $paramsNormaliced = Utils::normalizerParams($paramsReceived, $paramsAcepted);
        
        $infoTeams = $this->club->getAvailableClubsWithFilters(
            $paramsNormaliced['continent_code'],
            $paramsNormaliced['country_code'],        
            $paramsNormaliced['order'],
            $paramsNormaliced['order_sense'],
            $paramsNormaliced['page'],
            $paramsNormaliced['limit'],
            $paramsNormaliced['language_code']
        );

        $totalRows = $this->club->getAvailableClubsWithFiltersTotalRows(
            $paramsNormaliced['continent_code'],
            $paramsNormaliced['country_code'],       
            $paramsNormaliced['order'],
            $paramsNormaliced['order_sense'],
            $paramsNormaliced['page'],
            $paramsNormaliced['limit'],
            $paramsNormaliced['language_code']
        );

        $paginate = Utils::getPaginateInfoWithTypeItem($totalRows, $paramsNormaliced['limit'], 'club');


        return $this->respuestas->standarSuccessPaginate($infoTeams, $paginate);

    }


}

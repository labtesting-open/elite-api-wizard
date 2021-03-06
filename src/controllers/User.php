<?php

namespace Elitesports;

use Elitesports\Respuestas;
use stdClass;

class User
{
    private $user;
    private $token;
    private $respuestas;

    public function __construct()
    {
        $host = new HostConnection();
        $this->user = new \Elitelib\User($host->getParams());
        $this->token = new \Elitelib\Token($host->getParams());
        $this->respuestas = new Respuestas();
    }


    public function getUserPlan($token)
    {
        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);
        
        if (isset($token)) {
            $arrayToken = $this->token->checkToken($token);

            if ($arrayToken) {
                   $userData = $this->user->getUserInfo($arrayToken[0]['user_id']);
                   $planServices = $this->user->getPlanServices($userData[0]['plan_id']);
              
                   $result = new stdClass();
                       
                   $result->userInfo = new stdClass();
                   $result->userInfo->id = $userData[0]['user_id'];
                   $result->userInfo->name = $userData[0]['name'];
                   $result->userInfo->surname = $userData[0]['surname'];
                   $result->userInfo->surname = $userData[0]['surname'];
                   $result->userInfo->img_perfil = $userData[0]['img_perfil_url'];
                   $result->userInfo->country_code = $userData[0]['country_code'];

                   $result->plan = new stdClass();
                   $result->plan->id = $userData[0]['plan_id'];
                   $result->plan->name = $userData[0]['plan_name'];
                   $result->plan->active = $userData[0]['active'];
                   $result->plan->services = new stdClass();
                   $result->plan->services = $planServices;
                   
                   $responseHttp = $this->respuestas->standarSuccess($result);
            } else {
                $responseHttp = $this->respuestas->error401(ResponseHttp::TOKENINVALIDOREXPIRED);
            }
        }
        return $responseHttp;
    }
}

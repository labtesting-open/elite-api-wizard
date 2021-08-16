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
        $this->user = new \Elitelib\User();
        $this->token = new \Elitelib\Token();
        $this->respuestas = new Respuestas();
    }


    public function getUserPlan($json)
    {
            
            $datos = json_decode($json, true);

        if (!isset($datos['token'])) {
            return $this->respuestas->error_401();
        } else {
            $arrayToken = $this->token->checkToken($datos['token']);

            if ($arrayToken) {
                   $userData = $this->user->getUserInfo($arrayToken[0]['user_id']);
                   $planServices = $this->user->getPlanServices($userData[0]['plan_id']);
                       
                   $resultado = new stdClass();
                   $resultado->status = 'ok';
                   $resultado->result = new stdClass();
                       
                   $resultado->result->userInfo = new stdClass();
                   $resultado->result->userInfo->id = $userData[0]['user_id'];
                   $resultado->result->userInfo->name = $userData[0]['name'];
                   $resultado->result->userInfo->surname = $userData[0]['surname'];
                   $resultado->result->userInfo->surname = $userData[0]['surname'];
                   $resultado->result->userInfo->img_perfil = $userData[0]['img_perfil_url'];

                   $resultado->result->plan = new stdClass();
                   $resultado->result->plan->id = $userData[0]['plan_id'];
                   $resultado->result->plan->name = $userData[0]['plan_name'];
                   $resultado->result->plan->active = $userData[0]['active'];
                   $resultado->result->plan->services = new stdClass();
                   $resultado->result->plan->services = $planServices;
                       
                   return $resultado;
            } else {
                return $this->respuestas->error_401('Token invalid or expired');
            }
        }
    }
}

<?php

namespace Elitesports;

use Elitesports\Respuestas;

class Token
{
    private $token;
    private $respuestas;

    public function __construct()
    {
        $this->respuestas  = new Respuestas();
        $this->token = new \Elitelib\Token();
    }

    public function checkAndReturnResponse($json)
    {
        $datos = json_decode($json, true);
        $responseHttp = $this->respuestas->error401();
        
        if (isset($datos['token'])) {
            $testToken = $this->token->checkToken($datos['token']);

            if ($testToken) {
                $responseHttp = null;
            } else {
                $responseHttp = $this->respuestas->error401(ResponseHttp::TOKENINVALIDOREXPIRED);
            }
        }
        return $responseHttp;
    }
}

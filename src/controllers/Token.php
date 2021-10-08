<?php

namespace Elitesports;

use Elitesports\Respuestas;

class Token
{
    private $token;
    private $respuestas;

    public function __construct()
    {
        $host = new HostConnection();        
        $this->token = new \Elitelib\Token($host->getParams());
        $this->respuestas  = new Respuestas();
    }

    public function checkAndReturnResponseInBody($json)
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

    public function checkAndReturnResponse($key)
    {
        $responseHttp = $this->respuestas->error401();
        
        if (isset($key) && !empty($key)) {
            $testToken = $this->token->checkToken($key);

            if ($testToken) {
                $responseHttp = null;
            } else {
                $responseHttp = $this->respuestas->error401(ResponseHttp::TOKENINVALIDOREXPIRED);
            }
        }
        return $responseHttp;
    }
}

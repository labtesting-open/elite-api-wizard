<?php

    namespace Elitesports;

    use Elitesports\Respuestas;
    use stdClass;

class UserClub
{

    private $userClub;
    private $token;
    private $respuestas;
    
    public function __construct()
    {
        $this->userClub = new \Elitelib\UserClub();
        $this->token = new \Elitelib\Token();
        $this->respuestas = new Respuestas();
    }


    public function getOwnClub($json)
    {
            
        $datos = json_decode($json, true);
        $responseHttp = $this->respuestas->error401();

        if (isset($datos['token'])) {
            $testToken = $this->token->checkToken($datos['token']);

            if ($testToken) {
                    $clubId = $this->userClub->getUserClub($testToken[0]['user_id']);

                    $resultado = new stdClass();
                    $resultado->status = 'ok';
                    $resultado->result = new stdClass();
                    $resultado->result = $clubId;
                        
                    $responseHttp = $resultado;
            } else {
                $responseHttp = $this->respuestas->error401(ResponseHttp::TOKENINVALIDOREXPIRED);
            }
        }
        return $responseHttp;
    }
}

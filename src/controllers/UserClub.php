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

        if (!isset($datos['token'])) {
            return $this->respuestas->error_401();
        } else {
            $testToken = $this->token->checkToken($datos['token']);

            if ($testToken) {
                    $club_id = $this->userClub->getUserClub($testToken[0]['user_id']);

                    $resultado = new stdClass();
                    $resultado->status = 'ok';
                    $resultado->result = new stdClass();
                    $resultado->result = $club_id;
                        
                    return $resultado;
            } else {
                return $this->respuestas->error_401('Token invalid or expired');
            }
        }
    }
}

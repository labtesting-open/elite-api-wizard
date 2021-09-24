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


    public function getOwnClub($token)
    {

        $responseHttp = $this->respuestas->error400(ResponseHttp::DATAINCORRECTORINCOMPLETE);
        
        if (isset($token)) {
            $arrayToken = $this->token->checkToken($token);

            if ($arrayToken) {
                $clubId = $this->userClub->getUserClub($arrayToken[0]['user_id']);
                
                $responseHttp = $this->respuestas->standarSuccess($clubId);
            } else {
                $responseHttp = $this->respuestas->error401(ResponseHttp::TOKENINVALIDOREXPIRED);
            }
        }
        
        return $responseHttp;
    }
}

<?php

namespace Elitesports;

use Elitesports\Respuestas;

class Login
{

    private $auth;
    private $respuestas;
    private $cryptography;
    private $publicKey = 'elitewizard';
    private $privateKey = 'talkthetalkorwalkthewalk';


    public function __construct()
    {
        $this->auth = new \Elitelib\Auth();
        $this->respuestas = new Respuestas();
        $this->cryptography = new \Elitesports\RSA($this->publicKey, $this->privateKey);
    }


    public function logOut($token)
    {
        $responseHttp = $this->respuestas->error400();

        if (isset($token)) {
            $datos = $this->auth->getUserToken($token);

            if ($datos) {
                if ($datos[0]['mode'] == 1) {
                    $actualizar = $this->auth->disableToken($datos[0]['id']);

                    if ($actualizar) {
                        $responseHttp = $this->respuestas->success200('token', 'disabled');
                    } else {
                        $responseHttp =  $this->respuestas->error500();
                    }
                } else {
                    $responseHttp =  $this->respuestas->error401(ResponseHttp::TOKENEXPIRED);
                }
            } else {
                $responseHttp = $this->respuestas->error401(ResponseHttp::TOKENINVALID);
            }
        }
        return $responseHttp;
    }


    public function login($json)
    {
        $datos = json_decode($json, true);
        $responseHttp = $this->respuestas->error400();

        if (isset($datos['user']) && isset($datos['password'])) {
            $usuario = $datos['user'];
            $password = $datos['password'];

            //$passwordDecoded = $this->cryptography->decodeBase64($password);
           
            $password = $this->auth->encriptar($password);

            $datos = $this->auth->getUserDataByUserName($usuario);

            if ($datos) {
                if ($password == $datos[0]['password']) {
                    if ($datos[0]['active'] == 1) {
                        $verificar = $this->auth->insertarToken($datos[0]['id']);

                        if ($verificar) {
                            $responseHttp = $this->respuestas->success200('token', $verificar);
                        } else {
                            $responseHttp = $this->respuestas->error500();
                        }
                    } else {
                        $responseHttp = $this->respuestas->error200(ResponseHttp::USERINACTIVE);
                    }
                } else {
                    $responseHttp = $this->respuestas->error200(ResponseHttp::INCORRECTPASSWORD);
                }
            } else {
                $responseHttp = $this->respuestas->error200("The user $usuario not found");
            }
        }
        return $responseHttp;
    }
}

<?php

namespace Elitesports;

use Elitesports\Respuestas;


class Login {

    private $auth;
    private $respuestas;


    public function __construct()
    {
        $this->auth = new \Elitelib\Auth();
        $this->respuestas = new Respuestas(); 
    }


    public function logOut($json){        
        
        $datos = json_decode($json, true);       

        if( !isset($datos['token']) ){
            //error
            return $this->respuestas->error_400();
        }else{
            //todo ok
            $token = $datos['token'];                     
            

            $datos = $this->auth->getUserToken($token);

            if($datos){

                if($datos[0]['mode'] == 1){                    

                    $actualizar = $this->auth->disableToken($datos[0]['id']);

                    if($actualizar){
                        $result = $this->respuestas->response;
                        $result["result"] = array(
                            "token" =>'disabled'
                        );

                    }else{
                        return $this->respuestas->error_500("Internal Error, updates fail");
                    }

                    return $result;
                   

                }else{
                    return $this->respuestas->error_200("Token expired");
                }


            }else{
                return $this->respuestas->error_200("Token ivalid");
            }

        }

    }


    public function login($json){
        
        

        $datos = json_decode($json, true);       

        if( !isset($datos['user']) || !isset($datos['password']) ){
            //error
            return $this->respuestas->error_400();
        }else{
            //todo ok
            $usuario = $datos['user'];
            $password = $datos['password'];            
           
            $password = $this->auth->encriptar($password); 

            $datos = $this->auth->obtenerDatosUsuario($usuario);

            if($datos){
                if($password == $datos[0]['password']){

                    if($datos[0]['active'] == 1){

                        $verificar = $this->auth->insertarToken($datos[0]['id']);

                        if($verificar){
                            $result = $this->respuestas->response;
                            $result["result"] = array(
                                "token" =>$verificar
                            );

                        }else{
                            return $this->respuestas->error_500("Internal Server Error");
                        }

                        return $result;

                    }else{
                        return $this->respuestas->error_200("user inactive");
                    }

                }else{
                    return $this->respuestas->error_200("Incorrect password");
                }


            }else{
                return $this->respuestas->error_200("The user $usuario not found");
            }

        }

    }




}

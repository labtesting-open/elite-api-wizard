<?php

namespace Elitesports;

class Respuestas
{

    public $response = [
        'status' => 'ok',
        'result' => array()
    ];


    public function error405()
    {
        
        $this->response['status'] = 'error';

        $this->response['result'] = array(
            'error_id' => '405',
            'error_msg' => 'Metodo no permitido'
        );

        return $this->response;
    }

    public function error200($valor = 'Datos incorrectos')
    {
        
        $this->response['status'] = 'error';
        
        $this->response['result'] = array(
            'error_id' => '200',
            'error_msg' => $valor
        );

        return $this->response;
    }


    public function error400()
    {
        
        $this->response['status'] = 'error';
        
        $this->response['result'] = array(
            'error_id' => '400',
            'error_msg' => 'Datos enviados incompletos o incorrectos'
        );

        return $this->response;
    }

    public function error500($valor = 'Error interno del servidor')
    {
        
        $this->response['status'] = 'error';
        
        $this->response['result'] = array(
            'error_id' => '500',
            'error_msg' => $valor
        );

        return $this->response;
    }

    public function error401($valor = 'No autorizado')
    {
        
        $this->response['status'] = 'error';
        
        $this->response['result'] = array(
            'error_id' => '401',
            'error_msg' => $valor
        );

        return $this->response;
    }

    public function success200($key = null, $valor = null)
    {
        
        $this->response['status'] = 'ok';
        
        $this->response['result'] = array(
            "$key" => "$valor"
        );

        return $this->response;
    }

    public function standarResponse($code = 200, $result = null)
    {
        $this->response['status'] = $code;
        
        $this->response['result'] = $result;

        return $this->response;
    }
}

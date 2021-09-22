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
            'error_msg' => 'Method Not Allowed'
        );

        //http_response_code(405);

        return $this->response;
    }

    public function error200($valor = 'Datos incorrectos')
    {
        
        $this->response['status'] = 'error';
        
        $this->response['result'] = array(
            'error_id' => '200',
            'error_msg' => $valor
        );

        //http_response_code(200);

        return $this->response;
    }


    public function error400($msg='Bad Request')
    {
        
        $this->response['status'] = 'error';
        
        $this->response['result'] = array(
            'error_id' => '400',
            'error_msg' => $msg
        );

        //http_response_code(400);

        return $this->response;
    }

    public function error500($valor = 'Internal Server Error')
    {
        
        $this->response['status'] = 'error';
        
        $this->response['result'] = array(
            'error_id' => '500',
            'error_msg' => $valor
        );

        //http_response_code(500);

        return $this->response;
    }

    public function error401($msg = 'Unauthorized')
    {
        $this->response['status'] = 'error';
        
        $this->response['result'] = array(
            'error_id' => '401',
            'error_msg' => $msg
        );

        //http_response_code(401);

        return $this->response;
    }

    public function success200($key = null, $valor = null)
    {
        
        $this->response['status'] = 'ok';
        
        $this->response['result'] = array(
            "$key" => "$valor"
        );

        //http_response_code(200);

        return $this->response;
    }

    public function standarSuccess($result = null, $code = 'ok')
    {
        $this->response['status'] = $code;
        
        $this->response['result'] = $result;

        //http_response_code(200);

        return $this->response;
    }

    public function customResponse($status='ok', $code = 200, $msg = null)
    {   
        $this->response['status'] = 'error';
        
        $this->response['result'] = array(
            'error_id' => $code,
            'error_msg' => $msg
        );

        //http_response_code(intval($code));

        return $this->response;
    }
}

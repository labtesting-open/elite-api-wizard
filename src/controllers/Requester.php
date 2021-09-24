<?php

namespace Elitesports;

use GuzzleHttp\Client;

class Requester
{
    public $client;
    public $apiUrl;
    public $bodyWithCredentials;
    public $settings;

    public function __construct()
    {
        $settings = new \Elitesports\Setting('remote');

        $this->apiUrl = $settings->getApiUrl();
        $this->bodyWithCredentials = $settings->getBodyWithCredentials();
        $this->client = new Client();
    }

    public function getAuth()
    {
       
        $urlAuth = $this->apiUrl . '/login.php';

        $requestAuth = $this->client->request(
            'POST',
            $urlAuth,
            [
            'body' => $this->bodyWithCredentials
            ]
        );
    
        $responseAuth = json_decode($requestAuth->getBody()->getContents());
        
        return $responseAuth;
    }


    public function testRequest($method, $endPoint, $parameters)
    {

        try {
            $auth = $this->getAuth();

            $token = $auth->result->token;
            
            $url = $this->apiUrl . '/' . $endPoint;

            $url .= $parameters;

            $headers = [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => 'Bearer ' . $token
            ];

            $requestCustom = $this->client->request(
                $method,
                $url,
                [
                'headers' => $headers
                ]
            );

            $response = json_decode($requestCustom->getBody()->getContents());
            
            
            return $response;
        } catch (\Throwable $th) {
            return var_dump($th->getMessage());
        }
    }
}

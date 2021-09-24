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

        return json_decode($requestAuth->getBody()->getContents());
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

            return json_decode($requestCustom->getBody()->getContents());
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}

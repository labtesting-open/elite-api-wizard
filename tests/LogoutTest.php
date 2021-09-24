<?php

declare(strict_types=1);

namespace Elitesports\Test;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class LogoutTest extends TestCase
{
    public $client;
    public $apiUrl;
    public $bodyWithCredentials;
    public $settings;
    

    protected function setUp(): void
    {
        $settings = new \Elitesports\Setting('remote');

        $this->apiUrl = $settings->getApiUrl();
        $this->bodyWithCredentials = $settings->getBodyWithCredentials();
        $this->client = new Client();
    }


    public function testLogOutResultStatus()
    {

        try {
            $urlAuth = $this->apiUrl . '/login.php';

            $requestAuth = $this->client->request(
                'POST',
                $urlAuth,
                [
                'body' => $this->bodyWithCredentials
                ]
            );
        
            $responseAuth = json_decode($requestAuth->getBody()->getContents());
            
            $token = $responseAuth->result->token;
            
            $url = $this->apiUrl . '/logout.php';

            $headers = [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => 'Bearer ' . $token
            ];

            $requestCustom = $this->client->request(
                'GET',
                $url,
                [
                'headers' => $headers
                ]
            );

            $response = json_decode($requestCustom->getBody()->getContents());

            $this->assertContains($response->status, array('ok','error'));
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}

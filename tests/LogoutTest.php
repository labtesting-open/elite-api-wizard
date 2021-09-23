<?php

declare(strict_types=1);

namespace Elitesports\Test;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class LogoutTest extends TestCase
{
    public $user;
    public $password;
    public $client;
    public $server;
    public $apiFolder;
    public $parentFolder;
    public $version;
    

    protected function setUp(): void
    {
        $settings = new \Elitesports\Setting('remote');

        $this->server   = $settings->getServer();        
        $this->apiFolder = $settings->getApiFolder();
        $this->parentFolder = $settings->getParentFolder();
        $this->version = $settings->getVersion();
        $this->bodyWithCredentials = $settings->getBodyWithCredentials();
        $this->client = new Client();
    }


    public function testLogOutResultStatus()
    {

        try {
            $url = $this->server . $this->parentFolder . $this->apiFolder . $this->version . '/login.php';

            $requestAuth = $this->client->request(
                'POST',
                $url,
                [
                'body' => $this->bodyWithCredentials
                ]
            );
        
            $responseAuth = json_decode($requestAuth->getBody()->getContents());
            
            $token = $responseAuth->result->token; 
            
            $url = $this->server . $this->parentFolder . $this->apiFolder . $this->version . '/logout.php';

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

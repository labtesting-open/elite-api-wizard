<?php

declare(strict_types=1);

namespace Elitesports\Test;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class ClubTest extends TestCase
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
        $settings = new \Elitesports\Setting();

        $this->server   = $settings->getServer();
        $this->user     = $settings->getUser();
        $this->password = $settings->getPassword();
        $this->apiFolder = $settings->getApiFolder();
        $this->parentFolder = $settings->getParentFolder();
        $this->version = $settings->getVersion();

        $this->client = new Client();
    }


    public function testClubResultStatus()
    {

        try {
            $body = '{"user":"' . $this->user . '","password":"' . $this->password . '"}';

            $url = $this->server . $this->parentFolder . $this->apiFolder . $this->version . '/login.php';

            $requestAuth = $this->client->request(
                'POST',
                $url,
                [
                'body' => $body
                ]
            );
        
            $responseAuth = json_decode($requestAuth->getBody()->getContents());
            
            $token = $responseAuth->result->token;
            
            $body = '{"club_id":"1"}';            
            
            $url = $this->server . $this->parentFolder . $this->apiFolder . $this->version . '/club.php';  

            $requestCustom = $this->client->request('GET', $url,             
            [
                'headers' => 
                [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'token' => $token
                ],
                'body' => $body                
            ]);

        
            $response = json_decode($requestCustom->getBody()->getContents());        
           
            //var_dump($response);            

            $this->assertEquals('ok', $response->status);
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}

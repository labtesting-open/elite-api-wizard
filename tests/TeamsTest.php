<?php

declare(strict_types=1);

namespace Elitesports\Test;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class TeamsTest extends TestCase
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
        $this->user     = $settings->getUser();
        $this->password = $settings->getPassword();
        $this->apiFolder = $settings->getApiFolder();
        $this->parentFolder = $settings->getParentFolder();
        $this->version = $settings->getVersion();

        $this->client = new Client();
    }


    public function testTeamsResultStatus()
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
            
            $body = '';
            
            $url = $this->server . $this->parentFolder . $this->apiFolder . $this->version . '/teams.php';           

            $parameters = '?club_id=1&country_code=GB';
            $url.=$parameters;

            $requestCustom = $this->client->request(
                'GET',
                $url,
                [               
                'headers' =>
                [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => 'Bearer '.$token
                ],
                'body' => $body
                ]
            );

            $response = json_decode($requestCustom->getBody()->getContents());
            
            //var_dump($response->status);
            

            $this->assertEquals('ok', $response->status);
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}

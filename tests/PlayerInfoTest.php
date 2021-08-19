<?php

declare(strict_types=1);

namespace Elitesports\Test;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class PlayerInfoTest extends TestCase
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


    public function testPlayerInfoResultStatus()
    {

        try {
            $body = '{"user":"' . $this->user . '","password":"' . $this->password . '"}';

            $url = $this->server . $this->parentFolder . $this->apiFolder . $this->version . '/login.php';

            $requestToken = $this->client->request(
                'POST',
                $url,
                [
                'body' => $body
                ]
            );
        
            $response = json_decode($requestToken->getBody()->getContents());
            
            $token = $response->result->token;

            $body = '{"token":"' . $token . '",
                "id":"47",
                "language_id":"ES"
            }';
            
            $url = $this->server . $this->parentFolder . $this->apiFolder . $this->version . '/player.info.php';
            

            $requestBasic = $this->client->request(
                'POST',
                $url,
                [
                'body' => $body
                ]
            );
        
            $response = json_decode($requestBasic->getBody()->getContents());
        
            //var_dump($response->status);

            $this->assertEquals('ok', $response->status);
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}

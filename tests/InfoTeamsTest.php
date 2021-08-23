<?php

declare(strict_types=1);

namespace Elitesports\Test;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class InfoTeamsTest extends TestCase
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


    public function testInfoTeamsResultStatus()
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
                "page":"1",
                "continent_code":"SA",
                "country_code":"AR",
                "category_id":"1",
                "division_id":"1",
                "order":"club_name",
                "ordersense":"DESC"
            }';
            
            $url = $this->server . $this->parentFolder . $this->apiFolder . $this->version;
            $url .= '/info.teams.php';

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

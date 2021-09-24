<?php

declare(strict_types=1);

namespace Elitesports\Test;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class FiltersPlayersTest extends TestCase
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


    public function testFiltersPlayersResultStatus()
    {

        try {
            $url = $this->apiUrl . '/login.php';

            $requestAuth = $this->client->request(
                'POST',
                $url,
                [
                'body' => $this->bodyWithCredentials
                ]
            );
        
            $response = json_decode($requestAuth->getBody()->getContents());

            $token = $response->result->token;
            
            $url = $this->apiUrl . '/filters.players.php';

            $parameters = '?target=all';
            $url .= $parameters;
    
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

            $this->assertEquals('ok', $response->status);
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}

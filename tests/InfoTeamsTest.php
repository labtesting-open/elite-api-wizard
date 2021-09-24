<?php

declare(strict_types=1);

namespace Elitesports\Test;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class InfoTeamsTest extends TestCase
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


    public function testInfoTeamsResultStatus()
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
            
            $url = $this->apiUrl . '/info.teams.php';

            $parameters = '?continent_code=sa
            &country_code=ar
            &category_id=1
            &division_id=1
            &order=club_name
            &ordersense=desc';

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

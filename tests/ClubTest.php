<?php

declare(strict_types=1);

namespace Elitesports\Test;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class ClubTest extends TestCase
{
    public $user = null;
    

    protected function setUp(): void
    {
        $this->user = 'elitesports17';
        $this->client = new Client();
    }


    public function testClubResultStatus()
    {

        try {
            $requestToken = $this->client->request(
                'POST',
                'http://localhost/labtest/elite-api-wizard/v1/login.php',
                [
                'body' => '{
                    "user":"elitesports17",
                    "password":"abc1234"
                }']
            );
        
            $response = json_decode($requestToken->getBody()->getContents());

            $token = $response->result->token;

            $body = '{"token":"' . $token . '","club_id":"1"}';
            
            $requestBasic = $this->client->request(
                'POST',
                'http://localhost/labtest/elite-api-wizard/v1/club.php',
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

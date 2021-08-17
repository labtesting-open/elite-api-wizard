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
        $this->password = 'abc1234';
        $this->client = new Client();
        $this->urlServer = 'http://4a82261d3a15.ngrok.io';
    }


    public function testClubResultStatus()
    {

        try {
            $body = '{"user":"' . $this->user . '","password":"' . $this->password . '"}';
            $url = $this->urlServer . '/labtest/elite-api-wizard/v1/login.php';

            $requestToken = $this->client->request(
                'POST',
                $url,
                [
                'body' => $body
                ]
            );
        
            $response = json_decode($requestToken->getBody()->getContents());

            $token = $response->result->token;

            $body = '{"token":"' . $token . '","club_id":"1"}';
            $url = $this->urlServer . '/labtest/elite-api-wizard/v1/club.php';
            
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

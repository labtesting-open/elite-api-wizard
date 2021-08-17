<?php

declare(strict_types=1);

namespace Elitesports\Test;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class LogoutTest extends TestCase
{
    public $user = null;
    

    protected function setUp(): void
    {
        $this->user = 'elitesports17';
        $this->client = new Client();
    }


    public function testLogOutResultStatus()
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

            $body = '{"token":"' . $token . '"}';

            $requestBasic = $this->client->request(
                'POST',
                'http://localhost/labtest/elite-api-wizard/v1/logout.php',
                [
                'body' => $body
                ]
            );
        
            $response = json_decode($requestBasic->getBody()->getContents());
        
            //var_dump($response->status);

            $this->assertContains($response->status, array('ok','error'));
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}

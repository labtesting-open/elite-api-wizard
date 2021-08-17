<?php

declare(strict_types=1);

namespace Elitesports\Test;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class PlayerInfoTest extends TestCase
{
    public $user = null;
    

    protected function setUp(): void
    {
        $this->user = 'elitesports17';
        $this->client = new Client();
    }


    public function testPlayerInfoResultStatus()
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

            $body = '{"token":"' . $token . '",
                "id":"47",
                "language_id":"ES"
            }';

            $requestBasic = $this->client->request(
                'POST',
                'http://localhost/labtest/elite-api-wizard/v1/player.info.php',
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

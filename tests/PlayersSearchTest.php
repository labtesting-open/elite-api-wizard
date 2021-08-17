<?php

declare(strict_types=1);

namespace Elitesports\Test;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class PlayersSearchTest extends TestCase
{
    public $user = null;
    

    protected function setUp(): void
    {
        $this->user = 'elitesports17';
        $this->client = new Client();
    }


    public function testPlayerSearchResultStatus()
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
                "season_id":"1",
                "club_id":"1",
                "team_id":"1",
                "language_id":"GB",
                "find":"teve"     
            }';

            $requestBasic = $this->client->request(
                'POST',
                'http://localhost/labtest/elite-api-wizard/v1/players.search.php',
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

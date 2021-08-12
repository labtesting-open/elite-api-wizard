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
            $requestBasic = $this->client->request(
                'POST',
                'http://localhost/labtest/elite-api-wizard/v1/players.search.php',
                [
                'body' => '{
                    "token":"85c6dc7d5922cb381f8eb8a82671d6e9",
                    "season_id":"1",
                    "club_id":"1",
                    "team_id":"1",
                    "language_id":"GB",
                    "find":"teve"                       
                }']
            );
        
            $response = json_decode($requestBasic->getBody()->getContents());
        
            //var_dump($response->status);

            $this->assertEquals('ok', $response->status);
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}

<?php

declare(strict_types=1);

namespace Elitesports\Test;

use Elitesports\Requester;
use PHPUnit\Framework\TestCase;

class PlayersSearchTest extends TestCase
{
    public $requester;

    protected function setUp(): void
    {     
       $this->requester = new Requester();
    }


    public function testPlayerSearchResultStatus()
    {       
        try {

            $parameters = '?club_id=1&team_id=1&season_id=1&country_code=GB&find=teve';    

            $response = $this->requester->testRequest('GET', 'players.search', $parameters);

            $this->assertEquals('ok', $response->status);

        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }

    }
}
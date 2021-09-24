<?php

declare(strict_types=1);

namespace Elitesports\Test;

use Elitesports\Requester;
use PHPUnit\Framework\TestCase;

class FiltersPlayersTest extends TestCase
{
    public $requester;

    protected function setUp(): void
    {     
       $this->requester = new Requester();
    }


    public function testFilterPlayersResultStatus()
    {       
        try {

            $parameters ="?target=all";    

            $response = $this->requester->testRequest('GET', 'filters.players', $parameters);

            $this->assertEquals('ok', $response->status);

        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }

    }
}
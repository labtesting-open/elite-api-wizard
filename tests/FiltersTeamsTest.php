<?php

declare(strict_types=1);

namespace Elitesports\Test;

use Elitesports\Requester;
use PHPUnit\Framework\TestCase;

class FiltersTeamsTest extends TestCase
{
    public $requester;

    protected function setUp(): void
    {     
       $this->requester = new Requester();
    }


    public function testFilterTeamsResultStatus()
    {       
        try {

            $parameters ="?target=all";

            $response = $this->requester->testRequest('GET', 'filters.teams', $parameters);

            $this->assertEquals('ok', $response->status);

        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }

    }
}
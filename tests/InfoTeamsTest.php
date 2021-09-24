<?php

declare(strict_types=1);

namespace Elitesports\Test;

use Elitesports\Requester;
use PHPUnit\Framework\TestCase;

class InfoTeamsTest extends TestCase
{
    public $requester;

    protected function setUp(): void
    {     
       $this->requester = new Requester();
    }


    public function testInfoTeamsResultStatus()
    {
        try {

            $parameters = "?continent_code=sa
            &country_code=ar
            &category_id=1
            &division_id=1
            &order=club_name
            &ordersense=desc";

            $response = $this->requester->testRequest('GET', 'info.teams', $parameters);

            $this->assertEquals('ok', $response->status);

        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }

    }
}
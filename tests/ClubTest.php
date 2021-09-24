<?php

declare(strict_types=1);

namespace Elitesports\Test;

use Elitesports\Requester;
use PHPUnit\Framework\TestCase;

class ClubTest extends TestCase
{
    public $requester;

    protected function setUp(): void
    {     
       $this->requester = new Requester();
    }


    public function testClubResultStatus()
    {       
        try {

            $parameters ="?club_id=1&country_code=GB";

            $response = $this->requester->testRequest('GET', 'club', $parameters);

            $this->assertEquals('ok', $response->status);

        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }

    }
}

<?php

declare(strict_types=1);

namespace Elitesports\Test;

use Elitesports\Requester;
use PHPUnit\Framework\TestCase;

class EditTeamTest extends TestCase
{
    public $requester;

    protected function setUp(): void
    {
        $this->requester = new Requester();
    }


    public function testEditTeamResultStatus()
    {
        try {
            $parameters = '?team_id=1';

            $response = $this->requester->testRequest('GET', 'edit.team', $parameters);

            $this->assertEquals('ok', $response->status);
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}

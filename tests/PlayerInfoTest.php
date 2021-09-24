<?php

declare(strict_types=1);

namespace Elitesports\Test;

use Elitesports\Requester;
use PHPUnit\Framework\TestCase;

class PlayerInfoTest extends TestCase
{
    public $requester;

    protected function setUp(): void
    {
        $this->requester = new Requester();
    }


    public function testPlayerInfoResultStatus()
    {
        try {
            $parameters = '?id=47
            &country_code=GB';

            $response = $this->requester->testRequest('GET', 'player.info', $parameters);

            $this->assertEquals('ok', $response->status);
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}

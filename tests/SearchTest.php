<?php

declare(strict_types=1);

namespace Elitesports\Test;

use Elitesports\Requester;
use PHPUnit\Framework\TestCase;

class SearchTest extends TestCase
{
    public $requester;

    protected function setUp(): void
    {
        $this->requester = new Requester();
    }


    public function testSearchResultStatus()
    {
        try {
            $parameters = '?find=baye&fast=1&limit=10&country_code=GB';

            $response = $this->requester->testRequest('GET', 'search', $parameters);

            $this->assertEquals('ok', $response->status);
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}

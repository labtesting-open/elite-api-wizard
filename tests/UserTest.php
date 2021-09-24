<?php

declare(strict_types=1);

namespace Elitesports\Test;

use Elitesports\Requester;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public $requester;

    protected function setUp(): void
    {     
       $this->requester = new Requester();
    }


    public function testUserResultStatus()
    {       
        try {            

            $response = $this->requester->testRequest('GET', 'user', null);

            $this->assertEquals('ok', $response->status);

        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }

    }
}
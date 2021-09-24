<?php

declare(strict_types=1);

namespace Elitesports\Test;

use Elitesports\Requester;
use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    public $requester;

    protected function setUp(): void
    {     
       $this->requester = new Requester();
    }


    public function testLoginResultStatus()
    {       
        try {

            $response = $this->requester->getAuth();

            $this->assertEquals('ok', $response->status);

        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }

    }
}
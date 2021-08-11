<?php

declare(strict_types=1);

require_once __DIR__."/../vendor/autoload.php";

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;



class LoginTest extends TestCase
{
    public $user = null;
    public $auth_model;

    protected function setUp(): void
    {
        $this->auth_model = new Elitelib\Auth();
        $this->user = 'elitesports17';
        $this->client = new Client();
    }


    public function testLogin(){

        try{

            $requestBasic = $this->client->request('POST', 'http://localhost/labtest/elite-api-wizard/v1/login.php',[
                'body'=>'{
                    "user":"elitesports17",
                    "password":"abc1234"
                }']
            );
        
            $response = json_decode($requestBasic->getBody()->getContents());
        
            //var_dump($response->status);

            $this->assertEquals('ok', $response->status);

        
        
        }catch (\Throwable $th){
            var_dump($th->getMessage());
        }
        
    }


}
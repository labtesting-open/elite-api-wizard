<?php

declare(strict_types=1);

require_once __DIR__."/../vendor/autoload.php";

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;


class LogoutTest extends TestCase
{
    public $user = null;
    

    protected function setUp(): void
    {       
        $this->user = 'elitesports17';
        $this->client = new Client();
    }


    public function testLogOutResultStatus(){

        try{

            $requestBasic = $this->client->request('POST', 'http://localhost/labtest/elite-api-wizard/v1/logout.php',[
                'body'=>'{
                    "token":"4cc62325fa16c70320e4247c22f08459"
                }']
            );
        
            $response = json_decode($requestBasic->getBody()->getContents());
        
            //var_dump($response->status);  

            $this->assertContains($response->status, array('ok','error'));
        
        
        }catch (\Throwable $th){
            var_dump($th->getMessage());
        }
        
    }

   


}
<?php

declare(strict_types=1);

require_once __DIR__."/../vendor/autoload.php";

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;



class SeasonsTest extends TestCase
{
    public $user = null;
    

    protected function setUp(): void
    {        
        $this->user = 'elitesports17';
        $this->client = new Client();
    }


    public function testSeasonsResultStatus(){

        try{

            $requestBasic = $this->client->request('POST', 'http://localhost/labtest/elite-api-wizard/v1/seasons.php',[
                'body'=>'{
                    "token":"85c6dc7d5922cb381f8eb8a82671d6e9",
                    "club_id":"1",
                    "team_id":"1"   
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
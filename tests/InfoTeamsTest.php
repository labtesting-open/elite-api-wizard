<?php

declare(strict_types=1);

require_once __DIR__."/../vendor/autoload.php";

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;



class InfoTeamsTest extends TestCase
{
    public $user = null;
    

    protected function setUp(): void
    {        
        $this->user = 'elitesports17';
        $this->client = new Client();
    }


    public function testInfoTeamsResultStatus(){

        try{

            $requestBasic = $this->client->request('POST', 'http://localhost/labtest/elite-api-wizard/v1/teams.php',[
                'body'=>'{
                    "token":"85c6dc7d5922cb381f8eb8a82671d6e9",
                    "page":"1",
                    "continent_code":"SA",
                    "country_code":"AR",
                    "category_id":"1",
                    "division_id":"1",
                    "order":"club_name",
                    "ordersense":"DESC"
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
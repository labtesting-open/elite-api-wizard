<?php

require_once __DIR__."/../vendor/autoload.php";

use GuzzleHttp\Client;

$client = new Client();

// $request = $client->request('get', 'http://localhost/elitesports17-ess18/players');

// $response = json_decode($request->getBody()->getContents());
//var_dump($requestBasic->geStatusCode());


try{

    $requestBasic = $client->request('POST', 'http://localhost/labtest/elite-api-wizard/v1/login.php',[
        'body'=>'{
            "user":"elitesports17",
            "password":"abc1234"
        }']
    );

    $response = json_decode($requestBasic->getBody()->getContents());

    var_dump($response);


}catch (\Throwable $th){
    var_dump($th->getMessage());
}





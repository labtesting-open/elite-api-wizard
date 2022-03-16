<?php

use Elitesports\OutputsTypes;
use Elitesports\Utils;

include __DIR__."/../vendor/autoload.php";
include('extras/headers.php');

$teamController = new \Elitesports\Team();
$responsesController = new \Elitesports\Respuestas();
$newsFavouritePlayerController = new \Elitesports\NewsFavouritePlayer();
$tokenController = new \Elitesports\Token();


if ($_SERVER['REQUEST_METHOD'] == "GET") {

    $headers = apache_request_headers();    
    $token = Utils::getkey($headers,'authorization', 'Bearer');
    
    $httpResponse = $tokenController->checkAndReturnResponse($token);

    if ( is_null($httpResponse)) {

        $params = Utils::getAllParams($_GET, OutputsTypes::JSON);

        $httpResponse = $newsFavouritePlayerController->getNewsList($params, $token);
    }

} else if($_SERVER['REQUEST_METHOD'] == "POST") {

    $headers = apache_request_headers();    
    $token = Utils::getkey($headers,'authorization', 'Bearer');
    
    $httpResponse = $tokenController->checkAndReturnResponse($token);

    if ( is_null($httpResponse)) { 

        $httpResponse = $newsFavouritePlayerController->setListViewed($_REQUEST, $token);       
        
    }

}else if($_SERVER['REQUEST_METHOD'] == "PUT"){

    $headers = apache_request_headers();    
    $token = Utils::getkey($headers,'authorization', 'Bearer');
    
    $httpResponse = $tokenController->checkAndReturnResponse($token);

    if ( is_null($httpResponse)) { 

        $httpResponse = $newsFavouritePlayerController->updateDataCheckNews($_REQUEST, $token);       
        
    }   

}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){

    $httpResponse = $responsesController->error405();

}else{
    $httpResponse = $responsesController->error405();
}

echo json_encode($httpResponse);

<?php

use Elitesports\OutputsTypes;
use Elitesports\Utils;

include __DIR__."/../vendor/autoload.php";
include('extras/headers.php');

$teamController = new \Elitesports\Team();
$responsesController = new \Elitesports\Respuestas();
$favouriteController = new \Elitesports\Favourite();
$tokenController = new \Elitesports\Token();


if ($_SERVER['REQUEST_METHOD'] == "GET") {

    $headers = apache_request_headers();    
    $token = Utils::getkey($headers,'authorization', 'Bearer');
    
    $httpResponse = $tokenController->checkAndReturnResponse($token);

    if ( is_null($httpResponse)) {

        $params = Utils::getAllParams($_GET, OutputsTypes::JSON);

        $httpResponse = $favouriteController->getActions($params, $token);
    }

} else if($_SERVER['REQUEST_METHOD'] == "POST") {
    
    $headers = apache_request_headers();    
    $token = Utils::getkey($headers,'authorization', 'Bearer');
    
    $httpResponse = $tokenController->checkAndReturnResponse($token);

    if ( is_null($httpResponse)) {
        
        $httpResponse = $responsesController->error400('Data incorrect or incomplete');
        
        $httpResponse = $favouriteController->addFavotite($_REQUEST, $token);       
        
    }


}else if($_SERVER['REQUEST_METHOD'] == "PUT"){

    $httpResponse = $responsesController->error405('Update method is available using POST');
   

}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){

    $headers = apache_request_headers();    
    $token = Utils::getkey($headers,'authorization', 'Bearer');
    
    $httpResponse = $tokenController->checkAndReturnResponse($token);

    if ( is_null($httpResponse)) {        
        $params = Utils::getAllParams($_GET, OutputsTypes::JSON);

        $httpResponse = $favouriteController->deleteFavourite($params, $token);        
    }    

}else{
    
    $httpResponse = $responsesController->error405();
}

echo json_encode($httpResponse);
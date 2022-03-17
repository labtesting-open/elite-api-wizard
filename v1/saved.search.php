<?php

use Elitesports\OutputsTypes;
use Elitesports\Utils;

include __DIR__."/../vendor/autoload.php";
include('extras/headers.php');

$savedSearchControlledController = new \Elitesports\SavedSearch();
$responsesController = new \Elitesports\Respuestas();
$tokenController = new \Elitesports\Token();


if ($_SERVER['REQUEST_METHOD'] == "GET") {

    $headers = apache_request_headers();    
    $token = Utils::getkey($headers,'authorization', 'Bearer');

    $httpResponse = $tokenController->checkAndReturnResponse($token);

    if ( is_null($httpResponse)) {

        $params = Utils::getAllParams($_GET, OutputsTypes::JSON);

        $httpResponse = $savedSearchControlledController->get($params, $token);

    }
   

} else if($_SERVER['REQUEST_METHOD'] == "POST") {

    $headers = apache_request_headers();    
    $token = Utils::getkey($headers,'authorization', 'Bearer');
    
    $httpResponse = $tokenController->checkAndReturnResponse($token);    

    if ( is_null($httpResponse)) {

        $params = Utils::getAllParams($_GET, OutputsTypes::JSON);

        $httpResponse = $savedSearchControlledController->save($params, $token);

    }

    

}else if($_SERVER['REQUEST_METHOD'] == "PUT"){

    $httpResponse = $responsesController->error405();

}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){

    $httpResponse = $responsesController->error405();

}else{

    $httpResponse = $responsesController->error405();
}

echo json_encode($httpResponse);
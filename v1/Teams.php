<?php

use Elitesports\OutputsTypes;
use Elitesports\Utils;

include __DIR__."/../vendor/autoload.php";
include('extras/headers.php');

$teamController = new \Elitesports\Team();
$responsesController = new \Elitesports\Respuestas();
$tokenController = new \Elitesports\Token();


if ($_SERVER['REQUEST_METHOD'] == "GET") {

    $headers = apache_request_headers();    
    $token = Utils::getkey($headers,'authorization', 'Bearer');
    
    $httpResponse = $tokenController->checkAndReturnResponse($token);

    if ( is_null($httpResponse)) {        
        $params = Utils::getAllParams($_GET, OutputsTypes::JSON);

        $httpResponse = $teamController->getClubTeams($params);        
    }    

} else if($_SERVER['REQUEST_METHOD'] == "POST") {
    
    $headers = apache_request_headers();    
    $token = Utils::getkey($headers,'authorization', 'Bearer');
    
    $httpResponse = $tokenController->checkAndReturnResponse($token);

    if ( is_null($httpResponse)) {        
        
        $body = file_get_contents("php://input");
        
        $httpResponse = $teamController->addTeam($body);        
    }


}else if($_SERVER['REQUEST_METHOD'] == "PUT"){

    $headers = apache_request_headers();    
    $token = Utils::getkey($headers,'authorization', 'Bearer');
    
    $httpResponse = $tokenController->checkAndReturnResponse($token);

    if ( is_null($httpResponse)) {        
        
        $body = file_get_contents("php://input");
        
        $httpResponse = $teamController->updateTeam($body);        
    }

}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){

    $headers = apache_request_headers();    
    $token = Utils::getkey($headers,'authorization', 'Bearer');
    
    $httpResponse = $tokenController->checkAndReturnResponse($token);

    if ( is_null($httpResponse)) {        
        $params = Utils::getAllParams($_GET, OutputsTypes::JSON);

        $httpResponse = $teamController->deleteTeam($params);        
    }    

}else{
    
    $httpResponse = $responsesController->error405();
}

echo json_encode($httpResponse);
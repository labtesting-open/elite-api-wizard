<?php

use Elitesports\OutputsTypes;
use Elitesports\Utils;

include __DIR__."/../vendor/autoload.php";
include('extras/headers.php');

$tagController = new \Elitesports\Tag();
$responsesController = new \Elitesports\Respuestas();
$tokenController = new \Elitesports\Token();


if ($_SERVER['REQUEST_METHOD'] == "GET") {

    $headers = apache_request_headers();    
    $token = Utils::getkey($headers,'authorization', 'Bearer');
    
    $httpResponse = $tokenController->checkAndReturnResponse($token);

    if ( is_null($httpResponse)) {

        $params = Utils::getAllParams($_GET, OutputsTypes::JSON);

        $httpResponse = $tagController->get($params);
    }

} else if($_SERVER['REQUEST_METHOD'] == "POST") {

    $headers = apache_request_headers();    
    $token = Utils::getkey($headers,'authorization', 'Bearer');
    
    $httpResponse = $tokenController->checkAndReturnResponse($token);    

    if ( is_null($httpResponse)) {

        $postBody = file_get_contents("php://input");       
        
        $jsonValidated = Utils::isValidJSON($postBody);

        if($jsonValidated)
        {
            $httpResponse = $tagController->addList($postBody);            
        }else{
            $params = Utils::getAllParams($_GET, OutputsTypes::JSON);
            $httpResponse = $tagController->add($params);            
        }        

    }

}else if($_SERVER['REQUEST_METHOD'] == "PUT"){

    $headers = apache_request_headers();    
    $token = Utils::getkey($headers,'authorization', 'Bearer');
    
    $httpResponse = $tokenController->checkAndReturnResponse($token);    

    if ( is_null($httpResponse)) {

        $params = Utils::getAllParams($_GET, OutputsTypes::JSON);

        $httpResponse = $tagController->update($params);

    }

}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){

    $headers = apache_request_headers();    
    $token = Utils::getkey($headers,'authorization', 'Bearer');
    
    $httpResponse = $tokenController->checkAndReturnResponse($token);    

    if ( is_null($httpResponse)) {

        $params = Utils::getAllParams($_GET, OutputsTypes::JSON);

        $httpResponse = $tagController->delete($params);

    }

}else{
    $httpResponse = $responsesController->error405();
}

echo json_encode($httpResponse);

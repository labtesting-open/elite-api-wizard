<?php

use Elitesports\Utils;

include __DIR__."/../vendor/autoload.php";


$userController = new \Elitesports\User();
$responsesController = new \Elitesports\Respuestas();
$tokenController = new \Elitesports\Token();

include('extras/headers.php');

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    $headers = apache_request_headers();    
    $token = Utils::getkey($headers,'authorization', 'Bearer');
    
    $httpResponse = $tokenController->checkAndReturnResponse($token);

    if ( is_null($httpResponse)) {        
        $httpResponse = $userController->getUserPlan($token);        
    }    

} else if($_SERVER['REQUEST_METHOD'] == "POST") {
    
    $httpResponse = $responsesController->error405();

}else if($_SERVER['REQUEST_METHOD'] == "PUT"){

    $httpResponse = $responsesController->error405();

}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){

    $httpResponse = $responsesController->error405();

}else{
    
    $httpResponse = $responsesController->error405();
}

echo json_encode($httpResponse);
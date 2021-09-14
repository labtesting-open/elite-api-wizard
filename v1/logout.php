<?php

include __DIR__."/../vendor/autoload.php";


$loginController = new \Elitesports\Login();
$responsesController = new \Elitesports\Respuestas();
$tokenController = new \Elitesports\Token();

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

header('content-type: application/json');


if ($_SERVER['REQUEST_METHOD'] == "GET") {

    $httpResponse = $responsesController->error405();
    echo json_encode($httpResponse); 

} else if($_SERVER['REQUEST_METHOD'] == "POST") {

    $headers = apache_request_headers();    
    $token = isset($headers['Token'])? $headers['Token']: null;    
    $httpResponse = $tokenController->checkAndReturnResponse($token);

    if ( is_null($httpResponse)) {        
        $httpResponse = $loginController->logOut($token);        
    }

    echo json_encode($httpResponse);

}else if($_SERVER['REQUEST_METHOD'] == "PUT"){

    $httpResponse = $responsesController->error405();
    echo json_encode($httpResponse); 

}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){

    $httpResponse = $responsesController->error405();
    echo json_encode($httpResponse); 

}else{
   
    $httpResponse = $responsesController->error405();
    echo json_encode($httpResponse); 

}
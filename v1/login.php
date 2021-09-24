<?php

include __DIR__."/../vendor/autoload.php";
include('extras/headers.php');

$loginController = new \Elitesports\Login();
$responsesController = new \Elitesports\Respuestas();


if ($_SERVER['REQUEST_METHOD'] == "GET") {

    $httpResponse = $responsesController->error405();
   

} else if($_SERVER['REQUEST_METHOD'] == "POST") {  
    
    $postBody = file_get_contents("php://input");

    $datosArray = $loginController->login($postBody);

    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }

    $httpResponse = $datosArray;       

}else if($_SERVER['REQUEST_METHOD'] == "PUT"){

    $httpResponse = $responsesController->error405();    

}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){

    $httpResponse = $responsesController->error405();

}else{
   
    $httpResponse = $responsesController->error405();
}

echo json_encode($httpResponse);
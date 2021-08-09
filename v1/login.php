<?php

include __DIR__."/../vendor/autoload.php";

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

header('content-type: application/json');

$_login = new \Elitesports\Login();
$_respuestas = new \Elitesports\Respuestas();


if($_SERVER['REQUEST_METHOD'] == "POST"){


    //recibir datos
    $postBody = file_get_contents("php://input");
    
    //enviar datos al manejador
    $datosArray = $_login->login($postBody);

    //retornar respuesta
   

    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }

    echo json_encode($datosArray);

}else{
    header('content-type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray); 
}

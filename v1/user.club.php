<?php

include __DIR__."/../vendor/autoload.php";

$_user_club = new \Elitesports\UserClub();
$_respuestas = new \Elitesports\Respuestas();

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

header('content-type: application/json');


if ($_SERVER['REQUEST_METHOD'] == "GET"){

    $datosArray = $_respuestas->error405();    
   

}else if($_SERVER['REQUEST_METHOD'] == "POST"){

    $postBody = file_get_contents("php://input");
    $datosArray = $_user_club->getOwnClub($postBody);

}else if($_SERVER['REQUEST_METHOD'] == "PUT"){

    $datosArray = $_respuestas->error405();

}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){

    $datosArray = $_respuestas->error405();

}else{
   
    $datosArray = $_respuestas->error405();
}

echo json_encode($datosArray);
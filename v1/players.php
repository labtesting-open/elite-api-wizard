<?php

use Elitesports\OutputsTypes;
use Elitesports\Utils;

include __DIR__."/../vendor/autoload.php";
include('extras/headers.php');

$playerController = new \Elitesports\Player();
$responsesController = new \Elitesports\Respuestas();
$tokenController = new \Elitesports\Token();


if ($_SERVER['REQUEST_METHOD'] == "GET") {

    $headers = apache_request_headers();    
    $token = Utils::getkey($headers,'authorization', 'Bearer');
    
    $httpResponse = $tokenController->checkAndReturnResponse($token);

    if ( is_null($httpResponse)) {
        
        $params = Utils::getAllParams($_GET, OutputsTypes::JSON);

        $httpResponse = $playerController->getTeamPlayersWithStatics($params, $token);

    }    

} else if($_SERVER['REQUEST_METHOD'] == "POST") {
    
    $headers = apache_request_headers();    
    $token = Utils::getkey($headers,'authorization', 'Bearer');
    
    $httpResponse = $tokenController->checkAndReturnResponse($token);

    if ( is_null($httpResponse)) {
        
        $httpResponse = $responsesController->error400('Data incorrect or incomplete');
        
        if( isset($_FILES['img_profile_url'])){

            if( is_uploaded_file($_FILES['img_profile_url']['tmp_name']) 
            && $_FILES['img_profile_url']['size'] <= 1024000
            && Utils::isImage($_FILES['img_profile_url']['type'])
            && $_FILES['img_profile_url']['error'] == UPLOAD_ERR_OK)
            {
                if(isset($_REQUEST['_method']) && $_REQUEST['_method'] == 'POST'){
                    $httpResponse = $playerController->addPlayer($_REQUEST, $_FILES['img_profile_url']);
                }
                if(isset($_REQUEST['_method']) && $_REQUEST['_method'] == 'PUT'){
                    $httpResponse = $playerController->addPlayer($_REQUEST, $_FILES['img_profile_url']);
                }
                               
            }else{
                $httpResponse = $responsesController->error400('Image type or size is incorrect');
            }
        }else{

            if(isset($_REQUEST['_method']) && $_REQUEST['_method'] == 'POST'){
                $httpResponse = $playerController->addPlayer($_REQUEST);
            }
            if(isset($_REQUEST['_method']) && $_REQUEST['_method'] == 'PUT'){
                //$httpResponse = $playerController->updatePlayer($_REQUEST);
            }

        }
        
    }

}else if($_SERVER['REQUEST_METHOD'] == "PUT"){

    $httpResponse = $responsesController->error405();

}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){

    $httpResponse = $responsesController->error405();

}else{
    
    $httpResponse = $responsesController->error405();
}

echo json_encode($httpResponse);
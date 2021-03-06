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
        
        $httpResponse = $responsesController->error400('Data incorrect or incomplete');
        
        if( isset($_FILES['img_team'])){

            if( is_uploaded_file($_FILES['img_team']['tmp_name']) 
            && $_FILES['img_team']['size'] <= 1024000
            && Utils::isImage($_FILES['img_team']['type'])
            && $_FILES['img_team']['error'] == UPLOAD_ERR_OK)
            {
                if(isset($_REQUEST['_method']) && $_REQUEST['_method'] == 'POST'){
                    $httpResponse = $teamController->addTeam($_REQUEST, $_FILES['img_team']);
                }
                if(isset($_REQUEST['_method']) && $_REQUEST['_method'] == 'PUT'){
                    $httpResponse = $teamController->updateTeam($_REQUEST, $_FILES['img_team']);
                }
                               
            }else{
                $httpResponse = $responsesController->error400('Image type or size is incorrect');
            }
        }else{

            if(isset($_REQUEST['_method']) && $_REQUEST['_method'] == 'POST'){
                $httpResponse = $teamController->addTeam($_REQUEST);
            }
            if(isset($_REQUEST['_method']) && $_REQUEST['_method'] == 'PUT'){
                $httpResponse = $teamController->updateTeam($_REQUEST);
            }

        }
        
    }


}else if($_SERVER['REQUEST_METHOD'] == "PUT"){

    $httpResponse = $responsesController->error405('Update method is available using POST');
   

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
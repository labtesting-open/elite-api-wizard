<?php

header("Access-Control-Allow-Headers: Authorization, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

header('content-type: application/json');

//header("Access-Control-Allow-Origin: "."http://localhost:3000");

header("Access-Control-Allow-Origin: *");

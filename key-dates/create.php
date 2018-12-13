<?php

header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db-class.php';

include_once '../entities/key_date.php';

$dbclass = new DBClass();
$connection = $dbclass->getConnection();

$keydate = new KeyDate($connection);

// get post data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->keydates) &&
    !empty($data->doubled) &&
    !empty($data->PersonID)
){

    // set product property values
    $keydate->keydates = $data->keydates;
    $keydate->doubled = $data->doubled;
    $keydate->PersonID = $data->PersonID;

    if($keydate->create()){ // User created successfully
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "date added."));
    }
    else{
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to add date."));
    }
} else { // tell the user data is incomplete
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable add date. Data is incomplete."));
}

?>
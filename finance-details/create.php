<?php

header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db-class.php';

include_once '../entities/finance_detail.php';

$dbclass = new DBClass();
$connection = $dbclass->getConnection();

$finDet = new FinanceDetail($connection);

// get post data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->rate) &&
    !empty($data->firstPayDay) &&
    !empty($data->PersonID)
){

    // set product property values
    $finDet->rate = $data->rate;
    $finDet->firstPayDay = $data->firstPayDay;
    $finDet->PersonID = $data->PersonID;

    if($finDet->create()){ // User created successfully
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "finance detail added."));
    }
    else{
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to add financial detail."));
    }
} else { // tell the user data is incomplete
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable add finance detail. Data is incomplete."));
}

?>
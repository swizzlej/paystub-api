<?php

header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db-class.php';

include_once '../entities/payper_data.php';

$dbclass = new DBClass();
$connection = $dbclass->getConnection();

$pData = new PayPerData($connection);

// get post data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->fromDate) &&
    !empty($data->toDate) &&
    !empty($data->total) &&
    !empty($data->overtime) &&
    !empty($data->tax) &&
    !empty($data->PersonID)
){

    // set product property values
    $pData->fromDate = $data->fromDate;
    $pData->toDate = $data->toDate;
    $pData->total = $data->total;
    $pData->overtime = $data->overtime;
    $pData->tax = $data->tax;
    $pData->PersonID = $data->PersonID;

    if($pData->create()){ // pay per added successfully
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Pay Period Data added."));
    }
    else{
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to add Pay Period Data.", "error" => $pData->stmtError));
    }
} else { // tell the user data is incomplete
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable add Pay Period Data. Data is incomplete."));
}

?>
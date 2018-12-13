<?php

header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db-class.php';

include_once '../entities/month_data.php';

$dbclass = new DBClass();
$connection = $dbclass->getConnection();

$mData = new MonthData($connection);

// get post data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->yearMonth) &&
    !empty($data->total) &&
    !empty($data->overtime) &&
    !empty($data->tax) &&
    !empty($data->PersonID)
){

    // set product property values
    $mData->yearMonth = $data->yearMonth;
    $mData->total = $data->total;
    $mData->overtime = $data->overtime;
    $mData->tax = $data->tax;
    $mData->PersonID = $data->PersonID;

    if($mData->create()){ // User created successfully
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "month Data added."));
    }
    else{
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to add month data."));
    }
} else { // tell the user data is incomplete
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable add month data. Data is incomplete."));
}

?>
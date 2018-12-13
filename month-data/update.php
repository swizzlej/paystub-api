<?php

header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db-class.php';

include_once '../entities/month_data.php';

$dbclass = new DBClass();
$connection = $dbclass->getConnection();

$mData = new MonthData($connection);

// get update data
$data = json_decode(file_get_contents("php://input"));

// set ID property of user to be edited
$mData->id = $data->id;

// set product property values
$mData->yearMonth = $data->yearMonth;
$mData->total = $data->total;
$mData->overtime = $data->overtime;
$mData->tax = $data->tax;
$mData->PersonID = $data->PersonID;

if($mData->update()){ // User created successfully
    // set response code - 200 updated
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "Month data was updated."));
}
else{
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Unable to update Month data.", "error" => $mData->stmtError));
}

?>
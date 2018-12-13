<?php

header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db-class.php';

include_once '../entities/payper_data.php';

$dbclass = new DBClass();
$connection = $dbclass->getConnection();

$pData = new PayPerData($connection);

// get update data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->id) &&
    !empty($data->fromDate) &&
    !empty($data->toDate) &&
    !empty($data->total) &&
    !empty($data->overtime) &&
    !empty($data->tax) &&
    !empty($data->PersonID)
){

    // set ID property of user to be edited
    $pData->id = $data->id;

    // set product property values
    $pData->fromDate = $data->fromDate;
    $pData->toDate = $data->toDate;
    $pData->total = $data->total;
    $pData->overtime = $data->overtime;
    $pData->tax = $data->tax;
    $pData->PersonID = $data->PersonID;

    if($pData->update()){ // payper updated successfully
        // set response code - 200 updated
        http_response_code(200);
    
        // tell the user
        echo json_encode(array("message" => "pay period data was updated."));
    }
    else{
        // set response code - 503 service unavailable
        http_response_code(503);
    
        // tell the user
        echo json_encode(array("message" => "Unable to update pay period data.", "error" => $pData->stmtError));
    }

} else { // tell the user data is incomplete
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable update Pay Period Data. Data is incomplete.", "total" => $data->id));
}

?>
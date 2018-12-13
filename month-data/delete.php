<?php

header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db-class.php';

include_once '../entities/month_data.php';

$dbclass = new DBClass();
$connection = $dbclass->getConnection();

$mData = new MonthData($connection);

// get data
$data = json_decode(file_get_contents("php://input"));

// set ID property of user to be deleted
$mData->id = $data->id;

if($mData->delete()){ // Date deleted successfully
    // set response code - 200 updated
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "month data deleted."));
}
else{
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Unable to delete month data.", "error" => $mData->stmtError));
}

?>
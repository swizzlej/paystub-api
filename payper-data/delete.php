<?php

header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db-class.php';

include_once '../entities/payper_data.php';

$dbclass = new DBClass();
$connection = $dbclass->getConnection();

$pData = new PayPerData($connection);

// get data
$data = json_decode(file_get_contents("php://input"));

// set ID property of pay period to be deleted
$pData->id = $data->id;

if($pData->delete()){ // pay period deleted successfully
    // set response code - 200 updated
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "pay period data deleted."));
}
else{
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Unable to delete pay period data.", "error" => $pData->stmtError));
}

?>
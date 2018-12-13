<?php

header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db-class.php';

include_once '../entities/finance_detail.php';

$dbclass = new DBClass();
$connection = $dbclass->getConnection();

$finDet = new FinanceDetail($connection);

// get update data
$data = json_decode(file_get_contents("php://input"));

// set ID property of user to be edited
$finDet->id = $data->id;

// set product property values
$finDet->rate = $data->rate;
$finDet->firstPayDay = $data->firstPayDay;
$finDet->PersonID = $data->PersonID;

if($finDet->update()){ // User created successfully
    // set response code - 200 updated
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "finance detail was updated."));
}
else{
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Unable to update finance detail.", "error" => $finDet->stmtError));
}

?>
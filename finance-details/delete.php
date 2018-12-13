<?php

header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db-class.php';

include_once '../entities/finance_detail.php';

$dbclass = new DBClass();
$connection = $dbclass->getConnection();

$finDet = new FinanceDetail($connection);

// get data
$data = json_decode(file_get_contents("php://input"));

// set ID property of user to be deleted
$finDet->id = $data->id;

if($finDet->delete()){ // Date deleted successfully
    // set response code - 200 updated
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "financial data deleted."));
}
else{
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Unable to delete financial data.", "error" => $kdate->stmtError));
}

?>
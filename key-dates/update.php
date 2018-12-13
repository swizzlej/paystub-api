<?php

header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db-class.php';

include_once '../entities/key_date.php';

$dbclass = new DBClass();
$connection = $dbclass->getConnection();

$kdate = new KeyDate($connection);

// get update data
$data = json_decode(file_get_contents("php://input"));

// set ID property of user to be edited
$kdate->id = $data->id;

// set product property values
$kdate->keydates = $data->keydates;
$kdate->doubled = $data->doubled;
$kdate->PersonID = $data->PersonID;

if($kdate->update()){ // User created successfully
    // set response code - 200 updated
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "date was updated."));
}
else{
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Unable to update date.", "error" => $kdate->stmtError));
}

?>
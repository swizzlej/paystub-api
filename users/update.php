<?php

header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db-class.php';

include_once '../entities/user.php';

$dbclass = new DBClass();
$connection = $dbclass->getConnection();

$user = new User($connection);

// get update data
$data = json_decode(file_get_contents("php://input"));

// set ID property of user to be edited
$user->id = $data->id;

// set product property values
$user->uname = $data->username;
$user->email = $data->email;
$user->pword = $data->pword;
$user->active = $data->active;

if($user->update()){ // User created successfully
    // set response code - 200 updated
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "User was updated."));
}
else{
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Unable to update User.", "error" => $user->stmtError));
}

?>
<?php

header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db-class.php';

include_once '../entities/user.php';

$dbclass = new DBClass();
$connection = $dbclass->getConnection();

$user = new User($connection);

// get post data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->username) &&
    !empty($data->email) &&
    !empty($data->pword) &&
    !empty($data->active)
){

    // set product property values
    $user->uname = $data->username;
    $user->email = $data->email;
    $user->pword = $data->pword;
    $user->active = $data->active;

    if($user->create()){ // User created successfully
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "User was created."));
    }
    else{
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create User."));
    }
} else { // tell the user data is incomplete
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create User. Data is incomplete."));
}

?>
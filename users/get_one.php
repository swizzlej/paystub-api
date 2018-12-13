<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db-class.php';
include_once '../entities/user.php';

$dbclass = new DBClass();
$connection = $dbclass->getConnection();

$user = new User($connection);

// set ID property of record to read
$user->id = isset($_GET['id']) ? $_GET['id'] : die();

$user->get_one();

if($user->username != null){

    // create array
    $user_arr = array(
        "id" =>  $user->id,
        "username" => $user->username,
        "email" => $user->email,
        "pword" => $user->pword,
        "active" => $user->active
 
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($user_arr);

} else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user product does not exist
    echo json_encode(array("message" => "User does not exist."));
}

?>
<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db-class.php';
include_once '../entities/key_date.php';

$dbclass = new DBClass();
$connection = $dbclass->getConnection();

$kdate = new KeyDate($connection);

// set ID property of record to read
$kdate->PersonalID = isset($_GET['PersonID']) ? $_GET['PersonID'] : die();

$kdate->get_user_date();

if($kdate->keydates != null){

    // create array
    $date_arr = array(
        "id" =>  $kdate->id,
        "keydates" => $kdate->keydates,
        "doubled" => $kdate->doubled,
        "PersonID" => $kdate->PersonID,
 
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($date_arr);

} else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user product does not exist
    echo json_encode(array("message" => "no dates found for this user."));
}

?>
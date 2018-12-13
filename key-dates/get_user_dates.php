<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db-class.php';
include_once '../entities/key_date.php';

$dbclass = new DBClass();
$connection = $dbclass->getConnection();

$kdate = new KeyDate($connection);

// set ID property of record to read
$kdate->PersonID = isset($_GET['PersonID']) ? $_GET['PersonID'] : die();

$stmt = $kdate->get_user_date();
$count = $stmt->rowCount();

if($count > 0){

    $date = array();
    $dates["body"] = array();
    $dates["count"] = $count;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $d  = array(
            "id" => $id,
            "keydates" => $keydates,
            "PersonID" => $PersonID,
            "doubled" => $doubled
        );

        array_push($dates["body"], $d);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($dates);

} else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user product does not exist
    echo json_encode(array("message" => "no dates found for this user.", "error" => $stmt->errorInfo()));
}

?>
<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db-class.php';
include_once '../entities/key_date.php';

$dbclass = new DBClass();
$connection = $dbclass->getConnection();

$kdate = new KeyDate($connection);

$stmt = $kdate->get();
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

    echo json_encode($dates);
} else {

    // set response code - 404 not found
    http_response_code(404);

    echo json_encode(
        array("body" => array(), "count" => 0)
    );
}

?>
<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db-class.php';
include_once '../entities/finance_detail.php';

$dbclass = new DBClass();
$connection = $dbclass->getConnection();

$finDet = new FinanceDetail($connection);

$stmt = $finDet->get();
$count = $stmt->rowCount();

if($count > 0){


    $detail = array();
    $details["body"] = array();
    $details["count"] = $count;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $d  = array(
            "id" => $id,
            "rate" => $rate,
            "firstPayDay" => $firstPayDay,
            "PersonID" => $PersonID
        );

        array_push($details["body"], $d);
    }

    // set response code - 200 OK
    http_response_code(200);

    echo json_encode($details);
} else {

    // set response code - 404 not found
    http_response_code(404);

    echo json_encode(
        array("body" => array(), "count" => 0)
    );
}

?>
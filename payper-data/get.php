<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db-class.php';
include_once '../entities/payper_data.php';

$dbclass = new DBClass();
$connection = $dbclass->getConnection();

$pData = new PayPerData($connection);

$stmt = $pData->get();
$count = $stmt->rowCount();

if($count > 0){


    $pDetail = array();
    $pDetails["body"] = array();
    $pDetails["count"] = $count;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $d  = array(
            "id" => $id,
            "fromDate" => $fromDate,
            "toDate" => $toDate,
            "total" => $total,
            "overtime" => $overtime,
            "tax" => $tax,
            "PersonID" => $PersonID
        );

        array_push($pDetails["body"], $d);
    }

    // set response code - 200 OK
    http_response_code(200);

    echo json_encode($pDetails);
} else {

    // set response code - 404 not found
    http_response_code(404);

    echo json_encode(
        array("body" => array(), "count" => 0)
    );
}

?>
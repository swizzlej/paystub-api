<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db-class.php';
include_once '../entities/user.php';

$dbclass = new DBClass();
$connection = $dbclass->getConnection();

$user = new User($connection);

$stmt = $user->get();
$count = $stmt->rowCount();

if($count > 0){


    $user = array();
    $users["body"] = array();
    $users["count"] = $count;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $u  = array(
            "id" => $id,
            "username" => $username,
            "email" => $email,
            "pword" => $pword,
            "active" => $active
        );

        array_push($users["body"], $u);
    }

    // set response code - 200 OK
    http_response_code(200);

    echo json_encode($users);
} else {

    // set response code - 404 not found
    http_response_code(404);

    echo json_encode(
        array("body" => array(), "count" => 0)
    );
}

?>
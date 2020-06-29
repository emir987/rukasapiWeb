<?php

$response = array();

require_once "../config/connect.php";

$id = $_POST['id'];

// get a pet from pet table
$result = $connect->query("DELETE FROM review WHERE id = '$id'");


if ($result) {
    // check for empty result


    $response["success"] = 1;
    $response["message"] = "Successfuly deleted";


    echo json_encode($response);
} else {
    // no product found
    $response["success"] = 0;
    $response["message"] = "Unsuccessfuly deleted";

    echo json_encode($response);
}
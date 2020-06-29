<?php

$response = array();
if (isset($_POST['petID'])) {
    $petID = $_POST['petID'];
} 

if (isset($_POST['name'])) {
    $name = $_POST['name'];
} 

require_once "../config/connect.php";

    $query = "UPDATE pet
                SET name = '$name'
                WHERE id = $petID;";

    $result = $connect->query($query);


if ($result) {
    // successfully inserted into database
    $response["petID"] = $petID;
    $response["name"] = $name;
    $response["success"] = "1";
    $response["message"] = "Successfuly updated name";

    echo json_encode($response);
}else {
    // required field is missing
    $response["petID"] = $petID;
    $response["name"] = $name;
    $response["success"] = "0";
    $response["message"] = "Error in giving name";

    echo json_encode($response);
}
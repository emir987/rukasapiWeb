<?php

$response = array();
if (isset($_POST['petID'])) {
    $petID = $_POST['petID'];
} 

if (isset($_POST['name'])) {
    $name = $_POST['name'];
} 

require_once "../config/connect.php";

    $query = "UPDATE new_name
                SET votes = votes + 1
                WHERE name = '$name';";

    $result = $connect->query($query);


if ($result) {
    // successfully inserted into database
    $response["petID"] = $petID;
    $response["name"] = $name;
    $response["success"] = "1";
    $response["message"] = "Successfuly voted";

    echo json_encode($response);
}else {
    // required field is missing
    $response["petID"] = $petID;
    $response["name"] = $name;
    $response["success"] = "0";
    $response["message"] = "Error vote";

    echo json_encode($response);
}
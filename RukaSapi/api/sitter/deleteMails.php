<?php
session_start();
$response = array();

require_once "../config/connect.php";
$id = $_POST['id'];


$query = "DELETE FROM request WHERE id = '$id'";

$result = $connect->query($query);

if ($result) {

    // successfully inserted into database
    $response["success"] = "1";
    $response["message"] = "Comment successfully posted.";

    echo json_encode($response);

} else {

    // failed to insert row
    $response["success"] = "0";
    $response["message"] = "Oops! An error occurred.";

    echo json_encode($response);
}

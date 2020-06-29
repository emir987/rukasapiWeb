<?php
session_start();
require_once "../config/connect.php";

$response = array();


$userID = $_SESSION['id'];
$sitterID = $_POST['sitterID'];


$query = "DELETE FROM favoritesitter WHERE userID = '$userID' && sitterID = '$sitterID'";

$result = $connect->query($query);

if ($result) {

    // successfully inserted into database

    $response["success"] = 1;
    $response["message"] = "Pet successfully unfavorited.";

} else {

    // failed to insert row

    $response["success"] = 0;
    $response["message"] = "Oops! An error occurred.";

}

echo json_encode($response);



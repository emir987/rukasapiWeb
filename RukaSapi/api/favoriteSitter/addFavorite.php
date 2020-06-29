<?php
session_start();
require_once "../config/connect.php";

$response = array();


$userID = $_SESSION['id'];
$sitterID = $_POST['sitterID'];


$query = "INSERT INTO favoritesitter (userID, sitterID) VALUES('$userID', '$sitterID')";

$result = $connect->query($query);

if ($result) {

    // successfully inserted into database

    $response["success"] = 1;
    $response["message"] = "Product successfully favorited.";

} else {

    // failed to insert row

    $response["success"] = 0;
    $response["message"] = "Oops! An error occurred.";

}

echo json_encode($response);



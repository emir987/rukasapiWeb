<?php
session_start();
require_once "../config/connect.php";

$response = array();

if (isset($_POST['userID'])){
    $userID = $_POST['userID'];
}else {
    $userID = $_SESSION['id'];
}
$petID = $_POST['petID'];


$query = "INSERT INTO cart (userID, petID) VALUES('$userID', '$petID')";

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



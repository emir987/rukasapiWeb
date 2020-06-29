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


$query = "SELECT * FROM cart WHERE userID = '$userID' AND petID = '$petID' ";

$result = $connect->query($query);

if ($result->num_rows > 0) {

    // successfully inserted into database

    $response["success"] = 1;
    $response["message"] = "Product not found.";

} else {

    // failed to insert row

    $response["success"] = 0;
    $response["message"] = "Product found";

}

echo json_encode($response);



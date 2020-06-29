<?php
require_once "../config/connect.php";

$response = array();
$userID = $_GET['userID'];

$query = "SELECT photo FROM users WHERE id = '$userID'";
//
$result = $connect->query($query);
$pht = $result->fetch_assoc();
$ph = $pht['photo'];
//
//if ($result) {
//
//    // successfully inserted into database
//    $response["success"] = "1";
//
//    echo json_encode($response);
//
//} else {
//
//    // failed to insert row
//    $response["success"] = "0";
//
//    echo json_encode($response);
//}
$response["success"] = $ph;

echo json_encode($response);


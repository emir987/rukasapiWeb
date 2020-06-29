<?php
session_start();
$response = array();

require_once "../config/connect.php";

$datetime = date_create()->format('Y-m-d H:i:s');
$message = $_POST['message'];
$sitterID = $_POST['sitterID'];
$start = $_POST['start'];
$end = $_POST['end'];
$breed = $_POST['breed'];

if (isset($_SESSION['id'])) {
    $userID = $_SESSION['id'];
}

if (isset($_POST['userID'])){
    $userID = $_POST['userID'];
}




$query = "INSERT INTO request (userID, sitterID, message, currentDate, strartDate, endDate, breed)
            VALUES('$userID', '$sitterID', '$message', '$datetime', '$start', '$end', '$breed')";

$result = $connect->query($query);

if ($result) {

    // successfully inserted into database
    $response["success"] = "1";
    $response["message"] = "Request successfully sent! ";

    echo json_encode($response);

} else {

    // failed to insert row
    $response["success"] = "0";
    $response["message"] = "Oops! An error occurred.";

    echo json_encode($response);
}

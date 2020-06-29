<?php
session_start();
$response = array();

require_once "../config/connect.php";

$datetime = date_create()->format('Y-m-d H:i:s');
$review = $_POST['review'];
$sitterID = $_POST['sitterID'];
$userID = $_SESSION['id'];
$query = "INSERT INTO review (reviewSitterID, reviewUserID, review, date) VALUES('$sitterID', '$userID', '$review', '$datetime')";

$result = $connect->query($query);

if ($result) {

    // successfully inserted into database
    $response["success"] = 1;
    $response["message"] = "Comment successfully posted.";

    echo json_encode($response);

} else {

    // failed to insert row
    $response["success"] = 0;
    $response["message"] = "Oops! An error occurred.";

    echo json_encode($response);
}
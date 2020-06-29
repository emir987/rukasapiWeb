<?php
session_start();
$response = array();

require_once "../config/connect.php";

$datetime = date_create()->format('Y-m-d H:i:s');
$comment = $_POST['comment'];
$petID = $_POST['petID'];
if (isset($_POST['userID'])) {
    $userID = $_POST['userID'];
} else {
    $userID = $_SESSION['id'];
}

if (!empty($comment)) {
    $query = "INSERT INTO comments(userID, petID, comment, date)
            VALUES('$userID', '$petID', '$comment', '$datetime')";

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
} else {
    $response["success"] = "0";
    $response["message"] = "Input comment.";

    echo json_encode($response);
}

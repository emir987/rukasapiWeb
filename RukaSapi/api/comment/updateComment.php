<?php
$response = array();

$id = $_POST['id'];
$comment = $_POST['comment'];
$datetime = date_create()->format('Y-m-d H:i:s');

// include db connect class
require_once "../config/connect.php";

if (!empty($comment)) {

    $result = $connect->query("UPDATE comments SET comment = '$comment', date = '$datetime' WHERE id = '$id'");

// check if row inserted or not
    if ($result) {
        $response["success"] = 1;
        $response["message"] = "Comment successfully updated.";

        echo json_encode($response);

    } else {
        $response["success"] = 0;
        $response["message"] = "Unsuccessful";

        echo json_encode($response);
    }
}else{
    $response["success"] = 0;
    $response["message"] = "Empty";

    echo json_encode($response);
}

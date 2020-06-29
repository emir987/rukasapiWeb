<?php
require_once "../config/connect.php";
$response = array();
$photo = $_POST['photoI'];

$query = "UPDATE users SET photo='$photo' WHERE id = 49";

$result = $connect->query($query);

if ($result) {
    // successfully inserted into database
    $response["success"] = "1";
} else {
    // failed to insert row
    $response["success"] = "0";
}
echo json_encode($response);


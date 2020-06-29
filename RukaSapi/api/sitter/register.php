<?php
session_start();
$response = array();
$error = false;

if (isset($_POST['dog'])){
    $dog = $_POST['dog'];
    $dog = (int)$dog;
}else{
    $dog = 0;
}

if (isset($_POST['cat'])){
    $cat = $_POST['cat'];
    $cat = (int)$cat;
}else{
    $cat = 0;
}


$imageURL = $_POST['imageURL'];
$imageURL = strip_tags($imageURL);
$imageURL = htmlspecialchars($imageURL);

$motivation = $_POST['motivation'];
$motivation = strip_tags($motivation);
$motivation = htmlspecialchars($motivation);

$info = $_POST['info'];
$info = strip_tags($info);
$info = htmlspecialchars($info);

$maxWeight = $_POST['maxWeight'];
$maxWeight = strip_tags($maxWeight);
$maxWeight = htmlspecialchars($maxWeight);

$price = $_POST['price'];
$price = strip_tags($price);
$price = htmlspecialchars($price);
$price = (int)$price;

$response['cat']  = $cat;
$response['dog']  = $dog;
$response['price'] = $price;
$response['maxw'] = $maxWeight;
$response['info'] = $info;
$response['motiva'] = $motivation;
$response['url']  = $imageURL;


$errorResponse = new stdClass();

$errorResponse->motivationMessage = "";
$errorResponse->imgURLMessage = "";
$errorResponse->infoMessage = "";
$errorResponse->maxWeightMessage = "";


//validate
if (empty($imageURL)) {
    $error = true;
    $errorResponse->imgURLMessage = "Please input url";
}
if (empty($motivation)) {
    $error = true;
    $errorResponse->motivationMessage = "Please input motivation message";
}
if (empty($info)) {
    $error = true;
    $errorResponse->infoMessage = "Please input info";
}

if (empty($maxWeight)) {
    $error = true;
    $errorResponse->maxWeightMessage = "Please input max weight";
}

$datetime = date_create()->format('Y-m-d H:i:s');
$response['error'] = $datetime;

require_once "../config/connect.php";


if (!$error) {



    $idUser = $_SESSION['id'];
    $idUser = (int)$idUser;
    $datetime = date_create()->format('Y-m-d H:i:s');



    $upit = $connect->prepare("INSERT INTO sitters (image, petWeightMax, mainMessage, info, dog, cat, price, date, idUser) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $upit->bind_param("ssssiiisi", $imageURL, $maxWeight,  $motivation, $info, $dog, $cat, $price, $datetime, $idUser);
    $result = $upit->execute();
    $upit->close();

    if ($result) {

        // successfully inserted into database
        $response["success"] = 1;
        $response["error"] = $errorResponse;


    } else {

        // failed to insert row
        $response["success"] = 0;
        $errorResponse->databaseError = "Oops! An error occurred.";
        $response["error"] = $errorResponse;

    }

} else {

    $response["error"] = $errorResponse;
    $response["success"] = 0;


}

echo json_encode($response);


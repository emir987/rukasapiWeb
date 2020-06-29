<?php
require_once "../config/connect.php";

$response = array();
$error = false;

// $photo = $_POST['photoI'];

$name = $_POST['name'];
$name = strip_tags($name);
$name = htmlspecialchars($name);

$surname = $_POST['surname'];
$surname = strip_tags($surname);
$surname = htmlspecialchars($surname);

$email = $_POST['email'];
$email = strip_tags($email);
$email = htmlspecialchars($email);

$passwordsss = $_POST['passwords'];
$passwordsss = strip_tags($passwordsss);
$passwordsss = htmlspecialchars($passwordsss);

$phone = $_POST['phone'];
$phone = strip_tags($phone);
$phone = htmlspecialchars($phone);

$address = $_POST['address'];
$address = strip_tags($address);
$address = htmlspecialchars($address);

$zip = $_POST['zip'];
$zip = strip_tags($zip);
$zip = htmlspecialchars($zip);

$errorResponse = new stdClass();

$errorResponse->passwordMessage = "";
$errorResponse->emailMessage = "";
$errorResponse->nameMessage = "";
$errorResponse->surnameMessage = "";
$errorResponse->phoneMessage = "";
$errorResponse->addressMessage = "";
$errorResponse->zipMessage = "";

//validate
if (empty($name)) {
    $error = true;
    $errorResponse->nameMessage = "Please input name";
}
if (empty($surname)) {
    $error = true;
    $errorResponse->surnameMessage = "Please input surname";
}
if (empty($email)) {
    $error = true;
    $errorResponse->emailMessage = "Please input email address";
}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $error = true;
    $errorResponse->emailMessage = "Invalid email address";
}
if (strlen($passwordsss) < 6) {
    $errorResponse->passwordMessage = "Please enter at least 6 characters.";
    $error = true;
}
if (empty($phone)) {
    $error = true;
    $errorResponse->phoneMessage = "Please input phone number";
}
if (empty($address)) {
    $error = true;
    $errorResponse->addressMessage = "Please input your address";
}
if (empty($zip)) {
    $error = true;
    $errorResponse->zipMessage = "Please input your address";
}



if (!$error) {

    $password = sha1($passwordsss);

    $upit = $connect->prepare("INSERT INTO users (name, surname, email, password, phone, address,zip) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $upit->bind_param("sssssss", $name, $surname, $email, $password, $phone, $address, $zip);
    $result = $upit->execute();
    $upit->close();

    if ($result) {

        // successfully inserted into database
        $response["success"] = "1";
        $response["errorMessage"] = $errorResponse;


    } else {

        // failed to insert row
        $response["success"] = "0";
        //$errorResponse->databaseError = "Oops! An error occurred.";
        $response["errorMessage"] = $errorResponse;

    }

} else {

    $response["errorMessage"] = $errorResponse;
    $response["success"] = "0";


}

echo json_encode($response);





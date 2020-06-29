<?php
session_start();
require_once "../config/connect.php";

$response = array();

if (isset($_POST['email']) && isset($_POST['password'])) {

    $error = false;

    $email = trim($_POST['email']);
    $email = htmlspecialchars(strip_tags($email));

    $password = $_POST['password'];
    $password = htmlspecialchars(strip_tags($password));

    $errorResponse = new stdClass();

    $errorResponse->passwordMessage = "";
    $errorResponse->emailMessage = "";


    if (empty($email)) {
        $response["success"] = 0;
        $error = true;
        $errorResponse->emailMessage = "Please input email address";
        $response['message'] = $errorResponse;
    }


    if (strlen($password) < 6) {
        $response["success"] = 0;
        $errorResponse->passwordMessage = "Please enter at least 6 characters.";
        $response['message'] = $errorResponse;
        $error = true;
    }

    if (!$error) {

        $password = sha1($password);



        $query = "select * from users where email = '$email' and password = '$password'";

        $result = $connect->query($query);
        $row = $result->fetch_assoc();
        if ($result->num_rows > 0) {

            if ($password == $row['password']) {
                $user = array();

                $response["loggedUserID"] = $row['id'];
                $_SESSION['id'] = $row['id'];
                $response["success"] = "1";
                $response["successMessage"] = "Login successful";
            }

        } else {
            $response["success"] = "0";
            $response["successMessage"] = "Login unsuccessful";
            $response['message'] = $errorResponse;
        }
    }

    echo json_encode($response);

}
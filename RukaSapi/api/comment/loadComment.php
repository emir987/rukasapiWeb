<?php

$response = array();

require_once "../config/connect.php";

$id = $_GET['id'];

$result = $connect->query("SELECT * FROM comments where petID='$id'");

if ($result->num_rows > 0) {

    $response["comments"] = array();

    while ($row = $result->fetch_assoc()) {

        $userID = $row['userID'];

        //Commentator
        $userSQL = $connect->query("SELECT * FROM users where id='$userID'");
        $rowUser = $userSQL->fetch_assoc();
        $user = array();
        $user["name"] = $rowUser["name"];
        $user["surname"] = $rowUser["surname"];
        $user["userID"] = $rowUser["id"];
        $user["surname"] = $rowUser["surname"];

        //comment
        $comment['id'] = $row['id'];
        $comment["commentator"] = $user;
        $comment["comment"] = $row["comment"];
        $comment["date"] = $row["date"];
        $comment["petID"] = $row['petID'];

        $time = strtotime($row["date"]);

        if ( $time < (time() - 172800) ) {
            $comment['day'] = 'two days ago';
        } elseif ( $time < (time() - 86400) ) {
            $comment['day'] = 'yesterday';
        }elseif ( $time == time()) {
            $comment['day'] = 'now';
        }


        if ($time < (time() - 28801)) {
            $comment['hours'] = 'no';
        }elseif ($time < (time() - 28800)) {
            $comment['hours'] = '8';
        }elseif ( $time < (time() - 25200) ) {
            $comment['hours'] = '7';
        }elseif ( $time < (time() - 21600) ) {
            $comment['hours'] = '6';
        }elseif ( $time < (time() - 18000) ) {
            $comment['hours'] = '5';
        }elseif ( $time < (time() - 14400) ) {
            $comment['hours'] = '4';
        }elseif ( $time < (time() - 10800) ) {
            $comment['hours'] = '3';
        }elseif ( $time < (time() - 7200) ) {
            $comment['hours'] = '2';
        }elseif ( $time < (time() - 3600) ) {
            $comment['hours'] = '1';
        }else{
            $comment['hours'] = 'less than an';
        }

        //push single comment into comments array
        array_push($response["comments"], $comment);
    }

    $response["success"] = "1";
    echo json_encode($response);

} else {
    $response["success"] = "0";
    $response["message"] = "No comments found";

    echo json_encode($response);
}
?>
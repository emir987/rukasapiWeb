<?php

$response = array();

require_once "../config/connect.php";

$id = $_GET['id'];

$result = $connect->query("SELECT * FROM review where reviewSitterID='$id'");

if ($result->num_rows > 0) {

    $response["reviews"] = array();

    while ($row = $result->fetch_assoc()) {

        $userID = $row['reviewUserID'];

        //Commentator
        $userSQL = $connect->query("SELECT * FROM users where id='$userID'");
        $rowUser = $userSQL->fetch_assoc();
        $user = array();
        $user["name"] = $rowUser["name"];
        $user["surname"] = $rowUser["surname"];
        $user["userID"] = $rowUser["id"];
        $user["image"] = $rowUser["photo"];

        //comment
        $review['id'] = $row['id'];
        $review["commentator"] = $user;
        $review["review"] = $row["review"];
        $review["date"] = $row["date"];
        $review["sitterID"] = $row['reviewSitterID'];

        $time = strtotime($row["date"]);

        if ( $time < (time() - 172800) ) {
            $review['day'] = 'two days ago';
        } elseif ( $time < (time() - 86400) ) {
            $review['day'] = 'yesterday';
        }elseif ( $time == time()) {
            $review['day'] = 'now';
        }


        if ($time < (time() - 28801)) {
            $review['hours'] = 'no';
        }elseif ($time < (time() - 28800)) {
            $review['hours'] = '8';
        }elseif ( $time < (time() - 25200) ) {
            $review['hours'] = '7';
        }elseif ( $time < (time() - 21600) ) {
            $review['hours'] = '6';
        }elseif ( $time < (time() - 18000) ) {
            $review['hours'] = '5';
        }elseif ( $time < (time() - 14400) ) {
            $review['hours'] = '4';
        }elseif ( $time < (time() - 10800) ) {
            $review['hours'] = '3';
        }elseif ( $time < (time() - 7200) ) {
            $review['hours'] = '2';
        }elseif ( $time < (time() - 3600) ) {
            $review['hours'] = '1';
        }else{
            $review['hours'] = 'less than an';
        }

        //push single comment into comments array
        array_push($response["reviews"], $review);
    }

    $response["success"] = 1;
    echo json_encode($response);

} else {
    $response['reviews'] = "";
    $response["success"] = 0;
    $response["message"] = "No comments found";

    echo json_encode($response);
}
?>
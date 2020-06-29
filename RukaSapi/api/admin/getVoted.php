<?php
session_start();

if (isset($_SESSION['id'])){
    $userID = $_SESSION['id'];
}else{
    $userID = 1;
}

$response = array();
require_once "../config/connect.php";

$query = "SELECT *, new_name.name as voted_name, pet.id as petID FROM pet INNER JOIN new_name ON new_name.petID = pet.id ORDER BY pet.id";

$result = $connect->query($query);

if ($result->num_rows > 0) {

    $response["pets"] = array();

    $counter = 1;
    $names = array();
    while ($row = $result->fetch_assoc()) {

        //store every of three names
        $name_vote = new stdClass;
        $name_vote->name = $row['voted_name'];
        $name_vote->votes = $row['votes'];


        array_push($names, $name_vote);

        if ($counter%3==0) {
            $pet = array();
            $pet["id"] = $row["petID"];
            $pet["name"] = $row["name"];
            $pet["breed"] = $row["breed"];
            $pet["color"] = $row["color"];
            $pet["weight"] = $row["weight"];
            $pet["height"] = $row["height"];
            $pet["age"] = $row["age"];
            $pet["ownerID"] = $row["ownerID"];
            $pet["image"] = $row["image"];
            $pet["description"] = $row["description"];
            $pet["category"] = $row["category"];
            $pet["date"] = $row['date'];
            $pet["filterWeight"] = $row['filterWeight'];
            $pet["names"] = $names;
            // push single third(distinct) pet and start storing three new names in array for a new pet
            array_push($response["pets"], $pet);
            $names = array();
            $counter = 0;
        }

        $counter++;
    }

    $response["success"] = $counter;
    echo json_encode($response);

} else {
    $response["success"] = 0;
    $response["message"] = "No pets found";

    echo json_encode($response);
}
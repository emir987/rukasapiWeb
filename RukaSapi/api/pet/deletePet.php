<?php

$response = array();

require_once "../config/connect.php";

if (isset($_GET["id"])) {
    $id = $_GET['id'];

    $result1 = $connect->query("SELECT * FROM pet WHERE id = '$id'");
    $data = $result1->fetch_assoc();

    $petData = new stdClass();

    $petData->name = $data["name"];
    $petData->breed = $data["breed"];
    $petData->color = $data["color"];
    $petData->weight = $data["weight"];
    $petData->height = $data["height"];
    $petData->age = $data["age"];
    $petData->ownerID = $data["ownerID"];
    $petData->image = $data["image"];
    $petData->description = $data["description"];
    $petData->category = $data["category"];
    $petData->date = $data["date"];
    $petData->filterWeight = $data["filterWeight"];

    $response["petData"] = $petData;

    // get a pet from pet table
    $result = $connect->query("DELETE FROM pet WHERE id = '$id'");


    if (!empty($result)) {
        // check for empty result


        $response["success"] = 1;
        $response["message"] = "Successfuly deleted";


        echo json_encode($response);
    } else {
        // no product found
        $response["success"] = 0;
        $response["message"] = "No product found";

        echo json_encode($response);
    }
} else {
    // no product found
    $response["success"] = 0;
    $response["message"] = "No product found";

    // echo no users JSON
    echo json_encode($response);
}
?>
<?php

$response = array();

require_once "../config/connect.php";

if (isset($_GET["id"])) {
    $id = $_GET['id'];

    // get a pet from pet table
    $result = $connect->query("SELECT * FROM pet WHERE id = '$id'");


    if (!empty($result)) {
        // check for empty result
        if ($result->num_rows > 0) {

            $result = $result->fetch_assoc();

            $pet = new stdClass();

            $pet->id = $result["id"];
            $pet->name = $result["name"];
            $pet->breed = $result["breed"];
            $pet->color = $result["color"];
            $pet->weight = $result["weight"];
            $pet->height = $result["height"];
            $pet->age = $result["age"];
            $pet->ownerID = $result["ownerID"];
            $pet->image = $result["image"];
            $pet->description = $result["description"];
            $pet->category = $result["category"];
            $pet->date = $result['date'];

            $owner = $result["ownerID"];

            $ownerResult = $connect->query("SELECT * FROM users WHERE id = '$owner'");
            $ownerResult = $ownerResult->fetch_assoc();

            $owner = new stdClass();
            $owner->name = $ownerResult['name'];
            $owner->surname = $ownerResult['surname'];
            $owner->address = $ownerResult['address'];
            $owner->email = $ownerResult['email'];
            $owner->phone = $ownerResult['phone'];

            $pet->owner = $owner;

            $response["success"] = "1";

            $response["pet"] = $pet;



            echo json_encode($response);
        } else {
            // no product found
            $response["success"] = "0";
            $response["message"] = "No pet found";

            echo json_encode($response);
        }
    } else {
        // no product found
        $response["success"] = "0";
        $response["message"] = "No product found";

        // echo no users JSON
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = "0";
    $response["message"] = "Required field(s) is missing";

    echo json_encode($response);
}
?>
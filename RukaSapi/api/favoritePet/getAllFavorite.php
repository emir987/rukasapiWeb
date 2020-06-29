<?php
session_start();
$response = array();
require_once "../config/connect.php";

if (isset($_POST['idUser'])){
    $idUser = $_POST['idUser'];
}

$idUser = $_SESSION['id'];

$queryGetFavorite = "SELECT petID FROM cart WHERE userID = '$idUser'";

$resultFav = $connect->query($queryGetFavorite);

$response["pets"] = array();

if ($resultFav->num_rows > 0) {


    while ($row1 = $resultFav->fetch_assoc()) {


        $petID = $row1['petID'];

        $query = "SELECT * FROM pet where id = '$petID'";

        $result = $connect->query($query);

        $row = $result->fetch_assoc();

        $pet = array();
        $id = $row["id"];
        $pet["id"] = $row["id"];
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


        // push single product into final response array
        array_push($response["pets"], $pet);
    }

    $response["success"] = "1";
    $response["message"] = "Success";
    echo json_encode($response);

} else {
    $response["success"] = "0";
    $response["message"] = "No pets found";

    echo json_encode($response);
}
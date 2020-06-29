<?php
$response = array();
require_once "../config/connect.php";

$id = $_GET['id'];

$result = $connect->query("SELECT * FROM sitters s INNER JOIN users u ON u.id = s.idUser AND s.idSitter = '$id'");
 $ajs = 'ss';

if (!empty($result)) {
    // check for empty result
    if ($result->num_rows > 0) {
        $result = $result->fetch_assoc();

        $sitter = new stdClass();

        $sitter->id = $result["idSitter"];
        $sitter->image = $result["image"];
        $sitter->name = $result["name"];
        $sitter->surname = $result["surname"];
        $sitter->phone = $result["phone"];
        $sitter->address = $result["address"];
        $sitter->dog = $result["dog"];
        $sitter->cat = $result["cat"];
        $sitter->weight = $result["petWeightMax"];
        $sitter->price = $result["price"];
        $sitter->info = $result["info"];
        $sitter->email = $result["email"];

        $date = $result['date'];
        $parts = explode('-', $date);
        $accYear = (int)$parts[0];
        $todayYear = (int)date("Y");
        $totalYears = $todayYear - $accYear;

        if ($totalYears == 0){
            $accMonth = (int)$parts[1];
            $todayMonth = (int)date("m");
            $totalMonths = $todayMonth - $accMonth;
            $sitter->month = $totalMonths;
            $sitter->years = false;
        }else{
            $sitter->years = $totalYears;
            $sitter->months = false;
        }

        $response["success"] = 1;
        $response["sitter"] = $sitter;

        echo json_encode($response);
    } else {
        // no product found
        $response["success"] = 0;
        $response["message"] = "No sitter found";

        echo json_encode($response);
    }
} else {
    // no product found
    $response["success"] = 0;
    $response["message"] = "No sitter found";

    // echo no users JSON
    echo json_encode($response);
}

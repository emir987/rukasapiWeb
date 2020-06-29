<?php
session_start();
$response = array();

require_once "../config/connect.php";

if (isset($_POST['id'])) {
    $idUser = $_POST['id'];
}
if (isset($_SESSION['id'])){
    $idUser = $_SESSION['id'];
}

$getSitter = $connect->query("SELECT * FROM sitters where idUser = '$idUser'");
$getSitterArray = $getSitter->fetch_assoc();
$sitterID = $getSitterArray['idSitter'];

$result = $connect->query("SELECT * FROM request where sitterID = '$sitterID'");


if ($result->num_rows > 0) {

    $response["requests"] = array();

    while ($row = $result->fetch_assoc()) {

        $userID = $row['userID'];

        //Request from
        $userSQL = $connect->query("SELECT * FROM users where id='$userID'");
        $rowUser = $userSQL->fetch_assoc();
        $user = array();
        $user["name"] = $rowUser["name"];
        $user["surname"] = $rowUser["surname"];
        $user["userID"] = $rowUser["id"];

        //request
        $request['id'] = $row['id'];
        $request["commentator"] = $user;
        $request["requestMessage"] = $row["message"];
        $request["date"] = $row["currentDate"];
        $request["start"] = $row['strartDate'];
        $request["end"] = $row['endDate'];
        $request["siterID"] = $row['sitterID'];
        $request["breed"] = $row['breed'];

        $sitterID = $row['sitterID'];

        //Request to
        $sitterSQL = $connect->query("SELECT * FROM sitters s, users u where idSitter='$sitterID' and u.id = s.idUser");
        $rowSitter = $sitterSQL->fetch_assoc();
        $sitter = array();
        $sitter["idUser"] = $rowSitter["idUser"];


        $sitter["surname"] = $rowSitter["surname"];
        $sitter["name"] = $rowSitter["name"];
        $sitter["userID"] = $rowSitter["id"];
        $request["sitter"] = $sitter;

        //push single comment into comments array
        array_push($response["requests"], $request);
    }

    $response["success"] = "1";
    echo json_encode($response);

} else {
    $response["success"] = "0";
    $response["message"] = "No comments found";

    echo json_encode($response);
}
?>
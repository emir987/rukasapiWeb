<?php
session_start();
$response = array();

if (isset($_SESSION['id'])){
    $userID = $_SESSION['id'];
}
require_once "../config/connect.php";

if (isset($_POST['userID'])){
    $userID = $_POST['userID'];
}
$location = $_POST['location'];

$weight = $_POST['weight'];
if (isset($_POST['types'])){
    $types = $_POST['types'];
    $types = json_decode($types);
}

if (isset($_POST['androidTypes'])){
    $types = $_POST['androidTypes'];
}

if ($types[0] && $types[1]){
    $query = "SELECT * FROM sitters s INNER JOIN users u ON u.id = s.idUser AND u.zip = '$location' AND s.petWeightMax > '$weight' GROUP BY u.id";
}elseif ($types[0] && !$types[1]){
    $query = "SELECT * FROM sitters s INNER JOIN users u ON u.id = s.idUser AND u.zip = '$location' AND s.petWeightMax > '$weight'  AND s.dog = '1' GROUP BY u.id";
}else{
    $query = "SELECT * FROM sitters s INNER JOIN users u ON u.id = s.idUser AND u.zip = '$location' AND s.petWeightMax > '$weight'  AND s.cat = '1' GROUP BY u.id";
}

$result = $connect->query($query);

if ($result->num_rows > 0) {

    $response["sitters"] = array();

    while ($row = $result->fetch_assoc()) {

        $sitter = array();

        $sitterID = $row["idSitter"];
        $sitter["id"] = $sitterID;
        $sitter["name"] = $row["name"];
        $sitter["surname"] = $row["surname"];
        $sitter["email"] = $row["email"];
        $sitter["phone"] = $row["phone"];
        $sitter["address"] = $row["address"];
        $sitter["price"] = $row["price"];
        $sitter["image"] = $row["image"];
        $sitter["mainMessage"] = $row["mainMessage"];

        $reviews = "SELECT review FROM review WHERE reviewSitterID = '$sitterID'";
        $reviewResult = $connect->query($reviews);
        $sitter['allReviews'] = array();
        while($rowReview = $reviewResult->fetch_assoc()){

            $eachReview = substr($rowReview['review'], 0,85);

            array_push($sitter['allReviews'], $eachReview);
        }



        $countFavQuery = "SELECT COUNT(*) as favs FROM favoritesitter WHERE sitterID = '$sitterID'";
        $countFavResult = $connect->query($countFavQuery);
        $rowSitter = $countFavResult->fetch_assoc();
        $sitter['favs'] = $rowSitter['favs'];

        $countQuery = "SELECT * from favoriteSitter WHERE sitterID = '$sitterID' and userID = '$userID'";
        $countResult = $connect->query($countQuery);

        $countReviewsQuery = "SELECT COUNT(*) as totalReviews, review from review WHERE reviewSitterID = '$sitterID'";
        $countReviewsQuery = $connect->query($countReviewsQuery);
        $rowReviews = $countReviewsQuery->fetch_assoc();
        $sitter['reviews'] = $rowReviews['totalReviews'];

        if ($countResult->num_rows >0){
            $sitter["favorite"] = 'yes';
        }else{
            $sitter["favorite"] = 'no';
        }

        // push single product into final response array
        array_push($response["sitters"], $sitter);
    }

    $response["success"] = "1";
    echo json_encode($response);

} else {
    $response["sitters"] = [];
    $response["success"] = "0";
    $response["message"] = "No sitters found";

    echo json_encode($response);
}
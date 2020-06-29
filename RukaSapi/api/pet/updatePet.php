<?php

$response = array();

// check for required fields
if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['breed']) && isset($_POST['color'])
    && isset($_POST['weight']) && isset($_POST['height']) && isset($_POST['age'])
    && isset($_POST['ownerID']) && isset($_POST['image']) && isset($_POST['description'])
    && isset($_POST['category'])) {

    $name = $_POST['name'];
    $breed = $_POST['breed'];
    $color = $_POST['color'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $age = $_POST['age'];
    $ownerID = $_POST['ownerID'];
    $description = $_POST['description'];
    $image = $_POST['image'];
    $category = $_POST['category'];
    $id = $_POST['id'];

    // include db connect class
    require_once "../config/connect.php";

    $result = $connect->query("UPDATE pet SET name = '$name', breed = '$breed', color = '$color'
                                , weight = '$weight', height = '$height', age = '$age', ownerID = '$ownerID'
                                , description = '$description', image = '$image', category = '$category'  WHERE id = '$id'");

    // check if row inserted or not
    if ($result) {
        // successfully updated
        $response["success"] = 1;
        $response["message"] = "Product successfully updated.";

        echo json_encode($response);

    } else {
        $response["success"] = 0;
        $response["message"] = "Unsuccessful";

        echo json_encode($response);
    }
} else {

    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";

    echo json_encode($response);
}
?>
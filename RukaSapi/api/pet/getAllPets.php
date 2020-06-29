<?php
session_start();
if (isset($_SESSION['id'])){
    $userID = $_SESSION['id'];
}else{
    $userID = 1;
}
$response = array();
require_once "../config/connect.php";

if (isset($_POST['counter'])) {
    $loadCounter = $_POST['counter'];
    $countQuery = "SELECT COUNT(*) as count FROM pet";
    $countResult = $connect->query($countQuery);
    $count = $countResult->fetch_assoc();
//stop loading if no more items left
    if ($loadCounter >= $count['count']) {
        $response['stopLoad'] = 1;
    }
}
if (isset($_POST['searchHint'])) {
    $searchHint = $_POST['searchHint'];
}

if (isset($_POST['weight'])) {
    $weight = $_POST['weight'];
    if ($weight == '1') {
        $weight = 1;
    }
}

if (isset($_POST['category'])) {
    $category = $_POST['category'];
    $category = json_decode($category);
}


if (isset($_POST['category'])) {
    $category = $_POST['category'];
    $category = json_decode($category);
}


if (is_null($category[0]) && is_null($category[1]) && is_null($category[2])) {
    $response["success"] = 0;
    $response["message"] = "Choose at least one category";
    echo json_encode($response);
    return;
}


$isAll = 0;
if (!is_null($category[0]) && !is_null($category[1]) && !is_null($category[2])) {
    $query = "SELECT * FROM pet";
    $isAll = 1;
} elseif (!is_null($category[0]) && !is_null($category[1])) {
    $query = "SELECT * FROM pet where (category like '$category[0]' or category like '$category[1]')";
    $isAll = 0;
} elseif (!is_null($category[0]) && !is_null($category[2])) {
    $query = "SELECT * FROM pet where (category like '$category[0]' or category like '$category[2]')";
    $isAll = 0;
} elseif (!is_null($category[1]) && !is_null($category[2])) {
    $query = "SELECT * FROM pet where (category like '$category[1]' or category like '$category[2]')";
    $isAll = 0;
} elseif (is_null($category[1]) && is_null($category[2])) {
    $query = "SELECT * FROM pet where category like '$category[0]'";
    $isAll = 0;
} elseif (is_null($category[0]) && is_null($category[2])) {
    $query = "SELECT * FROM pet where category like '$category[1]'";
    $isAll = 0;

} elseif (is_null($category[0]) && is_null($category[1])) {
    $query = "SELECT * FROM pet where category like '$category[2]'";
    $isAll = 0;

}

if (!empty($searchHint)) {
    if ($isAll == 1) {
        $query .= " WHERE (name LIKE '" . $searchHint . "%' OR breed LIKE '" . $searchHint . "%')";
        if ($weight != 1) {
            $query .= " AND filterWeight LIKE '$weight'";
        }
    } else {
        $query .= " AND (name LIKE '" . $searchHint . "%' OR breed LIKE '" . $searchHint . "%')";
        if ($weight != 1) {
            $query .= " AND filterWeight LIKE '$weight'";
        }
    }
} else {
    if ($weight != 1) {
        if ($isAll == 1) {
            $query .= " WHERE filterWeight LIKE '$weight'";
        } else {
            $query .= " AND filterWeight LIKE '$weight'";
        }
    }
}

if (isset($_POST['counter'])) {
    $query .= " ORDER BY id LIMIT $loadCounter";
}


$result = $connect->query($query);

if ($result->num_rows > 0) {

    $response["pets"] = array();

    while ($row = $result->fetch_assoc()) {

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

        $countQuery = "SELECT * from cart WHERE petID = '$id' and userID = '$userID'";
        $countResult = $connect->query($countQuery);
        if ($countResult->num_rows > 0) {
            $pet["favorite"] = 'yes';
        } else {
            $pet["favorite"] = 'no';
        }

        // push single pet into final response array
        array_push($response["pets"], $pet);
    }


    $response["newpets"] = array();

    $resultNewPets = $connect->query("SELECT p.* FROM pet p INNER JOIN newpets np ON np.petID = p.id AND np.userID = '$userID'");

    while ($row = $resultNewPets->fetch_assoc()) {

        $newPet = array();
        $id = $row["id"];
        $newPet["petNames"] = array();
        $petNames = $connect->query("SELECT new_name.name FROM new_name INNER JOIN pet ON pet.id = new_name.petID AND pet.id = $id ORDER BY new_name.choose");
        while ($petNamesRow = $petNames->fetch_assoc()) {
            array_push($newPet["petNames"], $petNamesRow['name']); 
        }
        $newPet["id"] = $row["id"];
        $newPet["name"] = $row["name"];
        $newPet["breed"] = $row["breed"];
        $newPet["color"] = $row["color"];
        $newPet["weight"] = $row["weight"];
        $newPet["height"] = $row["height"];
        $newPet["age"] = $row["age"];
        $newPet["ownerID"] = $row["ownerID"];
        $newPet["image"] = $row["image"];
        $newPet["description"] = $row["description"];
        $newPet["category"] = $row["category"];
        $newPet["date"] = $row['date'];
        $newPet["filterWeight"] = $row['filterWeight'];

        // push single new pet into final response array
        array_push($response["newpets"], $newPet);  
    }

    $response["success"] = 1;
    echo json_encode($response);

} else {
    $response["success"] = 0;
    $response["message"] = "No pets found";

    echo json_encode($response);
}
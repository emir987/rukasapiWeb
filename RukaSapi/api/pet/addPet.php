<?php

$response = array();


if (isset($_POST['name']) && isset($_POST['breed']) && isset($_POST['color'])
    && isset($_POST['weight']) && isset($_POST['height']) && isset($_POST['age'])
    && isset($_POST['ownerID']) && isset($_POST['image']) && isset($_POST['description'])
    && isset($_POST['category']) && isset($_POST['gender'])) {

    $name = $_POST['name'];
    $breed = $_POST['breed'];
    $color = $_POST['color'];
    $weight = $_POST['weight'];
    if ($weight < 5) $filterWeight = 'XS';
    elseif ($weight < 10) $filterWeight = 'S';
    elseif ($weight < 20) $filterWeight = 'M';
    elseif ($weight < 30) $filterWeight = 'L';
    elseif ($weight > 30) $filterWeight = 'XL';
    $height = $_POST['height'];
    $age = $_POST['age'];
    $ownerID = $_POST['ownerID'];
    $description = $_POST['description'];
    $image = $_POST['image'];
    $category = $_POST['category'];
    $gender = $_POST['gender'];

    $errorResponse = new stdClass();
    $isOk = true;
    $errorResponse->nameMessage = "";
    $errorResponse->breedMessage = "";
    $errorResponse->colorMessage = "";
    $errorResponse->weightMessage = "";
    $errorResponse->heightMessage = "";
    $errorResponse->imageMessage = "";
    $errorResponse->descriptionMessage = "";
    $errorResponse->categoryMessage = "";


    if (empty($breed)) {
        $isOk = false;
        $errorResponse->breedMessage = "Please input breed";
    }

    if (empty($color)) {
        $isOk = false;
        $errorResponse->colorMessage = "Please input color";
    }

    if (empty($weight)) {
        $isOk = false;
        $errorResponse->weightMessage = "Please input weight";
    }

    if (empty($height)) {
        $isOk = false;
        $errorResponse->heightMessage = "Please input height";
    }

    if (empty($image)) {
        $isOk = false;
        $errorResponse->imageMessage = "Please input image";
    }

    if (empty($description)) {
        $isOk = false;
        $errorResponse->descriptionMessage = "Please input description";
    }

    if (empty($category)) {
        $isOk = false;
        $errorResponse->categoryMessage = "Please input category";
    }

    if ($isOk) {

        require_once "../config/connect.php";

        $datetime = date_create()->format('Y-m-d H:i:s');

        if (isset($_POST['no-name'])) {
            $name = "No name";
        }

        $query = "INSERT INTO pet(name, breed, color, weight, height, age, ownerID, image, description, category, date, filterWeight, gender)
            VALUES('$name', '$breed', '$color', '$weight', '$height', '$age', '$ownerID', '$image', '$description', '$category', '$datetime', '$filterWeight', '$gender')";

        $result = $connect->query($query);


        if ($result) {
            
            // successfully inserted into database
            $response["success"] = "1";
            $response["message"] = "Product successfully created.";

            $queryPetID = "SELECT id FROM pet ORDER BY id DESC LIMIT 1";
            $resultPet = $connect->query($queryPetID);
            $idRow = $resultPet->fetch_assoc();
            $idPet =  $idRow["id"];

            //insert new pet for each user
            $query = "INSERT INTO newpets (petID, userID) 
                    SELECT $idPet, id FROM users";

            $connect->query($query);

            //ukoliko nema imena unesi 3 random predloga za glasanje
            if (isset($_POST['no-name'])) {

                if ($_POST['gender'] == 'male') {
                    $maleNames = array('Simba', 'Micko', 'Kiki', 'Frodo', 'Snupi', 'Mob', 'Loki', 'Han', 'Kasper', 'Bambi', 'Beni', 'Bendzi', 'Cezar', 'Dragon', 'Donat', 'Laki', 'Lex', 'Max', 'Zak');
                    for ($i=0; $i < 3; $i++) { 
                        $random_key=array_rand($maleNames);
                        $rand_name = $maleNames[$random_key];
                        unset($maleNames[$random_key]);
                        $upit = $connect->prepare("INSERT INTO new_name (petID, choose, name) VALUES (?, ?, ?)");
                        $upit->bind_param("iis", $idPet, $i, $rand_name);
                        $result1 = $upit->execute();
                        $upit->close();
                    }
                }else{
                    $femaleNames = array("Rilei", "Sasa", "Leksi", "Ema", "Megi", "Lala", "Ani", "Emili", "Gara", "Elis", "Lejdi", "Ani", "Deksi", "Kona", "Ela", "Mona", "Dona", "Penelopa", "Mona");
                    for ($i=0; $i < 3; $i++) { 
                        $random_key=array_rand($femaleNames);
                        $rand_name = $femaleNames[$random_key];
                        unset($femaleNames[$random_key]);
                        $upit = $connect->prepare("INSERT INTO new_name (petID, choose, name) VALUES (?, ?, ?)");
                        $upit->bind_param("iis", $idPet, $i, $rand_name);
                        $result2 = $upit->execute();
                        $upit->close();
                    }
                }
            }

            echo json_encode($response);

        } else {

            // failed to insert row
            $response["success"] = "0";
            $response["message"] = "Oops! An error occurred.";

            echo json_encode($response);
        }

    } else {
        // required field is empty
        $response["success"] = "0";
        $response["errorMessage"] = $errorResponse;
        $response["message"] = "Required field(s) is empty";

        echo json_encode($response);

    }
} else {
    // required field is missing
    $response["success"] = "0";
    $response["message"] = "Required field(s) is missing";

    echo json_encode($response);
}
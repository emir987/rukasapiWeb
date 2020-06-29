<?php
session_start();
require_once "api/config/connect.php";
if (!isset($_SESSION['id'])){
    header("Location:login.php");
}
?>

// get all products from products table
$loadCounter = $_POST['loadedNewCount'];

$result = $connect->query("SELECT *FROM pet LIMIT $loadCounter");


while ($row = $result->fetch_assoc()) {

    echo '<div class="col-lg-4 col-md-6 mb-4">';
    echo '<div class="card h-100-custom">';
    echo '<a href="#"><img class="card-img-top image-card" src="' . $row['image'] . '" alt="lea"><a/>';
    echo '<div class="card-body-custom">';
    echo '<h4 class="card-title">';
    echo '<a href="#">' . $row['name'] . '</a></h4>';
    $des = $row['description'];
    if (strlen($des) > 40) {
        $des = substr($des, 0, strpos($des, ' ', 80)) . '...';
    };
    echo '<p class="card-text">' . $des . '</p>';
    echo '</div>';
    echo '<div class="card-footer">';
    echo '<span id="publish">Publication date:</span>';
    echo '</div>';
    echo '</div>';
    echo '</div>';



}
echo '<div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100" style="background-color:rgba(47,147,31,0.35)">
                        <span class="span-custom-add">Add new pet</span>
                        <div class="product-item">
                            <div class="pi-pic" style="background-color:rgba(76,239,50,0.03)">
                                <img style="width: 264px;height: 250px;" id="slikaAdd" src="./res/images/add.png"
                                     alt=""
                                     onclick="expand()">
                            </div>
                        </div>
                    </div>

                </div>';
?>
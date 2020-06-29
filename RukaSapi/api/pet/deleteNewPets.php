<?php
require_once "../config/connect.php";

session_start();
if (isset($_SESSION['id'])){
    $userID = $_SESSION['id'];
}else{
    $userID = 1;
}

$response = array();

$result = $connect->query("DELETE FROM newpets WHERE userID = $userID");
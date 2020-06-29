<?php
session_start();
if (!isset($_SESSION['id'])){
    header("Location:login.php");
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="css/appointmentCss.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/nav.css">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

</head>
</head>

<body>

<style>
    .banner-appointment{
        position:absolute;
        bottom:20px;
        left: 50%;
        transform: translateX(-50%);
        text-shadow: 2px 2px 5px white;
        font-size: 4.5rem;
        font-weight:400;
    }
</style>

    <!--navigation menu-->
    <nav class="navbar navbar-expand-lg navbar-light bg-custom fixed-top p-0">
            <a class="navbar-brand nav-item nav-link" href="index.php">
                <img class="w-75" style="text-align: center;" src="res/images/logotip.png" alt="">
            </a>

            <button id="toggle-hamburger" class="navbar-toggler my-2 ml-auto" tycustom data-toggle="collapse"
                data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false"
                aria-label="Toggle navigation">
                <div id="nav-icon1">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>

            <div class="collapse navbar-collapse mobile-nav" id="navbarTogglerDemo03">
                <div class="navbar-nav m-auto align-items-center justify-content-center">
                    <div id="nav-links-left" class="d-flex px-4 ml-n3">
                        <a class="nav-item nav-link from-left" href="donate.php">DONACIJE</a>
                        <?php

                        $id = $_SESSION['id'];
                        include 'api/config/connect.php';
                        $isSitterQuery = "SELECT * from sitters WHERE idUser = '$id'";
                        $isSitter = $connect->query($isSitterQuery);
                        if ($isSitter->num_rows == 0 && $id != 1){
                            echo '<a class="nav-item nav-link from-left" href="sitter.php">ŠETAJ LJUBIMCE</a>';
                        }else if($id == 1){
                            echo '<a class="nav-item nav-link from-left" href="dashboard.php">DASHBOARD</a>';
                        }
                        else{
                            echo '<a class="nav-item nav-link from-left" href="myprofilSitter.php">PROFIL</a>';
                        }
                        ?>
                    </div>
                    <a class="nav-link logo-nav-item" style="width: 130px;" href="index.php">
                        <img class="logo" style="text-align: center;" src="res/images/logotip.png" alt="">
                    </a>
                    <div id="nav-links-right" class="d-flex px-4">
                        <a class="nav-item nav-link from-left" href="appointment.php">USLUGE</a>
                        <a class="nav-item nav-link from-left" href="kontakt.html">O NAMA</a>
                    </div>
                </div>
            </div>

            <a href="favourites.php" class="favourites mx-3">
                <img class="logo" style="width: 40px;" src="res/images/dogHeart.svg" alt="">
            </a>

            <div class="dropdown profil-drop mx-3">
                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" style="width: 36px;height: 36px;"></button>

                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="api/user/logout.php">Logout</a>
                    <a class="dropdown-item" href="#">My profile</a>
                </div>
            </div>
        </nav>
                  
         <div class="position-relative mt-5">
                <img class="d-block w-100" src="res/images/bgwlk.jpg" alt="Frist Slide">
                <div class="">
                    <h1 class="banner-appointment">Šetanje ljubimaca</h1>
                </div>
        </div>

    <!--form-->
    <div class="container-fluid">
        <div class="row mt-5">
            <div class="col-lg-3 fixme">
                <form>

                    <!--                location-->
                    <div class="form-group">
                        <label for="location">Lokacija</label>
                        <input oninput="findSitters()" type="text" class="form-control" id="location"
                            placeholder="ZIP">
                    </div>

                    <!--                start date-->
                    <div class="form-group">
                        <label for="startDateID">Početak</label>
                        <input oninput="updateMin();findSitters()" id="startDateID" type="date" name="startDate"
                            max="2021-12-31" class="form-control">
                    </div>

                    <!--                end date-->
                    <div class="form-group">
                        <label for="endDateID">Kraj</label>
                        <input oninput="findSitters()" id="endDateID" type="date" name="endDate" min="1000-01-01"
                            class="form-control">
                    </div>

                    <!--                pet type-->
                    <div class="form-group">
                        <label class="form-row">Tip ljubimca</label>
                        <div class="form-check form-check-inline">
                            <input checked name="type" onchange="getTypes()" class="form-check-input" type="checkbox"
                                id="typeCheckbox1" value="1">
                            <label class="form-check-label" for="typeCheckbox1">Pas</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input checked name="type" onchange="getTypes()" class="form-check-input" type="checkbox"
                                id="typeCheckbox2" value="1">
                            <label class="form-check-label" for="typeCheckbox2">Macka</label>
                        </div>
                    </div>

                    <!--                pet size-->
                    <div class="form-group">
                        <label class="form-row">Max težina(kg)</label>
                        <label class="radio-inline mr-lg-2"><input checked value="0" onchange="getWeight()" type="radio"
                                name="sizeRadio">10</label>
                        <label class="radio-inline mr-lg-2"><input value="10" onchange="getWeight()" type="radio"
                                name="sizeRadio">20</label>
                        <label class="radio-inline mr-lg-2"><input value="20" onchange="getWeight()" type="radio"
                                name="sizeRadio">30</label>
                        <label class="radio-inline mr-lg-2"><input value="30" onchange="getWeight()" type="radio"
                                name="sizeRadio">30+</label>
                    </div>

                </form>
            </div>
            <div class="col-lg-1">
                <div class="vl mt-n5"></div>
            </div>
            <div class="row" id="showMore"></div>
            <!--        Pet sitters-->
            <div id="ss" class="col-lg-8">
                <div class="row" id="sitters">
                    <h4 class="text-center col-lg-12">Nismo pronašli nijednog radnika koji odgovara vašem kriterijumu.</h4>
                    <h6 class="text-center col-lg-12">Pokušajte da promjenite kriterijum ili promijenite lokaciju.</h6>
                </div>
            </div>
        </div>
    </div>


    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="js/custom-appointment.js"></script>

</body>

</html>
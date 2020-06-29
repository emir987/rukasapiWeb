<?php
session_start();
if (!isset($_SESSION['id'])) {
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
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/custom.css">
</head>

<body onload="f()">

<style>
    .obrisi{
        cursor: pointer;
        border-radius: 50%;
        padding: 3px;
        border: 1px solid transparent;
        transition: all .3s ease;
    }

    .obrisi:hover{
        border: 1px solid #ff8c8c;
        background-color: #fff4f4;
        transform:scale(1.08)
    }
</style>


<!--navigation menu-->
<header>
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
                <div id="nav-links-left" class="d-flex px-4">
                    <a class="nav-item nav-link from-left" href="donate.php">DONACIJE</a>
                    <?php

                    $id = $_SESSION['id'];
                    include 'api/config/connect.php';
                    $isSitterQuery = "SELECT * from sitters WHERE idUser = '$id'";
                    $isSitter = $connect->query($isSitterQuery);
                    if ($isSitter->num_rows == 0){
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
            
    <div class="banner mb-5">
        <img src="res/images/bannerTop.png" width="100%" height=100% alt="">
        <h1 class="text-center naslov">Poruke</h1>
    </div>
</header>


<div class="container">
    <table class="table table-condensed table-hover">
        <tbody id="fillMe">

        </tbody>
    </table>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>

<script>

    function f() {

        var fillMe = document.getElementById('fillMe');

        var http = new XMLHttpRequest();
        var method = "GET";
        var url = "api/admin/readMails.php?";
        var asynchronous = true;

        http.open(method, url, asynchronous);
        http.send();

        http.onload = function () {
            var data = JSON.parse(this.responseText);
            console.log(data);
            var messages = data.requests || [];
            html = "";

            for (var a = 0; a < messages.length; a++) {

                let shortMessage = messages[a].requestMessage.substr(0, 58);
                shortMessage = shortMessage.substr(0, Math.min(shortMessage.length, shortMessage.lastIndexOf(" "))) + "...";

                var formattedDateSecond = messages[a].date.substring(0, 10);
                var formattedDate= formattedDateSecond + " at " + messages[a].date.substring(10, 16)  + 'h';

                html += '<tr >\n' +
                    '            <td onclick="showMessage(' + messages[a].id + ')"><strong>' + messages[a].commentator.name + " " + messages[a].commentator.surname + '</strong></td>\n' +
                    '            <td onclick="showMessage(' + messages[a].id + ')" id="messageHere"><span>' + shortMessage + '</span></td>\n' +
                    '            <td onclick="showMessage(' + messages[a].id + ')"><strong>' + formattedDate + '</strong></td>\n' +
                    '            <td style="text-align:end"><img onclick="deleteRequest(' + messages[a].id + ')" class="obrisi" src="https://img.icons8.com/material/24/000000/delete-forever--v2.png"/></td>\n' +
                    '        </tr>' +
                    '<tr style="display: none" id="showMessage' + messages[a].id + '">' +
                    '<td id=""  colspan="3"><span><b>Start:</b> ' + messages[a].start + '</span><span class="ml-5"><b>End: </b>' + messages[a].end + '</span><br><br><b>Breed: </b> ' + messages[a].breed + ' <br><br><b>Message:</b> ' + messages[a].requestMessage + ' </td>' +
                    '</tr>';


            }


            fillMe.innerHTML = html;

        }
    }

    function deleteRequest(id) {

        var http = new XMLHttpRequest();
        var method = "POST";
        var url = "api/sitter/deleteMails.php";
        var asynchronous = true;
        http.open(method, url, asynchronous);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.send('id=' + id);

        http.onload = function () {
            var data = JSON.parse(this.responseText);
            console.log(data);
            f();
        }

    }


    function showMessage(id) {
        var td = document.getElementById('showMessage' + id);
        if (td.style.display === 'none') {
            td.style.display = 'table-row';
        } else {
            td.style.display = 'none';
        }
    }


</script>

</body>
</html>

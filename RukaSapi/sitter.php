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

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">


</head>
<body class="bg-register" style="overflow-x:hidden">

<div class="row d-flex justify-content-center animated fadeIn delay-2s">

        <div class="col-lg-7 col-md-8 col-sm-11 col-11 text-center mt-5">


            <form id="becomeForm" action="api/sitter/register.php" method="post" class="form-container-reg">
                <h1 style="text-align: center; color: rgb(255,241,243)">BECOME A SITTER</h1>

                <div class="form-group">
                    <label for="motivation" class="login-font">Motivation message</label>
                    <input name="motivation" type="text" class="form-control" id="motivation" autocomplete="off">
                    <span class="text-danger" id="motivationError"></span>
                </div>
                <div class="form-group">
                    <label for="imageURL" class="login-font">Image URL</label>
                    <input name="imageURL" type="text" class="form-control" id="imageURL" autocomplete="off">
                    <span class="text-danger" id="imageURLError"></span>
                </div>
                <div class="form-group">
                    <label for="infoReg" class="login-font">Info</label>
                    <textarea name="info" class="form-control" id="infoReg" autocomplete="off"></textarea>
                    <span class="text-danger" id="infoRegError"></span>
                </div>
                <div class="form-group">
                    <label for="maxPetWeigh" class="login-font">Max pet weight</label>
                    <input name="maxWeight" type="text" class="form-control" id="maxWeight">
                    <span class="text-danger" id="maxWeightError"></span>
                </div>
                <div class="form-group">
                    <label for="price" class="login-font">Price per walk</label>
                    <input name="price" type="text" class="form-control" id="price">
                    <span class="text-danger" id="maxWeightError"></span>
                </div>
                                pet type
                <div class="form-group">
                    <label class="form-check-inline login-font">Pet type</label>
                    <div class="form-check form-check-inline">
                        <input checked name="dog" onchange="getTypes()" class="form-check-input" type="checkbox"
                               id="dogCheck" value="1">
                        <label class="form-check-label" for="dogCheck">Dog</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input checked name="cat" onchange="getTypes()" class="form-check-input" type="checkbox"
                               id="catCheck" value="1">
                        <label class="form-check-label" for="catCheck">Cat</label>
                    </div>
                </div>
                <button name="submit" onclick="becomeSitter()" style="margin: 30px auto 0 auto;" type="button"
                        class="btn btn-warning btn-block login-font">
                    JOIN
                </button>
            </form>

        </div>
</div>

<!-- Bootstrap core JavaScript -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script>

    function becomeSitter() {

        var form = document.getElementById('becomeForm');
        var formData = new FormData(form);

        var motivationError = document.getElementById('motivationError');
        var imageURLError = document.getElementById('imageURLError');
        var infoRegError = document.getElementById('infoRegError');
        var maxWeightError = document.getElementById('maxWeightError');

        var http = new XMLHttpRequest();
        var method = "POST";
        var url = 'api/sitter/register.php';
        var asynchronous = true;

        http.open(method, url, asynchronous);
        http.send(formData);


        http.onload = function () {
            var data = JSON.parse(this.responseText);
            console.log(data);


            if (data.success === 1) {
                window.alert('Bravo');
                location.href = 'appointment.php';
            } else {
                motivationError.innerText = data.error.motivationMessage;
                imageURLError.innerText = data.error.imgURLMessage;
                infoRegError.innerText = data.error.infoMessage;
                maxWeightError.innerText = data.error.maxWeightMessage;
            }
        }
    }
</script>
</body>
</html>
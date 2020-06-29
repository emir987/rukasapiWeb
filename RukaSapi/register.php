<?php
session_start();
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

<div class="row d-flex justify-content-center animated fadeIn delay-2s w-100">

    <div class="col-lg-7 col-md-8 col-sm-11 col-11 text-center mt-5">


        <form id="registerForm" action="api/user/register.php" method="post" class="form-container-reg">
            <h1 style="text-align: center; color: rgb(255,241,243)">REGISTER</h1>

            <div class="form-group">
                <label for="nameRegister" class="login-font">Name</label>
                <input name="name" type="text" class="form-control" id="nameRegister" autocomplete="off">
                <span class="text-danger" id="nameError"></span>
            </div>
            <div class="form-group">
                <label for="surnameRegister" class="login-font">Surname</label>
                <input name="surname" type="text" class="form-control" id="surnameRegister" autocomplete="off">
                <span class="text-danger" id="surnameError"></span>
            </div>
            <div class="form-group">
                <label for="emailRegister" class="login-font">Email</label>
                <input name="email" type="email" class="form-control" id="emailRegister" autocomplete="off">
                <span class="text-danger" id="emailError"></span>
            </div>
            <div class="form-group">
                <label for="passwordRegister" class="login-font">Password</label>
                <input name="passwords" type="password" class="form-control" id="passwordRegister">
                <span class="text-danger" id="passwordError"></span>
            </div>
            <div class="form-group">
                <label for="phoneRegister" class="login-font">Phone</label>
                <input name="phone" type="number" class="form-control" id="phoneRegister">
                <span class="text-danger" id="phoneError"></span>
            </div>
            <div class="form-group">
                <label for="addressRegister" class="login-font">Address (home-city-country)</label>
                <input name="address" type="text" class="form-control" id="addressRegister" autocomplete="off">
                <span class="text-danger" id="addressError"></span>
            </div>
            <div class="form-group">
                <label for="addressRegister" class="login-font">ZIP</label>
                <input name="zip" type="text" class="form-control" id="zipRegister" autocomplete="off">
                <span class="text-danger" id="zipError"></span>
            </div>

            <button name="submit" onclick="register()" style="margin: 30px auto 0 auto;" type="button"
                    class="btn btn-warning btn-block login-font">
                REGISTER
            </button>
            <div style="margin-top: 35px">Already have an account? <a href="login.php">Log in</a></div>
        </form>

    </div>
</div>

<!-- Bootstrap core JavaScript -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script>

    function register() {

        var form = document.getElementById('registerForm');
        var formData = new FormData(form);

        var emailError = document.getElementById('emailError');
        var nameError = document.getElementById('nameError');
        var passwordError = document.getElementById('passwordError');
        var surnameError = document.getElementById('surnameError');
        var phoneError = document.getElementById('phoneError');
        var addressError = document.getElementById('addressError');
        var addressError = document.getElementById('zipError');


        var http = new XMLHttpRequest();
        var method = "POST";
        var url = 'api/user/register.php';
        var asynchronous = true;

        http.open(method, url, asynchronous);
        http.send(formData);


        http.onload = function () {
            var data = JSON.parse(this.responseText);
            console.log(data);


            if (data.success === 1) {
                window.alert('Bravo');
                location.href = 'login.php';
            } else {
                nameError.innerText = data.errorMessage.nameMessage;
                surnameError.innerText = data.errorMessage.surnameMessage;
                emailError.innerText = data.errorMessage.emailMessage;
                passwordError.innerText = data.errorMessage.passwordMessage;
                phoneError.innerText = data.errorMessage.phoneMessage;
                addressError.innerText = data.errorMessage.addressMessage;
                zipError.innerText = data.errorMessage.zipMessage;
            }
        }
    }
</script>

</body>
</html>




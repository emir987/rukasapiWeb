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
<body class="bg-login">

<div class="container-fluid animated fadeIn">
    <div class="row">
        <div class="col-lg-3 col-md-2"></div>
        <div class="col-lg-6 col-md-8 col-sm-12 col-12">

            <form id="loginForm" class="mt-5 p-5 form-border">
                <div class="form-group">
                    <label id="checkEmail" for="email" class="login-font">Email</label>
                    <input name="email" type="email" class="form-control" id="email" placeholder="Email">
                    <span id="emailError" class="text-danger"></span>
                </div>
                <div class="form-group">
                    <label id="checkPw" for="password" class="login-font">Password</label>

                    <input name="password" type="password" class="form-control" id="password"
                           placeholder="Password">
                    <span id="passwordError" class="text-danger"></span>
                </div>

                <button onclick="submitFormLogin()" name="submit" style="margin: 30px auto 0 auto;" type="button"
                        class="btn btn-success btn-block login-font">LOGIN
                </button>
                <button onclick="window.open('register.php','_self')" style="margin: 10px auto 0 auto;" type="button"
                        class="btn btn-outline-warning btn-block login-font">REGISTER
                </button>
            </form>

        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="js/custom-login.js"></script>


</body>
</html>




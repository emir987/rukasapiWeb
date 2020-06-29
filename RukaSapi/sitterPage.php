<?php
session_start();
if (!isset($_SESSION['id'])){
    header("Location:login.php");
}

$id = $_GET["id"];
?>
<style>
html {
    scroll-behavior: smooth;
}
</style>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Blog Post - Start Bootstrap Template</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/nav.css" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="css/blog-post.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">


</head>

<body onload="f()">

    <!-- Navigation -->
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


    <!-- Page Content -->
    <div class="container">

        <div class="row  mt-4">

            <!-- Post Content Column -->
            <div class="col-md-12  col-sm-12">

                <div class="col-lg-12">
                    <!-- Title -->
                    <div class="row">
                        <div class="col-lg-6">
                            <h1 id="sitterName" class="mt-4"></h1>
                        </div>
                        <div class="col-lg-6">
                            <div class="modal fade" id="modalContactForm" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header text-center">
                                            <h4 class="modal-title w-100 font-weight-bold">Send request</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body mx-3">
                                            <div class="md-form mb-2">
                                                <i class="fas fa-user prefix grey-text"></i>
                                                <label data-error="wrong" data-success="right" for="startDate">Start
                                                    date</label>
                                                <input type="date" id="startDate" class="form-control validate">
                                            </div>

                                            <div class="md-form mb-2">
                                                <i class="fas fa-envelope prefix grey-text"></i>
                                                <label data-error="wrong" data-success="right" for="endDate">End
                                                    date</label>
                                                <input type="date" id="endDate" class="form-control validate">
                                            </div>

                                            <div class="md-form mb-2">
                                                <i class="fas fa-tag prefix grey-text"></i>
                                                <label data-error="wrong" data-success="right" for="dogBreed">Dog
                                                    breed</label>
                                                <input type="text" id="dogBreed" class="form-control validate">
                                            </div>

                                            <div class="md-form">
                                                <i class="fas fa-pencil prefix grey-text"></i>
                                                <label data-error="wrong" data-success="right" for="messageID">Your
                                                    message</label>
                                                <textarea type="text" id="messageID" class="md-textarea form-control"
                                                    rows="4"></textarea>
                                            </div>

                                        </div>
                                        <div class="modal-footer d-flex justify-content-center">
                                            <button class="btn btn-secondary" onclick="sendRequest()">Send <i
                                                    class="fas fa-paper-plane-o ml-1"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <a href="" class="btn btn-secondary btn-rounded mb-4 float-right mt-4"
                                    data-toggle="modal" data-target="#modalContactForm">SEND REQUEST</a>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>

                <div class="row">
                    <!-- Preview Image -->
                    <div class="col-lg-5 col-md-4 col-sm-12">
                        <img id="sitterPhoto" class="img-fluid rounded img-responsive" src="http://placehold.it/900x300"
                            alt="">
                    </div>
                    <div class="col-lg-7 col-md-8 col-sm-12">
                        <div id="sitterInfos"></div>
                        <p id="sitterInfo"></p>

                    </div>
                </div>
                <hr>


                <!-- Comments Form -->
                <div class="card my-4">
                    <h5 class="card-header">Leave a Review:</h5>
                    <div class="card-body">
                        <form id="reviewForm" method="post" action="">
                            <div class="form-group">
                                <textarea name="review" id="addComment" class="form-control" rows="3"></textarea>
                            </div>

                            <!--                        <input name="petID" type="hidden" value="-->
                            <?php //echo $_GET['id'] ?>
                            <!--">-->
                            <button type="button" onclick="submitFormReview()" class="btn btn-success">Submit</button>
                        </form>
                    </div>
                </div>

                <div id="comments"></div>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Ruka Sapi</p>
        </div>
        <!-- /.container -->
    </footer>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.js"></script>

    <script>
    var id = <?php echo $_GET["id"] ?>;
    var userID = <?php echo $_SESSION['id'] ?>;
    </script>

    <script src="js/custom-sitterPage.js" type="text/javascript"></script>
    <script>
    $(document).ready(function() {
        if (window.location.hash) {
            var hash = window.location.hash;
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 500);
        }
    });
    </script>

    <script>
    <?php
    if (isset($startDate)) {
        $startDate = $_GET['start'];
    } else {
        $startDate = null;
    }

    if (isset($endDate)) {
        $endDate = $_GET['end'];
    } else {
        $endDate = null;
    }

    ?>

    document.getElementById('startDate').value = "<?php echo $startDate ?>";
    document.getElementById('endDate').value = "<?php echo $endDate ?>";

    function sendRequest() {


        var startDate = document.getElementById('startDate').value;
        var endDate = document.getElementById('endDate').value;
        var message = document.getElementById('messageID').value;
        var breed = document.getElementById('dogBreed').value;

        console.log(startDate);
        console.log(endDate);
        console.log(message);
        console.log(breed);
        console.log(id);

        var http = new XMLHttpRequest();
        var method = "POST";
        var url = "api/sitter/sendRequest.php";
        var asynchronous = true;
        http.open(method, url, asynchronous);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.send('sitterID=' + id + '&start=' + startDate + '&end=' + endDate + '&message=' + message + '&breed=' +
            breed);


        http.onload = function() {
            var data = JSON.parse(this.responseText);
            console.log(data);
            if (data.success == 1) {
                window.alert('Successfully requested!');
            }
        }
    }
    </script>

</body>

</html>
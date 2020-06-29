<?php
session_start();
if (!isset($_SESSION['id'])){
    header("Location:login.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ruka Sapi</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <script src="https://kit.fontawesome.com/5bd43f344d.js" crossorigin="anonymous"></script>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

</head>

<body onload="loadFavouriteData()">

    <!-- Navigation -->

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
                    <div id="nav-links-left" class="d-flex px-4 ml-n3">
                        <a class="nav-item nav-link from-left" href="donate.php">DONACIJE</a>
                        <?php
                        $id = $_SESSION['id'];
                        if ($id == 1){
                            echo '<a class="nav-item nav-link from-left" href="dashboard.php">DASHBOARD</a>';
                        }else{
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
                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown"></button>

                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="api/user/logout.php">Logout</a>
                    <a class="dropdown-item" href="#">My profile</a>
                </div>
            </div>
        </nav>

        <div class="banner">
            <img src="res/images/bannerTop.png" width="100%" height=100% alt="">
            <h1 class="text-center naslov">Omiljeni</h1>
        </div>

    </header>



    <!-- Page Content -->
    <div id="fiksirajExpand" class="mt-5 position-relative">

        <div class="col-md-10 col-sm-12 offset-md-1 offset-sm-0 px-5">
            <div class="row section-1" id="showMore"></div>
        </div>

    </div>

    <div class="footer position-relative">
        <img src="res/images/footer.png">
        <p>Copyright &copy;Emir & Milica</p>
    </div>


    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js" type="text/javascript"></script>
    <script src="js/favourites.js" type="text/javascript"></script>

    <script>
    // var idUser = < ? php echo $_SESSION['id'] ? > ;
    var idUser = 1;

    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
    </script>


</body>

</html>
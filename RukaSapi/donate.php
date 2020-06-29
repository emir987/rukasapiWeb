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
    <link href="css/custom.css" rel="stylesheet">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/donate.css">
    <script src="https://kit.fontawesome.com/5bd43f344d.js" crossorigin="anonymous"></script>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

</head>

<body>


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
            <h1 class="text-center naslov">Doniraj</h1>
        </div>

    </header>


    <div class="container" style="transform: translateY(60px)">

        <form id="regForm" action="">


            <!-- One "tab" for each step in the form: -->
            <div class="tab">

                <div class="row">

                    <div class="col-lg-2 select-donate">

                        <div id="hrana-button" class="hrana mb-5">
                            <div style="max-width:60px;" class="hrana-image">
                                <img class="w-100" src="res\images\meat.svg" alt="">
                            </div>
                            <div class="hrana-text">
                                Hrana
                            </div>
                        </div>

                        <div id="predmeti-button" class="novac">
                            <div style="max-width:60px;" class="hrana-image">
                                <img class="w-100" src="res\images\petHouse.svg" alt="">
                            </div>
                            <div class="novac-text">
                                Predmeti
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-7">

                        <div id="hrana-info" class="donate-info">
                            <div class="d-flex donate-section my-3 justify-content-between">
                                <div style="width:30%">Meso</div>
                                <div class="d-flex align-items-center justify-content-end">
                                    <select id="vrsta-mesa" class="m-2" name="vrsta_mesa"data-error="Odaberite vrstu">
                                        <option value="0" disabled selected>Vrsta mesa</option>
                                        <option value="svinja">Svinjsko</option>
                                        <option value="ovca">Ovcije</option>
                                        <option value="krava">Kravlje</option>
                                        <option value="kokoska">Pilece</option>
                                        <option value="ostalo">Ostalo</option>
                                    </select>
                                    <input type="number" placeholder="Kolicina (kg)" class="m-2" data-html="true" data-error="Unesite kolicinu">
                                    <input type="button" value="Dodaj" class="btn btn-success" onclick="dodajHranu(this)">
                                </div>
                            </div>
                            <div class="d-flex donate-section my-3 justify-content-between">
                                <div style="width:30%">Granule</div>
                                <div class="d-flex align-items-center justify-content-end">
                                    <select id="month-end" class="m-2" name="vrsta_mesa"data-error="Odaberite vrstu">
                                        <option value="0" disabled selected>Vrsta granula</option>
                                        <option value="svinja">Pas</option>
                                        <option value="ovca">Macka</option>
                                    </select>                                    
                                    <input type="number" placeholder="Kolicina (kg)" class="m-2" data-html="true" data-error="Unesite kolicinu">
                                    <input type="button" value="Dodaj" class="btn btn-success" onclick="dodajHranu(this)">
                                </div>
                            </div>
                            <div class="d-flex donate-section my-3 justify-content-between">
                                <div style="width:30%">Ostalo</div>
                                <div class="d-flex align-items-center justify-content-end">
                                    <input type="text" placeholder="Sta donirate?" class="m-2" onkeypress="return /[a-z]/i.test(event.key)" data-html="true" data-error="Unesite sta donirate">
                                    <input type="number" placeholder="Kolicina (kg)" class="m-2" data-html="true" data-error="Unesite kolicinu">
                                    <input type="button" value="Dodaj" class="btn btn-success" onclick="dodajHranu(this)">
                                </div>
                            </div>
                        </div>

                        <div id="predmeti-info" class="donate-info" style="display:none">
                            <div class="d-flex donate-section my-3 justify-content-between">
                                <div>Kucica</div>
                                <div class="d-flex align-items-center justify-content-end">
                                    <input type="text" placeholder="Kolicina" class="m-2" data-html="true" data-error="Unesite kolicinu">
                                    <input type="button" value="Dodaj" class="btn btn-success" onclick="dodajPredmet(this)">
                                </div>
                            </div>

                            <div class="d-flex donate-section my-3 justify-content-between">
                                <div>Igracka</div>
                                <div class="d-flex align-items-center justify-content-end">
                                    <input type="text" placeholder="Kolicina" class="m-2" data-html="true" data-error="Unesite kolicinu">
                                    <input type="button" value="Dodaj" class="btn btn-success" onclick="dodajPredmet(this)">
                                </div>
                            </div>

                            <div class="d-flex donate-section my-3 justify-content-between">
                                <div>Kucica</div>
                                <div class="d-flex align-items-center justify-content-end">
                                    <input type="text" placeholder="Kolicina" class="m-2" data-html="true" data-error="Unesite kolicinu">
                                    <input type="button" value="Dodaj" class="btn btn-success" onclick="dodajPredmet(this)">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">

                        <div id="odabrano" class="odabrano">
                            <h5 class="text-center">Lista Vasih donacija</h5>
                        </div>

                    </div>
                </div>
            </div>

    </div>

    <div class="tab container" style="transform: translateY(60px)">
        <div class="personal_info" id="personal_info_area">
             <div class="form-group d-flex">
                <input type="text" class="form-control m-2" name="email" id="email" placeholder="E-mail" />
                <input type="text" class="form-control m-2" name="phone" id="phone" placeholder="Phone" />
            </div>
 
            <div class="form-group d-flex">
                <input type="text" class="form-control m-2" name="name" id="name" placeholder="Ime" />
                <input type="text" class="form-control m-2" name="surname" id="surname" placeholder="Prezime" />
            </div>

            <div class="form-group">
                <input type="text" class="form-control m-2" name="email" id="email" placeholder="Adresa" />
                <input type="text" class="form-control m-2" name="phone" id="phone" placeholder="Grad" />
            </div>
            <div class="form-group">
                <input type="text" class="form-control m-2" name="phone" id="phone" placeholder="Broj telefona" />
            </div>
        </div>
    </div>

   

    <div style="overflow:auto; transform:translateY(50px)" class="mt-4 container">
        <div style="float:right;">
            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
            <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
        </div>
    </div>

    <!-- Circles which indicates the steps of the form: -->
    <div style="text-align:center;margin-top:40px; transform:translateY(50px)">
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
    </div>

    </form>

    </div>




    <div class="footer position-relative mt-0">
        <img src="res/images/footer.png">
        <p>Copyright &copy;Emir & Milica</p>
    </div>

    <!-- /.container -->

    <!-- Footer -->

    <script>
        $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
    </script>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/donate.js"></script>



</body>

</html>
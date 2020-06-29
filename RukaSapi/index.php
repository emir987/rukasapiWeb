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
    <link rel="stylesheet" href="css/donate.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <script src="https://kit.fontawesome.com/5bd43f344d.js" crossorigin="anonymous"></script>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

</head>

<body onload="loadData()">

    <!-- Navigation -->

    <style>
        .mySlides {
            display: none;
            padding: 20px 20px 20px;
        }

        /* The Close Button */
        .closeBtn {
            position: absolute;
            display:flex;
            top: -15px;
            right: -18px;
            cursor:pointer;
            width:35px;
        }

        .closeBtn:hover,
        .closeBtn:focus {
        }

        .custom-control-input:checked~.custom-control-label::before {
            color: #fff;
            border-color: #ce781f;
            background-color: #cc7d1a;
        }

        .voted{
            margin:20px;
            margin-top: 40px;
            text-align: center;
            font-size: 23px;
            color: green;
            font-weight: 500;
            transition: margin, color, font-size .5s;
        }

    </style>

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

    </header>


    <div class="banner" style="margin-top:20px">
        <img src="res/images/banner.png" width="100%" height=100% alt="">
        <div class="d-flex">
            <div class="search ">
                <form class="header-search-form">
                    <input id="getSearch" type="text" onkeyup="reduceLimit();loadData()" placeholder="Search...">
                </form>
            </div>
            <div class="filter-mobile dropdown">

                <!-- Button trigger modal -->
                <img src="res/images/filter.svg" alt="" width=25 data-toggle="modal" data-target="#exampleModal">

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content ">

                            <div class="modal-body d-flex flex-row justify-content-around">
                                <button style="position:absolute; right:10px" type="button" class="close"
                                    data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <div class="mt-3">
                                    <div id="category-small">
                                        <h3 class="">Category</h3>
                                        <label class="containers mt-4">Dog
                                            <input name="cat" onclick="reduceLimit()" onchange="loadData()"
                                                class="messageCheckbox" type="checkbox" checked="checked" value="Dog">
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="containers">Cat
                                            <input name="cat" onclick="reduceLimit()" onchange="loadData()"
                                                class="messageCheckbox" type="checkbox" checked="checked" value="Cat">
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="containers">Other
                                            <input name="cat" onclick="reduceLimit()" onchange="loadData()"
                                                class="messageCheckbox" type="checkbox" checked="checked" value="Other">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>

                                </div>
                                <div id="weight-small" class="mt-3">
                                    <h3>Weight <span style="font-size: 17pt; color: #4d4d4d">(kg)</span></h3>
                                    <div class="fw-size-choose d-flex">
                                        <div class="sc-item col-lg-1">
                                            <input onclick="reduceLimit()" onchange="loadData()" type="radio"
                                                name="sc-s" checked="checked" id="all-s" value=1>
                                            <label for="all-s">All</label>
                                        </div>
                                        <div class="sc-item col-lg-1">
                                            <input onclick="reduceLimit()" onchange="loadData()" checked type="radio"
                                                name="sc" id="xs-size" value="XS">
                                            <label for="xs-size">1-4</label>
                                        </div>
                                        <div class="sc-item col-lg-1">
                                            <input onclick="reduceLimit()" onchange="loadData()" type="radio"
                                                name="sc-s" id="s-size" value="S">
                                            <label for="s-size">5-9</label>
                                        </div>
                                    </div>
                                    <div class="fw-size-choose d-flex">

                                        <div class="sc-item col-lg-3">
                                            <input onclick="reduceLimit()" onchange="loadData()" type="radio"
                                                name="sc-s" id="m-size" value="M">
                                            <label for="m-size">10-19</label>
                                        </div>
                                        <div class="sc-item col-lg-3">
                                            <input onclick="reduceLimit()" onchange="loadData()" type="radio"
                                                name="sc-s" id="l-size" value="L">
                                            <label for="l-size">20-29</label>
                                        </div>
                                        <div class="sc-item col-lg-3">
                                            <input onclick="reduceLimit()" onchange="loadData()" type="radio"
                                                name="sc-s" id="xl-size" value="XL">
                                            <label for="xl-size">30+</label>
                                        </div>
                                    </div>
                                    <button style="" type="button" class="btn btn-success d-flex ml-auto mt-3"
                                        data-dismiss="modal" aria-label="Close">
                                        Filter
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <div id="fiksirajExpand" class="mt-5 position-relative">
        <div class="container">

            <div class="filter-lg" style="position: absolute; left:30px">
                <div style="margin-top: 50px">
                    <div id="category-large">
                        <h3 class="">Category</h3>
                        <label class="containers mt-4">Dog
                            <input name="cat" onclick="reduceLimit()" onchange="loadData()" class="messageCheckbox"
                                type="checkbox" checked="checked" value="Dog">
                            <span class="checkmark"></span>
                        </label>
                        <label class="containers">Cat
                            <input name="cat" onclick="reduceLimit()" onchange="loadData()" class="messageCheckbox"
                                type="checkbox" checked="checked" value="Cat">
                            <span class="checkmark"></span>
                        </label>
                        <label class="containers">Other
                            <input name="cat" onclick="reduceLimit()" onchange="loadData()" class="messageCheckbox"
                                type="checkbox" checked="checked" value="Other">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>

                <div class="mt-5">
                    <h3>Weight <span style="font-size: 17pt; color: #4d4d4d">(kg)</span></h3>

                    <div id="weight-large" class="fw-size-choose">
                        <div class="sc-item col-lg-4">
                            <input onclick="reduceLimit()" onchange="loadData()" type="radio" name="sc" checked
                                id="all-l" value=1>
                            <label for="all-l">All</label>
                        </div>
                        <div class="sc-item col-lg-4">
                            <input onclick="reduceLimit()" onchange="loadData()" type="radio" name="sc" id="xs-size-l"
                                value="XS">
                            <label for="xs-size-l">1-4</label>
                        </div>
                        <div class="sc-item col-lg-4">
                            <input onclick="reduceLimit()" onchange="loadData()" type="radio" name="sc" id="s-size-l"
                                value="S">
                            <label for="s-size-l">5-9</label>
                        </div>
                        <div class="sc-item col-lg-4">
                            <input onclick="reduceLimit()" onchange="loadData()" type="radio" name="sc" id="m-size-l"
                                value="M">
                            <label for="m-size-l">10-19</label>
                        </div>
                        <div class="sc-item col-lg-4">
                            <input onclick="reduceLimit()" onchange="loadData()" type="radio" name="sc" id="l-size-l"
                                value="L">
                            <label for="l-size-l">20-29</label>
                        </div>
                        <div class="sc-item col-lg-4">
                            <input onclick="reduceLimit()" onchange="loadData()" type="radio" name="sc" id="xl-size-l"
                                value="XL">
                            <label for="xl-size-l">30+</label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-10 col-sm-12 offset-md-1 offset-sm-0 px-5">
                <div class="row section-1" id="showMore"></div>
                <div class="text-center">
                    <button class="btn btn-info" type="button" id="loadMore">Load more</button>
                </div>

            </div>

        </div>

        <div class="footer position-relative">
            <img src="res/images/footer.png">
            <p>Copyright &copy;Emir & Milica</p>
        </div>
    </div>

    <div id="expanded_form" class="w-75"
        style="display: none; position: absolute; margin-bottom: 30px; margin-top: 100px">
        <button type="button" id="close_btn" onclick="close_form()"><i class="fa fa-close"></i></button>

        <div class="container-fluid">
            <div class="header">Add your Pet</div>
            <div class="content">

                <form id="pokupiFormu" action="api/pet/addPet.php" method="post" enctype="multipart/form-data">

                    <div class="form-group m-0">
                        <div class="jace">
                            <div class="d-flex">
                                <label for="inputName14" class="whiteText">Name</label>
                            </div>
                        </div>
                        <input name="name" type="text" class="form-control" id="inputNamel4">
                    </div>
                    <div class="d-flex mb-2">
                        <label class="form-check-label" style="color:red" for="no-name">No name</label>
                        <input onchange="noName(this)" class="w-auto my-auto ml-2" name="no-name" value="0"  type="checkbox" id="no-name">
                    </div>

                    <div class="form-group">
                        <label for="inputPhone" class="whiteText">Image (URL)</label>
                        <input name="image" type="text" class="form-control" id="inputPhone">
                    </div>

                    <div class="form-group">
                        <div class="jace"><label for="inputEmail4" class="whiteText">Category</label>
                        </div>
                        <select name="category" class="form-control" id="inputCategory4">
                            <option value="gender">Choose category..</option>
                            <option value="Dog">Dog</option>
                            <option value="Cat">Cat</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="jace">
                            <label for="gender" class="whiteText">Gender</label>
                        </div>
                        <select name="gender" class="form-control" id="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>                        
                    </div>

                    <div class="form-group">
                        <label for="breed" class="whiteText">Breed</label>
                        <input name="breed" type="text" class="form-control" id="breed">
                    </div>

                    <div class="form-group">
                        <label for="height" class="whiteText">Height(cm)</label>
                        <input name="height" type="number" class="form-control" id="height">
                    </div>

                    <div class="form-group">
                        <label for="weight" class="whiteText">Weight(kg)</label>
                        <input name="weight" type="number" class="form-control" id="weight">
                    </div>

                    <div class="form-group">
                        <label for="color" class="whiteText">Color</label>
                        <input name="color" type="text" class="form-control" id="color">
                    </div>

                    <div class="form-group">
                        <label for="age" class="whiteText">Age</label>
                        <input name="age" type="number" class="form-control" id="age">
                    </div>

                    <div class="form-group">
                        <label for="about" class="whiteText">About</label>
                        <input name="description" type="text" class="form-control" id="about">
                    </div>

                    <input type="hidden" name="ownerID" value="<?php echo $_SESSION['id'] ?>">

                    <div class="form-group">
                        <input value="Add" onclick="addPet()" name="submit" type="button" id="addButton"
                            class="btn btn-primary">
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- /.container -->

    <!-- Modals new names -->


    <!-- Small modal -->
    <div>
        <div id="newNameModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div id="give-name" class="modal-content">
                    
                </div>
            </div>
        </div>
    </div>

    


    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js" type="text/javascript"></script>
    <script src="js/custom-index.js" type="text/javascript"></script>

    <script>
    var idUser = <?php echo $_SESSION['id'] ?>;

    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
    </script>


</body>

</html>
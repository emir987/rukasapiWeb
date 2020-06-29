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

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

</head>

<body onload="loadData()">

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-pet fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">Ruka Sapi</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php"">Home
                    <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="appointment.php">Pet Sitting</a>
                </li>
                <?php

                $id = $_SESSION['id'];
                include 'api/config/connect.php';

                if ($id == 1){
                    echo '<li class="nav-item">
                    <a class="nav-link" href="dashboard.php">DASHBOARD</a>
                </li>';
                }
                ?>
                <li>
                    <div class="dropdown">
                        <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown"></button>

                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="api/user/logout.php">Logout</a>
                            <a class="dropdown-item" href="#">My profile</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>


<!-- Page Content -->
<div id="fiksirajExpand">
    <div class="container-lg container-fluid">
        <div class="row">
            <div class="ml-n3 col-4 col-lg-3 col-md-3 col-sm-3 col-sm-auto d-md-inline-block d-lg-inline-block ">
                <div class="mr-sm-5 col-sm-6" style="margin-top: 50px">
                    <div>
                        <h3 class="">Category</h3>

                        <label class="containers mt-4">Dog
                            <input name="cat" onclick="reduceLimit()" onchange="loadData()" class="messageCheckbox"
                                   type="checkbox"
                                   checked="checked"
                                   value="Dog">
                            <span class="checkmark"></span>
                        </label>
                        <label class="containers">Cat
                            <input name="cat" onclick="reduceLimit()" onchange="loadData()" class="messageCheckbox"
                                   type="checkbox"
                                   checked="checked"
                                   value="Cat">
                            <span class="checkmark"></span>
                        </label>
                        <label class="containers">Other
                            <input name="cat" onclick="reduceLimit()" onchange="loadData()" class="messageCheckbox"
                                   type="checkbox"
                                   checked="checked"
                                   value="Other">
                            <span class="checkmark"></span>
                        </label>
                    </div>

                </div>
                <div  class="mt-5 col-sm-9">
                    <h3>Weight <span style="font-size: 17pt; color: #4d4d4d">(kg)</span></h3>
                    <div class="fw-size-choose">
                        <div class="sc-item col-lg-3">
                            <input onclick="reduceLimit()" onchange="loadData()" type="radio" name="sc" checked id="all" value=1>
                            <label for="all">All</label>
                        </div>
                        <div class="sc-item col-lg-3">
                            <input onclick="reduceLimit()" onchange="loadData()" type="radio" name="sc" id="xs-size" value="XS">
                            <label for="xs-size">1-4</label>
                        </div>
                        <div class="sc-item col-lg-3">
                            <input onclick="reduceLimit()" onchange="loadData()" type="radio" name="sc" id="s-size" value="S">
                            <label for="s-size">5-9</label>
                        </div>
                        <div class="sc-item col-lg-3">
                            <input onclick="reduceLimit()" onchange="loadData()" type="radio" name="sc" id="m-size"  value="M">
                            <label for="m-size">10-19</label>
                        </div>
                        <div class="sc-item col-lg-3">
                            <input onclick="reduceLimit()" onchange="loadData()" type="radio" name="sc" id="l-size" value="L">
                            <label for="l-size">20-29</label>
                        </div>
                        <div class="sc-item col-lg-3">
                            <input onclick="reduceLimit()" onchange="loadData()" type="radio" name="sc" id="xl-size" value="XL">
                            <label for="xl-size">30+</label>
                        </div>


                    </div>

                </div>

            </div>

            <div class="mr-n5 col-8 col-lg-9 col-md-9 col-sm-9 col-8">
                <div class="search mt-5 mt-lg-2 mt-md-2 mt-sm-3 mb-lg-3">
                    <form class="header-search-form">
                        <input id="getSearch" type="text" onkeyup="reduceLimit();loadData()" placeholder="Search...">
                    </form>
                </div>
                <div class="row" id="showMore"></div>
                <div class="text-center">
                    <button class="btn btn-info" type="button" id="loadMore">Load more</button>
                </div>

            </div>

        </div>

    </div>



    <footer class="py-5 bg-dark">
        <div class="container-fluid">
            <p class="m-0 text-center text-white">Copyright &copy; Ruka Sapi</p>
        </div>
    </footer>
</div>

<div id="expanded_form" class="w-75" style="display: none; position: absolute; margin-bottom: 30px; margin-top: 100px">
    <button type="button" id="close_btn" onclick="close_form()"><i class="fa fa-close"></i></button>

    <div class="container-fluid">
        <div class="header">Add your Pet</div>
        <div class="content">

            <form id="pokupiFormu" action="api/pet/addPet.php" method="post" enctype="multipart/form-data">

                <div class="form-group">
                    <div class="jace"><label for="inputName14" class="whiteText">Name</label>
                    </div>
                    <input name="name" type="text" class="form-control" id="inputNamel4">
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

<!-- Footer -->


<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/custom-index.js" type="text/javascript"></script>

<script>

    var idUser = <?php echo $_SESSION['id']?>;

    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

</script>


</body>

</html>

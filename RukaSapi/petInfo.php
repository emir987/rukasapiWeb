<?php
session_start();
$id = $_GET["id"];

if (!isset($_SESSION['id'])){
    header("Location:login.php");
}

$idUser = $_SESSION['id']

?>


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

    <!-- Custom styles for this template -->
    <link href="css/blog-post.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link rel="stylesheet" href="css/nav.css">



</head>

<body onload="f()">

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

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Post Content Column -->
        <div class="col-md-12  col-sm-12">

            <div class="col-lg-12">
                <!-- Title -->
                <h1 id="petName" class="mt-4"></h1>


                <hr>
            </div>

            <div class="row">
                <!-- Preview Image -->
                <div class="col-lg-6 col-md-8 img-hover">
                    <img id="photo" class="img-fluid rounded img-responsive" src="http://placehold.it/900x300" alt="">
                </div>
                <div class="col-lg-6 col-md-4">

                    <div id="infos"></div>
                    <p id="info"></p>



                </div>
            </div>
            <hr>
            <div class="row">
                <div id="owner" class="col-lg-6"></div>
                <div id="kupi" class="col-lg-6">

                </div>
            </div>
            <!-- Comments Form -->
            <div class="card my-4">
                <h5 class="card-header">Leave a Comment:</h5>
                <div class="card-body">
                    <form id="pokupiFormu" method="post" action="">
                        <!--                        onsubmit="return submitFormComment(this);"-->
                        <div class="form-group">
                            <textarea name="comment" id="addComment" class="form-control" rows="3"></textarea>
                        </div>

                        <!--                        <input name="petID" type="hidden" value="-->
                        <?php //echo $_GET['id'] ?><!--">-->
                        <button type="button" onclick="submitFormComment()" class="btn btn-success">Submit</button>
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


    function f() {

        var h1 = document.getElementById('petName');
        var photo = document.getElementById('photo');
        var info = document.getElementById('info');
        var infos = document.getElementById('infos');

        var http = new XMLHttpRequest();
        var method = "GET";
        var url = "api/pet/getPet.php?id=<?php echo $_GET["id"] ?>";
        var asynchronous = true;

        http.open(method, url, asynchronous);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.send();

        http.onload = function () {
            var data = JSON.parse(this.responseText);
            console.log(data);
            var pet = data.pet;

            h1.innerHTML = pet.name;
            photo.src = pet.image;
            info.innerHTML = "<b>About:</b><br>" + pet.description;

            infos.innerHTML = '<table class="table table-striped">\n' +
                '  <thead>\n' +
                '    <tr>\n' +
                '      <th scope="col">Weight</th>\n' +
                '      <th scope="col">Height</th>\n' +
                '      <th scope="col">Age</th>\n' +
                '      <th scope="col">Category</th>\n' +
                '    </tr>\n' +
                '  </thead>\n' +
                '  <tbody>\n' +
                '    <tr>\n' +
                '      <td>'+pet.weight+' kg</td>\n' +
                '      <td>'+pet.height+' cm</td>\n' +
                '      <td>'+pet.age+' year</td>\n' +
                '      <td>'+pet.category+'</td>\n' +
                '    </tr>\n' +
                '  </tbody>\n' +
                '</table>';



            var ownerInfo = "<h5>Owner</h5><hr><table><tr><td>Name: " + pet.owner.name + " " + pet.owner.surname + "</td></tr>";
            ownerInfo += "<tr><td>Phone: " + pet.owner.phone + "</td></tr>";
            ownerInfo += "<tr><td>Address: " + pet.owner.address + "</td></tr></table>";
            owner.innerHTML = ownerInfo;

            loadComments();
        }
    }

    function submitFormComment() {

        var form = document.getElementById('pokupiFormu');
        var formData = new FormData(form);
        formData.append("petID", <?php echo $_GET['id']?>)

        var http = new XMLHttpRequest();
        var method = "POST";
        var url = 'api/comment/postComment.php';
        var asynchronous = true;

        http.open(method, url, asynchronous);
        http.send(formData);

        http.onload = function () {
            var data = JSON.parse(this.responseText);
            console.log(data);
            loadComments();
        }
    }


    function loadComments() {

        var comments = document.getElementById('comments');

        var http = new XMLHttpRequest();
        var method = "GET";
        var url = "api/comment/loadComment.php?id=<?php echo $_GET["id"] ?>";
        var asynchronous = true;

        http.open(method, url, asynchronous);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.send();

        http.onload = function () {
            var data = JSON.parse(this.responseText);
            console.log(data);
            var commentsArray = data.comments;
            var html = "";

            for (var a = 0; a < commentsArray.length; a++) {
                $commentID = commentsArray[a].id;
                $comment = commentsArray[a].comment;

                html += '<div class="media mb-4">';
                html += '<img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">';
                html += '<div class="media-body">';
                var commentator = commentsArray[a].commentator.name + " " + commentsArray[a].commentator.surname;
                var ago = '';
                var formattedDate = commentsArray[a].date.substr(0, 10) + ' at ' + commentsArray[a].date.substring(10, 16) + 'h'
                if (commentsArray[a].hours !== 'no') {
                    ago += commentsArray[a].hours + ' hour ago';
                } else {
                    ago += formattedDate;
                }
                html += '<span class="mt-0 font-weight-bold">' + commentator + '</span><span class="ml-4 comment" data-toggle="tooltip" data-placement="auto right" title="' + formattedDate + '">' + ago + '</span>';

                html += '<div id="comment' + $commentID + '">' + commentsArray[a].comment + '</div></div>';


                if (commentsArray[a].commentator.userID == <?php echo $idUser ?>) {
                    
                    html += '<button onclick="openEdit(\'' + $comment + '\',' + $commentID + ')" class="mt-3 btn btn-link btn-sm" type="button" >Edit</button>' +
                    '<button  onclick="deleteComment(' + $commentID + ')" class="mt-3 btn btn-link btn-sm text-danger">Delete</button >';
                }
                html += '</div>';
                
            }
            if (commentsArray.length > 0) {
                comments.innerHTML = html;
            }

        }
    }

    function deleteComment(id) {
        var http = new XMLHttpRequest();
        var method = "POST";
        var url = "api/comment/deleteComment.php";
        var asynchronous = true;

        http.open(method, url, asynchronous);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.send('id=' + id);

        http.onload = function () {
            var data = JSON.parse(this.responseText);
            console.log(data);
            loadComments();
        };
    }

    function editConfirm(id) {

        var newComment = document.getElementById('newComment').value;

        var http = new XMLHttpRequest();
        var method = "POST";
        var url = "api/comment/updateComment.php";
        var asynchronous = true;

        http.open(method, url, asynchronous);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        http.send('comment=' + newComment + '&id=' + id);

        http.onload = function () {
            var data = JSON.parse(this.responseText);
            console.log(data);
            if (data.success === 1) {
                loadComments();
            }
        };

    }

    function closeEdit(id, comment) {
        document.getElementById('comment' + id).innerHTML = '<div id="comment' + id + '">' + comment + '</div>';
    }


    function openEdit(comment, id) {
        document.getElementById('comment' + id).innerHTML = '<div class="row">' +
            '<textarea class="form-control" rows="2" style="width: 90%;" id="newComment" type="text">' + comment + '</textarea>' +
            '<span onclick="closeEdit(' + id + ',\'' + comment + '\')" id="deletePet" class="close mx-2">&times;</span>' +
            '<span onclick="editConfirm(' + id + ')" class="close">&#10003;</span></div>';
    }


</script>

<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

</body>

</html>

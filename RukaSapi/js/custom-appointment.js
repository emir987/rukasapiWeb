var startDate = document.getElementById('startDateID');
startDate.min = new Date().toISOString().split("T")[0];
document.getElementById('endDateID').min = new Date().toISOString().split("T")[0];

function updateMin() {
    document.getElementById('endDateID').min = startDate.value.split("T")[0];
}

function getTypes() {
    var checks = document.getElementsByName('type');
    var check_value = [];
    for (var i = 0; checks[i]; ++i) {
        if (checks[i].checked) {
            check_value[i] = false;
        } else {
            check_value[i] = true;
        }
    }
    return check_value;
}

function getWeight() {
    var sizes = document.getElementsByName('sizeRadio');
    var selected = "";
    for (i = 0; i < sizes.length; i++) {
        if (sizes[i].checked) {
            selected = sizes[i].value;
        }
    }
    return selected;
}

function findSitters() {

    var zip = document.getElementById('location').value;
    var weight = getWeight();
    var types = getTypes();

    var http = new XMLHttpRequest();
    var method = "POST";
    var url = "api/sitter/getAllSitters.php";
    var asynchronous = true;



    http.open(method, url, asynchronous);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.send("location=" + zip + "&weight=" + weight + "&types=" + JSON.stringify(types));
    http.onload = function () {
        var data = JSON.parse(http.responseText);
        console.log(data);

        var sitters = data.sitters;
        console.log(sitters)
        var html = "";

        for (var a = 0; a < sitters.length; a++) {

            html += '<div class="col-12 col-lg-5 col-md-6 mb-4 col-sm-6">';
            html += '<div class="img-wrap">';
            html += '<img class="card-img-top image-card" style="height: 300px" src="' + sitters[a].image + '" alt="' + sitters[a].name + '">';
            html += '</div></div>';
            html += '<div class="col-12 col-lg-7 col-md-6 mb-4 col-sm-6">';


            //pocinje
            html += '<div class="d-flex justify-content-between" id="headerText">';
            html += '<div class="" id="FirstHeaderText">';
            var start = document.getElementById('startDateID').value;
            var end = document.getElementById('endDateID').value;
            html += '<h3><a class="text-success" href="sitterPage.php?id=' + sitters[a].id + '&start=' + start + '&end=' + end + '">' + sitters[a].name + " " + sitters[a].surname + '</a></h3>';
            html += '<span class="font-size text-dark font-weight-bold">' + sitters[a].mainMessage + '</span><br>';
            html += '<span class="pointer font-weight-bolder text-uppercase small  border border-success text-success p-1 border-10 border-dotted">' + sitters[a].reviews + ' reviews</span><br>';
            html += '</div>';


            html += '<div class="">';
            if (sitters[a].favorite === 'no') {
                html += '<button id="btnFavSitter" onclick="addFavoriteSitter(' + sitters[a].id + ')" class="align-btn-right  btn-outline-danger float-right"><span id="liked' + sitters[a].id + '" style="font-size: 16pt">&#9825;</span></button>';
            } else {
                html += '<button id="btnFavSitter" onclick="removeFavoriteSitter(' + sitters[a].id + ')" class="align-btn-right  btn-outline-danger float-right"><span id="liked' + sitters[a].id + '" style="font-size: 16pt">&#9829;</span></button>';
            }
            html += '<h4 class="text-danger font-size">' + sitters[a].price + "$/walk" + '</h4>';
            html += '</div>';
            html += '</div>';
            //zavrsava


            //pocinje
            var allReviews = sitters[a].allReviews;
            html += '<div class="mt-3" id="bodyText">';
            for (let b = 0; b < allReviews.length; b++) {
                html += '<p>' + allReviews[b];
                if (allReviews[b].length === 85) {
                    html += '<a href="sitterPage.php?id=' + sitters[a].id + '//#comments"> (see more...)</a>' + '</p>';
                }
            }
            html += '</div>';
            //zavrsava


            html += '<div id="footerText" class="mt-sm-2">';
            html += '<span class="text-danger" >Favourites: ' + sitters[a].favs + '</span>';
            html += '</div>';
            html += '</div>';

        }
        //ispis
        document.getElementById('sitters').innerHTML = html;
    }
}

function addFavoriteSitter(id) {

    console.log(id);
    var http = new XMLHttpRequest();
    var method = "POST";
    var url = "api/favoriteSitter/addFavorite.php";
    var asynchronous = true;
    http.open(method, url, asynchronous);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.send('sitterID=' + id);

    http.onload = function () {
        var data = JSON.parse(this.responseText);
        console.log(data);
        findSitters();
    }

}

function removeFavoriteSitter(id) {

    var http = new XMLHttpRequest();
    var method = "POST";
    var url = "api/favoriteSitter/removeFavorite.php";
    var asynchronous = true;
    http.open(method, url, asynchronous);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.send('sitterID=' + id);

    http.onload = function () {
        var data = JSON.parse(this.responseText);
        console.log(data);
        findSitters();
    }

}
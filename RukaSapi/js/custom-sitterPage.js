function f() {

    var h1 = document.getElementById('sitterName');
    var sitterPhoto = document.getElementById('sitterPhoto');
    var sitterInfo = document.getElementById('sitterInfo');
    var sitterInfos = document.getElementById('sitterInfos');

    var http = new XMLHttpRequest();
    var method = "GET";
    var url = "api/sitter/getSitter.php?id=" + id;
    var asynchronous = true;

    http.open(method, url, asynchronous);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.send();

    http.onload = function () {
        var data = JSON.parse(this.responseText);
        console.log(data);
        var sitter = data.sitter;

        h1.innerHTML = sitter.name + " " + sitter.surname;
        sitterPhoto.src = sitter.image;
        sitterInfo.innerHTML = "<b>About:</b><br>" + sitter.info;
        var cares = "";
        if (sitter.dog == 1 && sitter.cat == 1) {
            cares = "Dog and Cat";
        } else if (sitter.dog == 1 && sitter.cat == 0) {
            cares = "Dog";
        }
        if (sitter.dog == 0 && sitter.cat == 1) {
            cares = "Cat";
        }

        $since = "";
        if (!sitter.years) {
            $since += sitter.month + " months";
        } else {
            $since += sitter.years + " years";
        }

        sitterInfos.innerHTML = '<table class="table table-striped">\n' +
            '  <thead>\n' +
            '    <tr>\n' +
            '      <th scope="col">Phone</th>\n' +
            '      <th scope="col">Email</th>\n' +
            '      <th scope="col">Address</th>\n' +
            '    </tr>\n' +
            '  </thead>\n' +
            '  <tbody>\n' +
            '    <tr>\n' +
            '      <td>' + sitter.phone + '</td>\n' +
            '      <td>' + sitter.email + '</td>\n' +
            '      <td>' + sitter.address + '</td>\n' +
            '    </tr>\n' +
            '  </tbody>\n' +
            '</table>' +
            '<table class="table table-striped">\n' +
            '  <thead>\n' +
            '    <tr>\n' +
            '      <th scope="col">Since</th>\n' +
            '      <th scope="col">Cares about</th>\n' +
            '      <th scope="col">Max pet weight</th>\n' +
            '      <th scope="col">Price</th>\n' +
            '    </tr>\n' +
            '  </thead>\n' +
            '  <tbody>\n' +
            '    <tr>\n' +
            '      <td>' + $since + '</td>\n' +
            '      <td>' + cares + ' </td>\n' +
            '      <td>' + sitter.weight + ' kg</td>\n' +
            '      <td>' + sitter.price + ' $ per walk</td>\n' +
            '    </tr>\n' +
            '  </tbody>\n' +
            '</table>';

        loadReviews();
    }
}

function submitFormReview() {

    var form = document.getElementById('reviewForm');
    var formData = new FormData(form);
    formData.append("sitterID", id);

    var http = new XMLHttpRequest();
    var method = "POST";
    var url = 'api/sitter/reviewSitter.php';
    var asynchronous = true;

    http.open(method, url, asynchronous);
    http.send(formData);

    http.onload = function () {
        var data = JSON.parse(this.responseText);
        console.log(data);
        loadReviews();
    }
}


function loadReviews() {

    var comments = document.getElementById('comments');

    var http = new XMLHttpRequest();
    var method = "GET";
    var url = "api/sitter/loadReview.php?id=" + id;
    var asynchronous = true;

    http.open(method, url, asynchronous);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.send();

    http.onload = function () {
        var data = JSON.parse(this.responseText);
        console.log(data);
        var reviewArray = data.reviews;
        var html = "";

        for (var a = 0; a < reviewArray.length; a++) {
            $reviewID = reviewArray[a].id;
            $review = reviewArray[a].review;

            html += '<div class="media mb-4">';
            html += '<img class="d-flex mr-3 rounded-circle" style="width: 50px; height: 50px;" src="data:image/png;base64, ' + reviewArray[a].commentator.image + '" alt="">';
            html += '<div class="media-body">';
            var commentator = reviewArray[a].commentator.name + " " + reviewArray[a].commentator.surname;
            var ago = '';
            var formattedDate = reviewArray[a].date.substr(0, 10) + ' at ' + reviewArray[a].date.substring(10, 16) + 'h';
            if (reviewArray[a].hours !== 'no') {
                ago += reviewArray[a].hours + ' hour ago';
            } else {
                ago += formattedDate;
            }
            html += '<span class="mt-0 font-weight-bold">' + commentator + '</span><span class="ml-4 comment" data-toggle="tooltip" data-placement="auto right" title="' + formattedDate + '">' + ago + '</span>';

            html += '<div id="comment' + $reviewID + '">' + reviewArray[a].review + '</div></div>';


            if (reviewArray[a].commentator.userID == userID) {
                html += '<button  onclick="deleteReview(' + $reviewID + ')" class="mt-3 btn btn-link btn-sm text-danger">Delete</button >';

            }
            html += '</div>';
        }
        comments.innerHTML = html;


    }
}

function deleteReview(id) {
    var http = new XMLHttpRequest();
    var method = "POST";
    var url = "api/sitter/deleteReview.php";
    var asynchronous = true;

    http.open(method, url, asynchronous);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.send('id=' + id);

    http.onload = function () {
        var data = JSON.parse(this.responseText);
        console.log(data);
        loadReviews();
    };
}
$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
});


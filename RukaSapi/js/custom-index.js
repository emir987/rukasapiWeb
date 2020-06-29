$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

let navbar = $(".navbar");
let nav = $(".navigacija");


$(window).scroll(function () {
    let oTop = $("#showMore").offset().top;
    if ($(window).scrollTop() > oTop) {
        nav.addClass("sticky");
    } else {
        nav.removeClass("sticky");
    }
});

//limit for database read
var limit = 3;
var search = "";
var newPetsShow = false;

//load pets
function loadData() {

    search = document.getElementById('getSearch').value;

    var category = vrijedsnotCheck();

    var weight = vrijedsnotRadio();

    var http = new XMLHttpRequest();
    var method = "POST";
    var url = "api/pet/getAllPets.php";
    var asynchronous = true;


    http.open(method, url, asynchronous);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.send("counter=" + limit + "&searchHint=" + search + "&weight=" + weight + "&category=" + JSON.stringify(category));
    limit += 3;
    http.onload = function () {
        var data = JSON.parse(http.responseText);
        console.log(data);
        var pets = data.pets;
        const newpets = data.newpets || [];

        var html = "";

        if (data.stopLoad === 1) {
            btn.style.display = 'none';
        }

        if (data.success === 1) {

            if (newpets.length > 0) {

                html += `<div class="col-12 h2">Novi ljubimci</div>`;

                for (var a = 0; a < newpets.length; a++) {
                    //svaki novi element
                    html += `<div style="cursor: pointer;" class="col-12 col-lg-4 col-md-6 mb-4 col-sm-6">
                        <div data-toggle="tooltip" title="Show more" class="blur card h-100-custom">
                        <div class="img-wrap">
                        <img class="card-img-top image-card" style="height: 180px;" src="${newpets[a].image}" alt="${newpets[a].name}">`;
                    if (newpets[a].favorite === 'no') {
                        html += '<button id="btnFav" onclick="addFavorite(' + newpets[a].id + ');reduceLimit()" class="align-btn-right  btn-outline-danger"><span id="liked' + newpets[a].id + '" style="font-size: 16pt">&#9825;</span></img></div>';
                    } else {
                        html += '<button id="btnFav" onclick="removeFavorite(' + newpets[a].id + ');reduceLimit()" class="align-btn-right  btn-outline-danger"><span id="liked' + newpets[a].id + '" style="font-size: 16pt">&#9829;</span></img></div>';
                    }
                    html += '<div class="card-body-custom">';
                    html += '<a href="petInfo.php?id=' + newpets[a].id + '"><span class="title_card">' + newpets[a].name + '</span> &nbsp; <span style="color: black">-  ' + newpets[a].breed + '</span></a>';
                    var about = newpets[a].description.substr(0, 58);
                    about = about.substr(0, Math.min(about.length, about.lastIndexOf(" "))) + "...";
                    html += '<p class="card-text">' + about + '</p></div><div class="card-footer">';
                    date = newpets[a].date.substr(0, 10);
                    html += '<span id="publish">Date: ' + date + '</span></div></div></div>';
                }
            }

            html += `<div class="col-12 h2">Svi ljubimci</div>`;

            for (var a = 0; a < pets.length; a++) {
                //svaki element
                html += `<div style="cursor: pointer;" class="col-12 col-lg-4 col-md-6 mb-4 col-sm-6">
                            <div data-toggle="tooltip" title="Show more" class="blur card h-100-custom">
                                <div class="img-wrap">`;
                if (idUser === 1) {
                    html += `<span onclick="deletePet(${pets[a].id})" id="deletePet" class="close">&times;</span>`;
                }

                html += `<img class="card-img-top image-card" style="height: 180px;" src="${pets[a].image}" alt="${pets[a].name}">`;
                if (pets[a].favorite === 'no') {
                    html += '<button id="btnFav" onclick="addFavorite(' + pets[a].id + ');reduceLimit()" class="align-btn-right  btn-outline-danger"><span id="liked' + pets[a].id + '" style="font-size: 16pt">&#9825;</span></img></div>';
                } else {
                    html += '<button id="btnFav" onclick="removeFavorite(' + pets[a].id + ');reduceLimit()" class="align-btn-right  btn-outline-danger"><span id="liked' + pets[a].id + '" style="font-size: 16pt">&#9829;</span></img></div>';
                }

                var about = pets[a].description.substr(0, 58);
                about = about.substr(0, Math.min(about.length, about.lastIndexOf(" "))) + "...";
                date = pets[a].date.substr(0, 10);

                html += `<div class="card-body-custom">
                            <a href="petInfo.php?id=${pets[a].id}">
                                <span class="title_card">${pets[a].name}</span> &nbsp; <span style="color: black">- ${pets[a].breed}</span></a>
                            <p class="card-text">${about}</p>
                        </div>
                        <div class="card-footer">
                            <span id="publish">Date: ${date}</span>
                        </div>
                        </div>
                    </div > `;
            }
        }

        //addPet - admin
        if (idUser === 1) {
            html += '<div class="col-lg-4 col-md-6 mb-4 col-sm-6 col-12"><div class="card h-100" style="background-color:rgba(47,147,31,0.35)">';
            html += '<span class="span-custom-add">Add new pet</span><div class="product-item">';
            html += '<div class="pi-pic" style="background-color:rgba(76,239,50,0.03)">';
            html += '<img style="width: 264px;height: 250px;" id="slikaAdd" src="./res/images/add.png" alt="" onclick="expand()"></div></div></div></div>';
        }

        if (newpets.length > 0 && newPetsShow == 0) {
            vote(newpets);
            newPetsShow = 1;
        }

        removeNewPets();

        let divIspis = document.getElementById('showMore');
        divIspis.innerHTML = html;

    }
}


function vote(newPets) {

    let html = '';

    for (let index = 0; index < newPets.length; index++) {
        const pet = newPets[index];

        html += `<div id="pet-section-${pet.id}" class="mySlides">
                    <img class="closeBtn" src="res/images/close.png" onclick="closeModal()">
                    <img style="width:100%; max-height:320px; object-fit:cover; margin-top:10px" src="${pet.image}">
                    <div id="gived-name">
                        <h3 class="text-center my-3">Dajte ime novom ljubimcu</h3>
                        <div class="d-flex justify-content-center">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input checked type="radio" id="newname1${pet.id}" name="newname${pet.id}" class="custom-control-input" value="${pet.petNames[0]}">
                                <label class="custom-control-label h5" for="newname1${pet.id}">${pet.petNames[0]}</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="newname2${pet.id}" name="newname${pet.id}" class="custom-control-input" value="${pet.petNames[1]}">
                                <label class="custom-control-label h5" for="newname2${pet.id}">${pet.petNames[1]}</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="newname3${pet.id}" name="newname${pet.id}" class="custom-control-input" value="${pet.petNames[2]}">
                                <label class="custom-control-label h5" for="newname3${pet.id}">${pet.petNames[2]}</label>
                            </div>
                        </div>
                        <button onclick="submitName(${pet.id})" type="button" class="btn btn-success mx-auto d-flex mt-3">Potvrdi</button>
                    </div>
                </div>`;
    }

    html += `<div class="caption-container">
                <div class="d-flex" style="position: absolute; top:50%; transform:translateY(-50%); left:-10%; height: 40px;">
                    <img onclick="plusSlides(-1)" src="res/images/previous.png" class="h-100" style="cursor: pointer;">
                </div>
                <div class="d-flex" style="position: absolute; top:50%; transform:translateY(-50%); right:-10%; height: 40px;">
                    <img onclick="plusSlides(1)" src="res/images/next.png" class="h-100" style="cursor: pointer;">
                </div>
            </div>`;

    document.getElementById('give-name').innerHTML = html;
    $('#newNameModal').modal('show');

    showSlides(slideIndex)
}

function noName(element) {
    if (element.checked) {
        element.parentElement.previousElementSibling.style.display = "none";
    } else {
        element.parentElement.previousElementSibling.style.display = "block";
    }
}

function submitName(petID) {

    const radioID = 'newname' + petID;

    let radios = document.getElementsByName(radioID);
    let petName = "";
    for (let i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            petName = radios[i].value;
            break;
        }
    }

    const http = new XMLHttpRequest();
    const method = "POST";
    const url = "api/pet/voteName.php";
    const asynchronous = true;

    http.open(method, url, asynchronous);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.send("petID=" + petID + "&name=" + petName);
    http.onload = function () {
        var data = JSON.parse(http.responseText);
        console.log(data);
        if (data.success === '1') {
            const petElementID = '#pet-section-' + data.petID;
            const petElement = $("#give-name").find(petElementID)[0];
            const slides = document.getElementsByClassName("mySlides");
            petElement.lastElementChild.classList.add('voted');
            petElement.lastElementChild.innerHTML = "Hvala, Vaš glas je zabilježen! &#128077";
            setTimeout(function () {
                plusSlides(1);
                if (slides.length == 1) {
                    petElement.parentElement.parentElement.parentElement.remove();
                } else {
                    petElement.remove();
                }
            }, 2000);

        }
    }

}


var slideIndex = 1;

function closeModal() {
    $("#newNameModal").modal('hide')
}

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    const slides = document.getElementsByClassName("mySlides");

    if (n > slides.length) {
        slideIndex = 1
    }
    if (n < 1) {
        slideIndex = slides.length
    }
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }

    slides[slideIndex - 1].style.display = "block";
}


function removeNewPets() {
    var http = new XMLHttpRequest();
    var method = "POST";
    var url = "api/pet/deleteNewPets.php";
    var asynchronous = true;

    http.open(method, url, asynchronous);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.send();
}

//load more pets - increase limit
var btn = document.getElementById('loadMore');
btn.addEventListener("click", function () {
    loadData();
});


//                              FILTER START
//checkButtons category
function vrijedsnotCheck() {
    const checksParent = (window.innerWidth < 991) ? document.getElementById('category-small') : document.getElementById('category-large');
    const checks = checksParent.querySelectorAll('input');

    var check_value = [];
    for (var i = 0; checks[i]; ++i) {
        if (checks[i].checked) {
            check_value[i] = checks[i].value;
        } else {
            check_value[i] = null;
        }
    }
    return check_value;
}

$(document).ready(function () {
    document.getElementById('all-s').checked = true;
    document.getElementById('all-l').checked = true;
});

//rb weight
function vrijedsnotRadio() {

    const checksParent = (window.innerWidth < 991) ? document.getElementById('weight-small') : document.getElementById('weight-large');
    const radios = checksParent.querySelectorAll('input');


    var radio_value = "";
    for (var i = 0; radios[i]; ++i) {
        if (radios[i].checked) {
            radio_value = radios[i].value;
        }
    }
    return radio_value;
}


//don't increase limit by filtering pets
function reduceLimit() {
    limit -= 3;
}

//                              FILTER END


//delete pet by ID - click on x
function deletePet(id) {
    var http = new XMLHttpRequest();
    var method = "GET";
    var url = "api/pet/deletePet.php?id=" + id;
    var asynchronous = true;

    http.open(method, url, asynchronous);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.send();
    loadData();
}

//add new pet - expanded
function addPet() {

    var form = document.getElementById('pokupiFormu');
    var formData = new FormData(form);

    var http = new XMLHttpRequest();
    var method = form.getAttribute('method');
    var url = form.getAttribute('action');
    var asynchronous = true;

    http.open(method, url, asynchronous);
    http.send(formData);

    http.onload = function () {
        var data = JSON.parse(this.responseText);
        console.log(data);
        close_form();
        window.alert('Successfully added new pet!')
    }
}


//expand add form
function expand() {
    document.getElementById('expanded_form').style.display = "flex";
    document.getElementById('expanded_form').classList.add("animated");
    document.getElementById('expanded_form').classList.add("fadeIn");
    document.getElementById('fiksirajExpand').classList.add("fixed-custom");
    window.scrollTo(0, 0);
}

//close expanded
function close_form() {
    document.getElementById('expanded_form').style.display = "none";
    document.getElementById('fiksirajExpand').classList.remove("fixed-custom");
}

function addFavorite(id) {

    var http = new XMLHttpRequest();
    var method = "POST";
    var url = "api/favoritePet/addFavorite.php";
    var asynchronous = true;
    http.open(method, url, asynchronous);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.send('petID=' + id);

    http.onload = function () {
        var data = JSON.parse(this.responseText);
        loadData();
    }

}

function removeFavorite(id) {

    var http = new XMLHttpRequest();
    var method = "POST";
    var url = "api/favoritePet/removeFavorite.php";
    var asynchronous = true;
    http.open(method, url, asynchronous);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.send('petID=' + id);

    http.onload = function () {
        var data = JSON.parse(this.responseText);
        console.log(data);
        loadData();
    }

}
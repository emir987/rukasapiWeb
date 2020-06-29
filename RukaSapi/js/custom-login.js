function submitFormLogin() {

    var form = document.getElementById('loginForm');
    var formData = new FormData(form);
    var emailError = document.getElementById('emailError');
    var passwordError = document.getElementById('passwordError');

    var http = new XMLHttpRequest();
    var method = "POST";
    var url = 'api/user/login.php';
    var asynchronous = true;

    http.open(method, url, asynchronous);
    http.send(formData);

    http.onload = function () {
        var data = JSON.parse(this.responseText);
        console.log(data);


        if (data.success == 1) {
            window.location.href = "index.php";
        } else {
            emailError.innerText = data.message.emailMessage;
            passwordError.innerText = data.message.passwordMessage;
        }
    }
}
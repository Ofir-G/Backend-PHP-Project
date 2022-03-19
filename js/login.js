(function () {
    'use strict';
    window.addEventListener('load', function () {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

document.getElementById("login-organ").onchange = (function () {

    document.getElementById("login-user").classList.toggle("display-none");
    document.getElementById("login-organization").classList.toggle("display-none");

})

document.getElementById("signup-organ").onchange = (function () {

    document.getElementById("signup-user").classList.toggle("display-none");
    document.getElementById("signup-organization").classList.toggle("display-none");
    document.getElementById("alert-warning").classList.toggle("display-none");

})

function uploadFile(target) {
    $(target).next("label").html(target.files[0].name);
}

$(document).ready(function () {

    $("form").submit(function (e) {

        e.preventDefault();

        var formData = new FormData(this);
        button = $(this).find("button");
        formData.append(button.attr("name"), "true");
        var error = $(this).find(".display-error");
        var form = this;

        $.ajax({
            type: 'post',
            url: 'loginserver.php',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                button.html("Loading...");
            },
            complete: function () {
                button.html("Try again");
            },
            success: function (response) {
                if (response.replace(/\s/g, '').length) {
                    error.html("<ul>" + response + "</ul>");
                    error.css("display", "block");
                } else {
                    if(button.attr("name")=="login-user" || button.attr("name")=="login-organ") {
                        $(".box").replaceWith('<div style="height: 300px; color: black" class="text-center alert alert-success box display-4" role="alert">Log in was successful! <br> Redirecting to home page... </div>');
                    }
                    else{
                        $(".box").replaceWith('<div style="height: 300px; color: black" class="text-center alert alert-success box display-4" role="alert">Sign up was successful! <br> Redirecting to home page... </div>');
                    }

                    setTimeout(function(){
                        window.location.href = "../index.php";
                    }, 3000);
                    console.log("success");
                }
            },
            error: function () {
                console.log("error");
            }
        });
    });
});
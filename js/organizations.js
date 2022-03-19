$(document).ready(function () {

    $(".btn-dark").click(function () {
        if ($(this).html().includes("More")) {
            $(this).html("Show Less");
        } else {
            $(this).html("Read More");
        }
    });

    $('#search').change(function () {
        if ($('#search option:selected').val() == "api") {
            $(".alert-warning").css("display", "block");
        }
        if ($('#search option:selected').val() == "our") {
            $(".alert-warning").css("display", "none");
        }
    });
});
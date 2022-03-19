$(document).ready(function () {

    $("form").submit(function (e) {

        e.preventDefault();

        var formData = new FormData(this);
        formData.append("join", "true");
        var parent = $(this).parent();
        var button = $(this).find(".btn");

        $.ajax({
            type: 'post',
            url: 'join_volunteering.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.replace(/\s/g, '').length) {
                    parent.prev().removeClass("alert-success").addClass("alert-danger");
                    parent.prev().html('You are already registered to this volunteering.')
                    parent.prev().css("display", "block");
                    button.css("display", "none");
                } else {
                    parent.prev().addClass("alert-success").removeClass("alert-danger");
                    var name = parent.prev().html();
                    parent.prev().html('You just joined "' + name + '", thank you!');
                    parent.prev().css("display", "block");
                    button.css("display", "none");
                }
            },
            error: function () {
                console.log("error");
            }
        });
    });
});
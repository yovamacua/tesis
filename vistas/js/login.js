$(function() {
    //creando variables y ocultando campos de error
    $("#error_correo").hide();
    $("#error_password").hide();

    // se ejecuta funcion en el id del control cuando se pierde el foco
    $("#correo").focusout(function() {
        campo_correo();
    });

    $("#password").focusout(function() {
        campo_password();
    });

    function campo_correo() {
        var correo = $("#correo").val().length;
        if (correo <= 0) {
            $("#error_correo").html("Debe completar este campo");
            $("#error_correo").show();
            $("#correo").css("border-bottom", "2px solid #F90A0A");
            $("#error_correo").css("color", "red");
        } else {
            $("#error_correo").hide();
            $("#correo").css("border-bottom", "1px solid #d2d6de");
        }
    }

    function campo_password() {
        var password = $("#password").val().length;
        if (password <= 0) {
            $("#error_password").html("Debe completar este campo");
            $("#error_password").show();
            $("#password").css("border-bottom", "2px solid #F90A0A");
            $("#error_password").css("color", "red");
        } else {
            $("#error_password").hide();
            $("#password").css("border-bottom", "1px solid #d2d6de");
        }
    }
});
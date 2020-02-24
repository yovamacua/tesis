//// INICIO DE VALIDACION DEL FORMULARIO///
// funcion para validar formulario de usuario
$(function() {
    //creando variables y ocultando campos de error
    $("#error_nombre_perfil").hide();
    $("#error_apellido_perfil").hide();
    $("#error_usuario_perfil").hide();
    $("#error_password1_perfil").hide();
    $("#error_password2_perfil").hide();
    $("#error_email_perfil").hide();


    // se declaran variables con valor false para ver si pasa o no la validacion
    var error_nombre_perfil = false;
    var error_apellido_perfil = false;
    var error_usuario_perfil = false;
    var error_password1_perfil = false;
    var error_password2_perfil = false;
    var error_email_perfil = false;
    // se ejecuta funcion en el id del control cuando se pierde el foco
    $("#nombre_perfil").focusout(function() {
        campo_nombre();
    });

    $("#apellido_perfil").focusout(function() {
        campo_apellido();
    });

    $("#usuario_perfil").focusout(function() {
        campo_usuario();
    });

    $("#email_perfil").focusout(function() {
        campo_email();
    });

    $("#password1_perfil").focusout(function() {
        campo_password1();
    });

    $("#password2_perfil").focusout(function() {
        campo_password2();
    });


    // funciones para validar
    function campo_password1() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9\s]*$/;
        var pass11 = $("#password1_perfil").val();
        if (pattern.test(pass11)) {
            $("#error_password1_perfil").hide();
            $("#password1_perfil").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_password1_perfil").html("Contraseña no valida");
            $("#error_password1_perfil").css("position", "absolute");
            $("#error_password1_perfil").css("color", "red");
            $("#error_password1_perfil").show();
            $("#password1_perfil").css("border-bottom", "2px solid #F90A0A");
            error_password1_perfil = true;
        }

    }

    function campo_password2() {
        var pass1 = $("#password1_perfil").val()
        var pass2 = $("#password2_perfil").val();
        if (pass1 !== pass2) {
            $("#error_password2_perfil").html("Contraseñas no coinciden");
            $("#error_password2_perfil").show();
            $("#password2_perfil").css("border-bottom", "2px solid #F90A0A");
            $("#error_password2_perfil").css("color", "red");
            error_password2_perfil = true;
        } else {
            $("#error_password2_perfil").hide();
            $("#password2_perfil").css("border-bottom", "2px solid #34F458");
        }

        var pass2 = $("#password2_perfil").val().length;
        if (pass2 <= 0) {
            $("#error_password2_perfil").html("No se permiten campos vacios");
            $("#error_password2_perfil").css("position", "absolute");
            $("#error_password2_perfil").css("color", "red");
            $("#error_password2_perfil").show();
            $("#password2_perfil").css("border-bottom", "2px solid #F90A0A");
            error_password2_perfil = true;
        }
    }

    function campo_email() {
        var pattern = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        var email = $("#email_perfil").val();
        if (pattern.test(email) && email !== '') {
            $("#error_email_perfil").hide();
            $("#email_perfil").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_email_perfil").html("Correo no valido");
            $("#error_email_perfil").show();
            $("#error_email_perfil").css("border-bottom", "2px solid #F90A0A");
            $("#error_email_perfil").css("color", "red");
            error_email_perfil = true;
        }
    }

    function campo_usuario() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9\s]*$/;
        var usuario = $("#usuario_perfil").val();
        if (pattern.test(usuario) && usuario !== '') {
            $("#error_usuario_perfil").hide();
            $("#usuario_perfil").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_usuario_perfil").html("Solo letras se permiten letras y numeros");
            $("#error_usuario_perfil").css("position", "absolute");
            $("#error_usuario_perfil").css("color", "red");
            $("#error_usuario_perfil").show();
            $("#usuario_perfil").css("border-bottom", "2px solid #F90A0A");
            error_usuario_perfil = true;
        }
        var usuario = $("#usuario_perfil").val().length;
        if (usuario <= 0) {
            $("#error_usuario_perfil").html("No se permiten campos vacios");
            $("#error_usuario_perfil").css("position", "absolute");
            $("#error_usuario_perfil").css("color", "red");
            $("#error_usuario_perfil").show();
            $("#usuario_perfil").css("border-bottom", "2px solid #F90A0A");
            error_usuario_perfil = true;
        }
    }

    function campo_nombre() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ\s]*$/;
        var nombre = $("#nombre_perfil").val();
        if (pattern.test(nombre) && nombre !== '') {
            $("#error_nombre_perfil").hide();
            $("#nombre_perfil").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_nombre_perfil").html("Solo letras se permiten letras");
            $("#error_nombre_perfil").css("position", "absolute");
            $("#error_nombre_perfil").css("color", "red");
            $("#error_nombre_perfil").show();
            error_nombre_perfil = true;
        }
        var nombre = $("#nombre_perfil").val().length;
        if (nombre <= 0) {
            $("#error_nombre_perfil").html("No se permiten campos vacios");
            $("#error_nombre_perfil").css("position", "absolute");
            $("#error_nombre_perfil").css("color", "red");
            $("#error_nombre_perfil").show();
            $("#nombre_perfil").css("border-bottom", "2px solid #F90A0A");
            error_nombre_perfil = true;
        }
    }

    function campo_apellido() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ\s]*$/;
        var apellido = $("#apellido_perfil").val();
        if (pattern.test(apellido) && apellido !== '') {
            $("#error_apellido_perfil").hide();
            $("#apellido_perfil").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_apellido_perfil").html("Solo letras se permiten letras");
            $("#error_apellido_perfil").css("position", "absolute");
            $("#error_apellido_perfil").css("color", "red");
            $("#error_apellido_perfil").show();
            $("#apellido_perfil").css("border-bottom", "2px solid #F90A0A");
            error_apellido_perfil = true;
        }
        var apellido = $("#apellido_perfil").val().length;
        if (apellido <= 0) {
            $("#error_apellido_perfil").html("No se permiten campos vacios");
            $("#error_apellido_perfil").css("position", "absolute");
            $("#error_apellido_perfil").css("color", "red");
            $("#error_apellido_perfil").show();
            $("#apellido_perfil").css("border-bottom", "2px solid #F90A0A");
            error_apellido = true;
        }
    }

    // se valida el formulario
    $("#perfil_form").on("submit", function(e) {
        // asignacion de valor a vaiables
        error_nombre_perfil = false;
        error_apellido_perfil = false;
        error_usuario_perfil = false;
        error_email_perfil = false;
        error_password1_perfil = false;
        error_password2_perfil = false;

        // se invoca a las funciones para tener el valor de las variables
        campo_nombre();
        campo_apellido();
        campo_usuario();
        campo_email();
        campo_password1();
        campo_password2();


        //comparacion
        if (error_nombre_perfil === false &&
            error_apellido_perfil === false &&
            error_usuario_perfil === false &&
            error_email_perfil === false &&
            error_password1_perfil === false &&
            error_password2_perfil === false) {
            // si todo funciona las barrita de color boton se reseta despues del submit
            $("#nombre_perfil").css("border-bottom", "1px solid #d2d6de");
            $("#apellido_perfil").css("border-bottom", "1px solid #d2d6de");
            $("#usuario_perfil").css("border-bottom", "1px solid #d2d6de");
            $("#password1_perfil").css("border-bottom", "1px solid #d2d6de");
            $("#password2_perfil").css("border-bottom", "1px solid #d2d6de");
            $("#email_perfil").css("border-bottom", "1px solid #d2d6de");
            editar_perfil(e);
        } else {
            // se muestra un mensaje si los campos no estan correctos
            bootbox.alert("Complete/Revise los campos");
            return false;
        }
    });
});

function limpiar() {
    $("#error_nombre_perfil").hide();
    $("#error_apellido_perfil").hide();
    $("#error_usuario_perfil").hide();
    $("#error_password1_perfil").hide();
    $("#error_password2_perfil").hide();
    $("#error_email_perfil").hide();
    $("#nombre_perfil").css("border-bottom", "1px solid #d2d6de");
    $("#apellido_perfil").css("border-bottom", "1px solid #d2d6de");
    $("#usuario_perfil").css("border-bottom", "1px solid #d2d6de");
    $("#password1_perfil").css("border-bottom", "1px solid #d2d6de");
    $("#password2_perfil").css("border-bottom", "1px solid #d2d6de");
    $("#email_perfil").css("border-bottom", "1px solid #d2d6de");

}

//MOSTRAR PERFIL DE USUARIO
function mostrar_perfil(id_usuario_perfil) {
    $.post("../controlador/perfil.php?op=mostrar_perfil", {
        id_usuario_perfil: id_usuario_perfil
    }, function(data, status) {
        var cero = '123456axxxxx';
        data = JSON.parse(data);
        $('#perfilModal').modal('show');
        $('.ofield').hide();
        $('.ofield2').show();
        $('#nombre_perfil').val(data.nombre);
        $('#apellido_perfil').val(data.apellido);
        $('#usuario_perfil').val(data.usuario_perfil);
        $('#password1_perfil').val(cero);
        $('#password2_perfil').val(cero);
        $('#email_perfil').val(data.correo);
        $("#upload_usuario_imagen").show();
        $(".group-span-filestyle .badge").hide();
        $('#upload_usuario_imagen').html(data.usuario_imagen);
        $('.modal-title').text("Editar Información");
        $('#id_usuario_perfil').val(id_usuario_perfil);
        $('#action').val("Edit");
        $('#operation').val("Edit");
        limpiar();
    });
}


function retorno() {
    window.location = "../vistas/mi_perfil.php?m=1";
}

function editar_pass(id_usuario_perfil) {
    $.post("../controlador/perfil.php?op=mostrar_perfil", {
        id_usuario_perfil: id_usuario_perfil
    }, function(data, status) {
        data = JSON.parse(data);

        $('#perfilModal').modal('show');
        $('.ofield').show();
        $('.ofield2').hide();
        $('#nombre_perfil').val(data.nombre);
        $('#apellido_perfil').val(data.apellido);
        $('#usuario_perfil').val(data.usuario_perfil);
        $('#password1_perfil').val("");
        $('#password2_perfil').val("");
        $('#email_perfil').val(data.correo);
        $('.modal-title').text("Cambiar Contraseña");
        $('#id_usuario_perfil').val(id_usuario_perfil);
        $('#action').val("Edit");
        $('#operation').val("Edit");
        limpiar();
    });
}
//EDITAR PERFIL

//la funcion guardaryeditar(e); se llama cuando se da click al boton submit
function editar_perfil(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#perfil_form")[0]);
    var password1 = $("#password1_perfil").val();
    var password2 = $("#password2_perfil").val();

    if (password1 == password2) {

        $.ajax({
            url: "../controlador/perfil.php?op=editar_perfil",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,

            success: function(datos) {

                $('#perfilModal').modal('hide');
                retorno();
            }
        });
    } //cierre del condicional
}

//validar que es un imagen
function validarImagen(obj) {
    var uploadFile = obj.files[0];
    $(".group-span-filestyle .badge").show();
    if (!window.FileReader) {
       bootbox.alert("El navegador no soporta la lectura de archivo");
        return;
    }
    if (!(/\.(jpg|png)$/i).test(uploadFile.name)) {
        bootbox.alert("El formato de imagen no es válido");
        $('#usuario_imagen').val("");
        $(".group-span-filestyle .badge").hide();
    } else {
        var img = new Image();
        img.onload = function() {
            if (uploadFile.size > 1000000) {
                bootbox.alert("El peso de la imagen no puede ser mayor a 1 MB");
                $('#usuario_imagen').val("");
                $(".group-span-filestyle .badge").hide();
            }
        };
        img.src = URL.createObjectURL(uploadFile);
    }
}

function quitar_imagen() {
    {
        bootbox.confirm("¿Está seguro de eliminar la imagen de usuario?", function(result) {
            if (result) {
                window.location = "../controlador/perfil.php?op=quitar_imagen";
            }
        });
    }


}
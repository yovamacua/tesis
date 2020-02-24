var tabla;

//// INICIO DE VALIDACION DEL FORMULARIO///
// funcion para validar formulario de usuario
$(function() {
    //creando variables y ocultando campos de error
    $("#error_nombre").hide();
    $("#error_apellido").hide();
    $("#error_usuario").hide();
    $("#error_cargo").hide();
    $("#error_email").hide();
    $("#error_password1").hide();
    $("#error_password2").hide();
    $("#error_estado").hide();
    //$("#error_permisos").hide();

    // se declaran variables con valor false para ver si pasa o no la validacion
    var error_nombre = false;
    var error_apellido = false;
    var error_usuario = false;
    var error_cargo = false;
    var error_email = false;
    var error_password1 = false;
    var error_password2 = false;
    var error_estado = false;
    var error_permisos=false;
    // se ejecuta funcion en el id del control cuando se pierde el foco
    $("#nombre").focusout(function() {
        campo_nombre();
    });

    $("#apellido").focusout(function() {
        campo_apellido();
    });

    $("#usuario").focusout(function() {
        campo_usuario();
    });

    $("#cargo").focusout(function() {
        campo_cargo();
    });

    $("#email").focusout(function() {
        campo_email();
    });

    $("#password1").focusout(function() {
        campo_password1();
    });

    $("#password2").focusout(function() {
        campo_password2();
    });

    $("#estado").focusout(function() {
        campo_estado();
    });
    /* $("#permisos").focusout(function() {
        ISchekbox();
    });*/

    // funciones para validar
    function campo_estado() {
        var estado = document.getElementById("estado").value;
        if (estado.length <= 0) {
            $("#error_estado").html("Debe seleccionar una estado");
            $("#error_estado").css("color", "red");
            $("#error_estado").show();
            error_cargo = true;
        } else {
            $("#error_estado").hide();
            var error_estado = false;
        }
    }

    function campo_password1() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9\s]*$/;
        var pass11 = $("#password1").val();
        if (pattern.test(pass11)) {
            $("#error_password1").hide();
            $("#password1").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_password1").html("Contraseña no valida");
            $("#error_password1").css("position", "absolute");
            $("#error_password1").css("color", "red");
            $("#error_password1").show();
            $("#password1").css("border-bottom", "2px solid #F90A0A");
            error_password1 = true;
        }

        var pass11 = $("#password1").val().length;
        if (pass11 <= 5) {
            $("#error_password1").html("Minimo 6 caracteres");
            $("#error_password1").css("position", "absolute");
            $("#error_password1").css("color", "red");
            $("#error_password1").show();
            $("#password1").css("border-bottom", "2px solid #F90A0A");
            error_password1 = true;
        }

    }

    function campo_password2() {
        var pass1 = $("#password1").val()
        var pass2 = $("#password2").val();
        if (pass1 !== pass2) {
            $("#error_password2").html("Contraseñas no coinciden");
            $("#error_password2").show();
            $("#password2").css("border-bottom", "2px solid #F90A0A");
            $("#error_password2").css("color", "red");
            error_password2 = true;
        } else {
            $("#error_password2").hide();
            $("#password2").css("border-bottom", "2px solid #34F458");
        }

        var pass2 = $("#password2").val().length;
        if (pass2 <= 0) {
            $("#error_password2").html("No se permiten campos vacios");
            $("#error_password2").css("position", "absolute");
            $("#error_password2").css("color", "red");
            $("#error_password2").show();
            $("#password2").css("border-bottom", "2px solid #F90A0A");
            error_password2 = true;
        }
    }

    function campo_email() {
        var pattern = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        var email = $("#email").val();
        if (pattern.test(email) && email !== '') {
            $("#error_email").hide();
            $("#email").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_email").css("position", "absolute");
            $("#error_email").html("Correo no valido");
            $("#error_email").show();
            $("#email").css("border-bottom", "2px solid #F90A0A");
            $("#error_email").css("color", "red");
            error_email = true;
        }
    }

    function campo_cargo() {
        var cargo = document.getElementById("cargo").value;
        if (cargo.length <= 0) {
            $("#error_cargo").html("Debe seleccionar una cargo");
            $("#error_cargo").css("position", "absolute");
            $("#error_cargo").css("color", "red");
            $("#error_cargo").show();
            error_cargo = true;
        } else {
            $("#error_cargo").hide();
            var error_cargo = false;
        }
    }

    function campo_usuario() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9\s]*$/;
        var usuario = $("#usuario").val();
        if (pattern.test(usuario) && usuario !== '') {
            $("#error_usuario").hide();
            $("#usuario").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_usuario").html("Solo letras se permiten letras y numeros");
            $("#error_usuario").css("position", "absolute");
            $("#error_usuario").css("color", "red");
            $("#error_usuario").show();
            $("#usuario").css("border-bottom", "2px solid #F90A0A");
            error_usuario = true;
        }
        var usuario = $("#usuario").val().length;
        if (usuario <= 0) {
            $("#error_usuario").html("No se permiten campos vacios");
            $("#error_usuario").css("position", "absolute");
            $("#error_usuario").css("color", "red");
            $("#error_usuario").show();
            $("#usuario").css("border-bottom", "2px solid #F90A0A");
            error_usuario = true;
        }
    }

    function campo_nombre() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ\s]*$/;
        var nombre = $("#nombre").val();
        if (pattern.test(nombre) && nombre !== '') {
            $("#error_nombre").hide();
            $("#nombre").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_nombre").html("Solo se permiten letras");
            $("#error_nombre").css("position", "absolute");
            $("#error_nombre").css("color", "red");
            $("#error_nombre").show();
            $("#nombre").css("border-bottom", "2px solid #F90A0A");
            error_nombre = true;
        }
        var nombre = $("#nombre").val().length;
        if (nombre <= 0) {
            $("#error_nombre").html("No se permiten campos vacios");
            $("#error_nombre").css("position", "absolute");
            $("#error_nombre").css("color", "red");
            $("#error_nombre").show();
            $("#nombre").css("border-bottom", "2px solid #F90A0A");
            error_nombre = true;
        }
    }

    function campo_apellido() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ\s]*$/;
        var apellido = $("#apellido").val();
        if (pattern.test(apellido) && apellido !== '') {
            $("#error_apellido").hide();
            $("#apellido").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_apellido").html("Solo se permiten letras");
            $("#error_apellido").css("position", "absolute");
            $("#error_apellido").css("color", "red");
            $("#error_apellido").show();
            $("#apellido").css("border-bottom", "2px solid #F90A0A");
            error_apellido = true;
        }
        var apellido = $("#apellido").val().length;
        if (apellido <= 0) {
            $("#error_apellido").html("No se permiten campos vacios");
            $("#error_apellido").css("position", "absolute");
            $("#error_apellido").css("color", "red");
            $("#error_apellido").show();
            $("#apellido").css("border-bottom", "2px solid #F90A0A");
            error_apellido = true;
        }
    }

    // se valida el formulario
    $("#usuario_form").on("submit", function(e) {
        // asignacion de valor a vaiables
        error_nombre = false;
        error_apellido = false;
        error_usuario = false;
        error_cargo = false;
        error_email = false;
        error_password1 = false;
        error_password2 = false;
        error_estado = false;
        //error_permisos= false;
       

        // se invoca a las funciones para tener el valor de las variables
        campo_nombre();
        campo_apellido();
        campo_usuario();
        campo_cargo();
        campo_email();
        campo_password1();
        campo_password2();
        campo_estado();
       // ISchekbox();

        //comparacion
        if (error_nombre === false &&
            error_apellido === false &&
            error_usuario === false &&
            error_cargo === false &&
            error_email === false &&
            error_cargo === false &&
            error_password1 === false &&
            error_password2 === false &&
            error_estado === false) {
            // si todo funciona las barrita de color boton se reseta despues del submit
            $("#password1").css("border-bottom", "1px solid #d2d6de");
            $("#password2").css("border-bottom", "1px solid #d2d6de");
            $("#email").css("border-bottom", "1px solid #d2d6de");
            $("#usuario").css("border-bottom", "1px solid #d2d6de");
            $("#nombre").css("border-bottom", "1px solid #d2d6de");
            $("#apellido").css("border-bottom", "1px solid #d2d6de");
             //$("#permisos").css("border-bottom", "1px solid #d2d6de");
           
            guardaryeditar(e);
        } else {
            // se muestra un mensaje si los campos no estan correctos
            bootbox.alert("Complete/Revise los campos");
            return false;
        }
    });
});

// FIN VALIDACION FORMULARIO
//Función que se ejecuta al inicio
function init() {
    listar();
    //cambia el titulo de la ventana modal cuando se da click al boton
    $("#add_button").click(function() {
        $(".modal-title").text("Agregar Usuario");
        $(".ofield").show();
        $(".ofield2").show();
         $(".ofields").show();
    });
    //Mostramos los permisos
     /*en este caso NO se envia un id_usuario ya que se va agregar un 
     usuario nuevo, solo se enviaría cuando se edita y ahí se enviaría el id_usuario
     que se está editando*/
     $.post("../controlador/usuario.php?op=permisos&id_usuario=",function(r){
          $("#permisos").html(r);
   });
}

//funcion para limpiar los campos del formulario
function limpiar() {
    $('#nombre').val("");
    $('#apellido').val("");
    $('#cargo').val("");
    $('#usuario').val("");
    $('#password1').val("");
    $('#password2').val("");
    $('#email').val("");
    $('#estado').val("");
    $('#id_usuario').val("");
    /** limpiado validacion al perder foco **/
    $("#error_nombre").hide();
    $("#error_apellido").hide();
    $("#error_usuario").hide();
    $("#error_cargo").hide();
    $("#error_email").hide();
    $("#error_password1").hide();
    $("#error_password2").hide();
    $("#error_estado").hide();
    $("#password1").css("border-bottom", "1px solid #d2d6de");
    $("#password2").css("border-bottom", "1px solid #d2d6de");
    $("#email").css("border-bottom", "1px solid #d2d6de");
    $("#usuario").css("border-bottom", "1px solid #d2d6de");
    $("#nombre").css("border-bottom", "1px solid #d2d6de");
    $("#apellido").css("border-bottom", "1px solid #d2d6de");
     //limpia los checkbox
  $('input:checkbox').removeAttr('checked');
}

//function listar
function listar() {

    tabla = $('#usuario_data').dataTable({
        "aProcessing": true, //Activamos el procesamiento del datatables
        "aServerSide": true, //Paginación y filtrado realizados por el servidor
        "bStateSave": true,
        dom: 'Bfrtip', //Definimos los elementos del control de tabla

        buttons: [ //formato de los tipo de documento a generar
            /*'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf' */
        ],

        "ajax": {
            //configuracion de donde se obtienen los datos
            url: '../controlador/usuario.php?op=listar',
            type: "get",
            dataType: "json",
            error: function(e) {
                console.log(e.responseText);
            }
        },

        "bDestroy": true,
        "responsive": true,
        "bInfo": true,
        "iDisplayLength": 10, //Por cada 10 registros hace una paginación
        "order": [
            [0, "desc"]
        ], //Ordenar (columna,orden)
        //configuraciones para el lenguaje del dataTable
        "language": {

            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },

            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }

        } //cerrando language
    }).DataTable();
}

//Mostrar datos del usuario en la ventana modal del formulario
function pass(id_usuario) {
    $.post("../controlador/usuario.php?op=mostrar", {
        id_usuario: id_usuario
    }, function(data, status) {
        //analiza una cadena de texto como json
        data = JSON.parse(data);
        var nm = data.nombre;
        $('.ofields').hide();
        $('.ofield').hide();
        $('.ofield2').show();
        //evento para ventana modal
        $('#nombre').val(data.nombre);
        $('#apellido').val(data.apellido);
        $('#cargo').val(data.idperfiles);
        $('#usuario').val(data.usuario);
        $("#usuarioModal").modal("show");
        $('#password1').val("");
        $('#password2').val("");
        $('#email').val(data.correo);
        $('#estado').val(data.estado);
        $('.modal-title').text("Cambiar contraseña de usuario: " + nm);
        $('#id_usuario').val(id_usuario);
        $('#action').val("Edit");
    });
}
//Mostrar datos del usuario en la ventana modal del formulari

//Mostrar datos del usuario en la ventana modal del formulario
function mostrar(id_usuario) {
    $.post("../controlador/usuario.php?op=mostrar", {
        id_usuario: id_usuario
    }, function(data, status) {
        var cero = '123456axxxxx';
        //analiza una cadena de texto como json
        data = JSON.parse(data);
        var nm = data.nombre;
        //evento para ventana modal
        $("#usuarioModal").modal("show");
        $('.ofield').show();
        $('.ofield2').hide();
         $('.ofields').show();
        //valor del formulario
        $('#nombre').val(data.nombre);
        $('#apellido').val(data.apellido);
        $('#cargo').val(data.idperfiles);
        $('#usuario').val(data.usuario);
        $('#password1').val(cero);
        $('#password2').val(cero);
        $('#email').val(data.correo);
        $('#estado').val(data.estado);
        $('.modal-title').text("Editar Usuario: " + nm);
        $('#id_usuario').val(id_usuario);
        $('#action').val("Edit");
    });
   

}


//la funcion guardaryeditar(e); se llama cuando se da click al boton submit
function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
   // bootbox.confirm("¿Está seguro registar el nuevo usuario?", function(result){
       // if(result){
    var formData = new FormData($("#usuario_form")[0]);
    var password1 = $("#password1").val();
    var password2 = $("#password2").val();

    //si el password conincide entonces se envia el formulario
    if (password1 == password2) {
        $.ajax({
            url: "../controlador/usuario.php?op=guardaryeditar",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(datos) {

                $('#usuario_form')[0].reset();
                $('#usuarioModal').modal('hide');
                $('#resultados_ajax').html(datos);
                $('#usuario_data').DataTable().ajax.reload( null, false );
                limpiar();
            }
        });

    } //cierre de la validacion
    else {
        bootbox.alert("No coincide el password");
    }
//}
   // });//bootbox
}

//EDITAR ESTADO DEL USUARIO
//importante:id_usuario, est se envia por post via ajax
function cambiarEstado(id_usuario, est) {
    bootbox.confirm("¿Está seguro de cambiar de estado?", function(result) {
        if (result) {
            $.ajax({
                url: "../controlador/usuario.php?op=activarydesactivar",
                method: "POST",
                //toma el valor del id y del estado
                data: {
                    id_usuario: id_usuario,
                    est: est
                },
                success: function(data) {
                    $('#usuario_data').DataTable().ajax.reload( null, false);
                }
            });
        }
    }); //bootbox
}

//ELIMINAR USUARIO

function eliminar(id_usuario) {

    bootbox.confirm("¿Está seguro de eliminar el usuario?", function(result) {
        if (result) {

            $.ajax({
                url: "../controlador/usuario.php?op=eliminar_usuario",
                method: "POST",
                data: {
                    id_usuario: id_usuario
                },

                success: function(data) {
                    //alert(data);
                    $("#resultados_ajax").html(data);
                    $("#usuario_data").DataTable().ajax.reload( null, false);
                }
            });

        }

    }); //bootbox
}

init();
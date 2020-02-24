var tabla;

//// INICIO DE VALIDACION DEL FORMULARIO///
// funcion para validar formulario de usuario
$(function() {

    //creando variables y ocultando campos de error
    $("#error_nombrecuenta").hide();
    $("#error_objetivo").hide();
    $("#error_estrategia").hide();


    // se declaran variables con valor false para ver si pasa o no la validacion
    var error_nombrecuenta = false;
    var error_objetivo = false;
    var error_estrategia = false;


    // se ejecuta funcion en el id del control cuando se pierde el foco
    $("#nombrecuenta").focusout(function() {
        campo_nombrecuenta();
    });

    $("#objetivo").focusout(function() {
        campo_objetivo();
    });

    $("#estrategia").focusout(function() {
        campo_estrategia();
    });

    //funciones
    function campo_nombrecuenta() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9.:,¿?!¡\s]*$/;
        var nombrecuenta = $("#nombrecuenta").val();
        if (pattern.test(nombrecuenta) && nombrecuenta !== '') {
            $("#error_nombrecuenta").hide();
            $("#nombrecuenta").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_nombrecuenta").html("Solo se permiten letras, numeros y los simbolos . : , ¿ ? ! ¡");
            $("#error_nombrecuenta").css("position", "absolute");
            $("#error_nombrecuenta").css("color", "red");
            $("#error_nombrecuenta").show();
            $("#nombrecuenta").css("border-bottom", "2px solid #F90A0A");
            error_nombrecuenta = true;
        }
        var nombrecuenta = $("#nombrecuenta").val().length;
        if (nombrecuenta <= 0) {
            $("#error_nombrecuenta").html("No se permiten campos vacios");
            $("#error_nombrecuenta").css("position", "absolute");
            $("#error_nombrecuenta").css("color", "red");
            $("#error_nombrecuenta").show();
            $("#nombrecuenta").css("border-bottom", "2px solid #F90A0A");
            error_nombrecuenta = true;
        }
    }

    function campo_objetivo() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9.:,¿?!¡\s]*$/;
        var objetivo = $("#objetivo").val();
        if (pattern.test(objetivo) && objetivo !== '') {
            $("#error_objetivo").hide();
            $("#objetivo").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_objetivo").html("Solo se permiten letras, numeros y los simbolos . : , ¿ ? ! ¡");
            $("#error_objetivo").css("position", "absolute");
            $("#error_objetivo").css("color", "red");
            $("#error_objetivo").show();
            $("#objetivo").css("border-bottom", "2px solid #F90A0A");
            error_objetivo = true;
        }
        var objetivo = $("#objetivo").val().length;
        if (objetivo <= 0) {
            $("#error_objetivo").html("No se permiten campos vacios");
            $("#error_objetivo").css("position", "absolute");
            $("#error_objetivo").css("color", "red");
            $("#error_objetivo").show();
            $("#objetivo").css("border-bottom", "2px solid #F90A0A");
            error_objetivo = true;
        }
    }

    function campo_estrategia() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9.:,¿?!¡\s]*$/;
        var estrategia = $("#estrategia").val();
        if (pattern.test(estrategia) && estrategia !== '') {
            $("#error_estrategia").hide();
            $("#estrategia").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_estrategia").html("Solo se permiten letras, numeros y los simbolos . : , ¿ ? ! ¡");
            $("#error_estrategia").css("position", "absolute");
            $("#error_estrategia").css("color", "red");
            $("#error_estrategia").show();
            $("#estrategia").css("border-bottom", "2px solid #F90A0A");
            error_estrategia = true;
        }
        var estrategia = $("#estrategia").val().length;
        if (estrategia <= 0) {
            $("#error_estrategia").html("No se permiten campos vacios");
            $("#error_estrategia").css("position", "absolute");
            $("#error_estrategia").css("color", "red");
            $("#error_estrategia").show();
            $("#estrategia").css("border-bottom", "2px solid #F90A0A");
            error_estrategia = true;
        }
    }


    // se valida el formulario
    $("#cuenta_form").on("submit", function(e) {

        // asignacion de valor a vaiables
        error_nombrecuenta = false;
        error_objetivo = false;
        error_estrategia = false;

        // se invoca a las funciones para tener el valor de las variables
        campo_nombrecuenta();
        campo_estrategia();
        campo_objetivo();

        //comparacion
        if (error_nombrecuenta === false &&
            error_objetivo === false &&
            error_estrategia === false) {
            // si todo funciona las barrita de color boton se reseta despues del submit
            $("#nombrecuenta").css("border-bottom", "1px solid #d2d6de");
            $("#objetivo").css("border-bottom", "1px solid #d2d6de");
            $("#estrategia").css("border-bottom", "1px solid #d2d6de");
            guardaryeditar(e);
        } else {

            // se muestra un mensaje si los campos no estan correctos
            alert("Complete/Revise los campos");
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
        $(".modal-title").text("Agregar una cuenta");
    });
}

function limpiar() {
    $('#nombrecuenta').val("");
    $('#objetivo').val("");
    $('#estrategia').val("");
    $('#id_cuenta').val("");

    /** reinicia validacion al perder el foco **/
    $("#error_nombrecuenta").hide();
    $("#error_objetivo").hide();
    $("#error_estrategia").hide();
    $("#nombrecuenta").css("border-bottom", "1px solid #d2d6de");
    $("#objetivo").css("border-bottom", "1px solid #d2d6de");
    $("#estrategia").css("border-bottom", "1px solid #d2d6de");
}

//Función Listar
function listar() {
    tabla = $('#cuenta_data').dataTable({
        "aProcessing": true, //Activamos el procesamiento del datatables
        "aServerSide": true, //Paginación y filtrado realizados por el servidor
          "bStateSave": true,
        dom: 'Bfrtip', //Definimos los elementos del control de tabla
        buttons: [
            /* 'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf' */
        ],
        "ajax": {
            url: '../controlador/cuenta.php?op=listar',
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

//funcion para mostrar la informacion en la tabla
function mostrar(id_cuenta) {
    $.post("../controlador/cuenta.php?op=mostrar", {
        id_cuenta: id_cuenta
    }, function(data, status) {
        data = JSON.parse(data);

        $('#cuentaModal').modal('show');
        $('#nombrecuenta').val(data.nombrecuenta);
        $('#objetivo').val(data.objetivo);
        $('#estrategia').val(data.estrategia);
        $('.modal-title').text("Editar cuenta");
        $('#id_cuenta').val(id_cuenta);
        $('#action').val("Edit");
    });
}


//la funcion guardaryeditar(e); se llama cuando se da click al boton submit
function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    var formData = new FormData($("#cuenta_form")[0]);

    $.ajax({
        url: "../controlador/cuenta.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos) {
            console.log(datos);
            $('#cuenta_form')[0].reset();
            $('#cuentaModal').modal('hide');
            $('#resultados_ajax').html(datos);
            $('#cuenta_data').DataTable().ajax.reload( null, false );
            limpiar();
        }

    });

}

//funcion para eliminar la información de la cuenta
function eliminar(id_cuenta) {

    bootbox.confirm("¿Está seguro de eliminar la cuenta?", function(result) {
        if (result) {
            $.ajax({
                url: "../controlador/cuenta.php?op=eliminar_cuenta",
                method: "POST",
                data: {
                    id_cuenta: id_cuenta
                },

                success: function(data) {
                    $("#resultados_ajax").html(data);
                    $("#cuenta_data").DataTable().ajax.reload( null, false);
                }
            });
        }
    }); //bootbox
}

init();
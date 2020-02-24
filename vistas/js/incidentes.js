var tabla;

//// INICIO DE VALIDACION DEL FORMULARIO///
// funcion para validar formulario de usuario
$(function() {
    //creando variables y ocultando campos de error
    $("#error_titulo").hide();
    $("#error_descripcion").hide();
    $("#error_fecha").hide();


    // se declaran variables con valor false para ver si pasa o no la validacion
    var error_titulo = false;
    var error_descripcion = false;
    var error_fecha = false;

    // se ejecuta funcion en el id del control cuando se pierde el foco
    $("#titulo").focusout(function() {
        campo_titulo();
    });

    $("#descripcion").focusout(function() {
        campo_descripcion();
    });

    $("#fecha").focusout(function() {
        campo_fecha();
    });


    // funciones para validar
    function campo_fecha() {
        var fecha = document.getElementById("fecha").value;
        if (fecha.length <= 0) {
            $("#error_fecha").html("Debe colocar una fecha");
            $("#error_fecha").css("color", "red");
            $("#error_fecha").show();
            error_fecha = true;
        } else {
            $("#error_fecha").hide();
            $("#fecha").css("border-bottom", "2px solid #34F458");
            var error_fecha = false;
        }
    }


    function campo_descripcion() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9.:,¿?!¡\s]*$/;
        var descripcion = $("#descripcion").val();
        if (pattern.test(descripcion) && descripcion !== '') {
            $("#error_descripcion").hide();
            $("#descripcion").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_descripcion").html("Solo se permiten letras, numeros y los simbolos . : , ¿ ? ! ¡");
            $("#error_descripcion").css("position", "absolute");
            $("#error_descripcion").css("color", "red");
            $("#error_descripcion").show();
            $("#descripcion").css("border-bottom", "2px solid #F90A0A");
            error_descripcion = true;
        }
        var descripcion = $("#descripcion").val().length;
        if (descripcion <= 0) {
            $("#error_descripcion").html("No se permiten campos vacios");
            $("#error_descripcion").css("position", "absolute");
            $("#error_descripcion").css("color", "red");
            $("#error_descripcion").show();
            $("#descripcion").css("border-bottom", "2px solid #F90A0A");
            error_descripcion = true;
        }
    }

    function campo_titulo() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9.:,¿?!¡\s]*$/;
        var titulo = $("#titulo").val();
        if (pattern.test(titulo) && titulo !== '') {
            $("#error_titulo").hide();
            $("#titulo").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_titulo").html("Solo se permiten letras, numeros y los simbolos . : , ¿ ? ! ¡");
            $("#error_titulo").css("position", "absolute");
            $("#error_titulo").css("color", "red");
            $("#error_titulo").show();
            $("#titulo").css("border-bottom", "2px solid #F90A0A");
            error_titulo = true;
        }
        var titulo = $("#titulo").val().length;
        if (titulo <= 0) {
            $("#error_titulo").html("No se permiten campos vacios");
            $("#error_titulo").css("position", "absolute");
            $("#error_titulo").css("color", "red");
            $("#error_titulo").show();
            $("#titulo").css("border-bottom", "2px solid #F90A0A");
            error_titulo = true;
        }
    }

    // se valida el formulario
    $("#incidente_form").on("submit", function(e) {
        // asignacion de valor a vaiables
        error_fecha = false;
        error_descripcion = false;
        error_titulo = false;


        // se invoca a las funciones para tener el valor de las variables
        campo_titulo();
        campo_fecha();
        campo_descripcion();


        //comparacion
        if (error_titulo === false &&
            error_descripcion === false &&
            error_fecha === false) {
            // si todo funciona las barrita de color boton se reseta despues del submit
            $("#titulo").css("border-bottom", "1px solid #d2d6de");
            $("#descripcion").css("border-bottom", "1px solid #d2d6de");
            $("#fecha").css("border-bottom", "1px solid #d2d6de");
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
        $(".modal-title").text("Agregar Incidente");
         $('#fecha').datepicker('setDate', 'today');
    });
}

function limpiar() {
    $('#titulo').val("");
    $('#descripcion').val("");
    $('#fecha').val("");
    $('#id_incidente').val("");

    /** reinicia la validacion cuando se sale de la ventana modal **/
    $("#titulo").css("border-bottom", "1px solid #d2d6de");
    $("#descripcion").css("border-bottom", "1px solid #d2d6de");
    $("#fecha").css("border-bottom", "1px solid #d2d6de");
    $("#error_titulo").hide();
    $("#error_descripcion").hide();
    $("#error_fecha").hide();
}

//Función Listar
function listar() {
    tabla = $('#incidente_data').dataTable({
        "aProcessing": true, //Activamos el procesamiento del datatables
        "aServerSide": true, //Paginación y filtrado realizados por el servidor
        "bStateSave": true,
        dom: 'Bfrtip', //Definimos los elementos del control de tabla
        buttons: [
            /* 'copyHtml5',
             'excelHtml5',
             'csvHtml5',
             'pdf'*/
        ],
        "ajax": {
            url: '../controlador/incidente.php?op=listar',
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


function mostrar(id_incidente) {
    $.post("../controlador/incidente.php?op=mostrar", {
        id_incidente: id_incidente
    }, function(data, status) {
        data = JSON.parse(data);

        $('#incidenteModal').modal('show');
        $('#titulo').val(data.titulo);
        $('#descripcion').val(data.descripcion);
        $('#fecha').datepicker('setDate', data.fecha);
        $('.modal-title').text("Editar Incidente");
        $('#id_incidente').val(id_incidente);
        $('#action').val("Edit");

    });
}


//la funcion guardaryeditar(e); se llama cuando se da click al boton submit
function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    var formData = new FormData($("#incidente_form")[0]);

    $.ajax({
        url: "../controlador/incidente.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos) {
            //console.log(datos);
            $('#incidente_form')[0].reset();
            $('#incidenteModal').modal('hide');
            $('#resultados_ajax').html(datos);
            $('#incidente_data').DataTable().ajax.reload( null, false );
            limpiar();

        }

    });

}


function eliminar(id_incidente) {

    //IMPORTANTE: asi se imprime el valor de una funcion
    //alert(categoria_id);

    bootbox.confirm("¿Está seguro de eliminar el incidente?", function(result) {
        if (result) {
            $.ajax({
                url: "../controlador/incidente.php?op=eliminar_incidente",
                method: "POST",
                data: {
                    id_incidente: id_incidente
                },

                success: function(data) {
                    $("#resultados_ajax").html(data);
                    $("#incidente_data").DataTable().ajax.reload( null, false);
                }
            });
        }
    }); //bootbox
}

init();
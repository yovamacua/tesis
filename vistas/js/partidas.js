var tabla;

//// INICIO DE VALIDACION DEL FORMULARIO///
// funcion para validar formulario de usuario
$(function() {
    //creando variables y ocultando campos de error
    $("#error_nombrepartida").hide();
    $("#error_responsable").hide();


    // se declaran variables con valor false para ver si pasa o no la validacion
    var error_nombrepartida = false;
    var error_responsable = false;

    // se ejecuta funcion en el id del control cuando se pierde el foco
    $("#nombrepartida").focusout(function() {
        campo_nombrepartida();
    });

    $("#responsable").focusout(function() {
        campo_responsable();
    });


    function campo_nombrepartida() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9.:,¿?!¡\s]*$/;
        var nombrepartida = $("#nombrepartida").val();
        if (pattern.test(nombrepartida) && nombrepartida !== '') {
            $("#error_nombrepartida").hide();
            $("#nombrepartida").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_nombrepartida").html("Solo se permiten letras, numeros y los simbolos . : , ¿ ? ! ¡");
            $("#error_nombrepartida").css("position", "absolute");
            $("#error_nombrepartida").css("color", "red");
            $("#error_nombrepartida").show();
            $("#nombrepartida").css("border-bottom", "2px solid #F90A0A");
            error_nombrepartida = true;
        }
        var nombrepartida = $("#nombrepartida").val().length;
        if (nombrepartida <= 0) {
            $("#error_nombrepartida").html("No se permiten campos vacios");
            $("#error_nombrepartida").css("position", "absolute");
            $("#error_nombrepartida").css("color", "red");
            $("#error_nombrepartida").show();
            $("#nombrepartida").css("border-bottom", "2px solid #F90A0A");
            error_nombrepartida = true;
        }
    }

    function campo_responsable() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9.:,¿?!¡\s]*$/;
        var responsable = $("#responsable").val();
        if (pattern.test(responsable) && responsable !== '') {
            $("#error_responsable").hide();
            $("#responsable").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_responsable").html("Solo se permiten letras, numeros y los simbolos . : , ¿ ? ! ¡");
            $("#error_responsable").css("position", "absolute");
            $("#error_responsable").css("color", "red");
            $("#error_responsable").show();
            $("#responsable").css("border-bottom", "2px solid #F90A0A");
            error_responsable = true;
        }
        var responsable = $("#responsable").val().length;
        if (responsable <= 0) {
            $("#error_responsable").html("No se permiten campos vacios");
            $("#error_responsable").css("position", "absolute");
            $("#error_responsable").css("color", "red");
            $("#error_responsable").show();
            $("#responsable").css("border-bottom", "2px solid #F90A0A");
            error_responsable = true;
        }
    }

    // se valida el formulario
    $("#partida_form").on("submit", function(e) {
        // asignacion de valor a vaiables
        error_nombrepartida = false;
        error_responsable = false;


        // se invoca a las funciones para tener el valor de las variables
        campo_responsable();
        campo_nombrepartida();


        //comparacion
        if (error_nombrepartida === false &&
            error_responsable === false) {
            // si todo funciona las barrita de color boton se reseta despues del submit
            $("#responsable").css("border-bottom", "1px solid #d2d6de");
            $("#nombrepartida").css("border-bottom", "1px solid #d2d6de");
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
        $(".modal-title").text("Agregar partida");
    });
}

function limpiar() {
    $('#nombrepartida').val("");
    $('#titulo').val("");
    $('#id_partida').val("");

    /** limpiado validacion al perder el foco **/
    $("#error_nombrepartida").hide();
    $("#error_responsable").hide();
    $("#responsable").css("border-bottom", "1px solid #d2d6de");
    $("#nombrepartida").css("border-bottom", "1px solid #d2d6de");
}

//Función Listar
function listar() {
    tabla = $('#partida_data').dataTable({
        "aProcessing": true, //Activamos el procesamiento del datatables
        "aServerSide": true, //Paginación y filtrado realizados por el servidor
        "bStateSave": true,
        dom: 'Bfrtip', //Definimos los elementos del control de tabla
        buttons: [
            /*'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf' */
        ],
        "ajax": {
            url: '../ajax/partida.php?op=listar',
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


function mostrar(id_partida) {
    $.post("../ajax/partida.php?op=mostrar", {
        id_partida: id_partida
    }, function(data, status) {
        data = JSON.parse(data);

        $('#partidaModal').modal('show');
        $('#nombrepartida').val(data.nombrepartida);
        $('#responsable').val(data.responsable);
        $('#anio').val(data.anio);
        $('.modal-title').text("Editar partida");
        $('#id_partida').val(id_partida);
        $('#action').val("Edit");
    });
}


function cambiarEstado(id_partida, est) {
            $.ajax({
                url: "../ajax/partida.php?op=activarydesactivar",
                method: "POST",
                //toma el valor del id y del estado
                data: {
                    id_partida: id_partida,
                    est: est
                },
                success: function(data) {
                    $('#partida_data').DataTable().ajax.reload( null, false);
                }
            });
}

//la funcion guardaryeditar(e); se llama cuando se da click al boton submit
function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    var formData = new FormData($("#partida_form")[0]);

    $.ajax({
        url: "../ajax/partida.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos) {
            $('#partida_form')[0].reset();
            $('#partidaModal').modal('hide');
            $('#resultados_ajax').html(datos);
            $('#partida_data').DataTable().ajax.reload( null, false );
            limpiar();
        }

    });

}


function eliminar(id_partida) {

    bootbox.confirm("¿Está seguro de eliminar la partida?", function(result) {
        if (result) {
            $.ajax({
                url: "../ajax/partida.php?op=eliminar_partida",
                method: "POST",
                data: {
                    id_partida: id_partida
                },

                success: function(data) {
                    //alert(data);
                    $("#resultados_ajax").html(data);
                    $("#partida_data").DataTable().ajax.reload( null, false);
                }
            });
        }
    }); //bootbox
}

init();
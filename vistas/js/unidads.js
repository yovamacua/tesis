var tabla;
//// INICIO DE VALIDACION DEL FORMULARIO///
// funcion para validar formulario de usuario
$(function() {
    //creando variables y ocultando campos de error
    $("#error_nombre").hide();
    $("#error_descripcion").hide();
 


    // se declaran variables con valor false para ver si pasa o no la validacion
    var error_nombre = false;
    var error_descripcion = false;
    
    // se ejecuta funcion en el id del control cuando se pierde el foco
    $("#nombre").focusout(function() {
        campo_nombre();
    });

    $("#descripcion").focusout(function() {
        campo_descripcion();
    });



    // funciones para validar
   

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

    function campo_nombre() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ\s]*$/;
        var titulo = $("#nombre").val();
        if (pattern.test(titulo) && titulo !== '') {
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
        var titulo = $("#nombre").val().length;
        if (titulo <= 0) {
            $("#error_nombre").html("No se permiten campos vacios");
            $("#error_nombre").css("position", "absolute");
            $("#error_nombre").css("color", "red");
            $("#error_nombre").show();
            $("#nombre").css("border-bottom", "2px solid #F90A0A");
            error_nombre = true;
        }
    }

    // se valida el formulario
    $("#unidad_form").on("submit", function(e) {
        // asignacion de valor a vaiables
        error_nombre = false;
        error_descripcion = false;
      


        // se invoca a las funciones para tener el valor de las variables
        campo_nombre();
        campo_descripcion();


        //comparacion
        if (error_nombre === false &&
            error_descripcion === false) {
            // si todo funciona las barrita de color boton se reseta despues del submit
            $("#nombre").css("border-bottom", "1px solid #d2d6de");
            $("#descripcion").css("border-bottom", "1px solid #d2d6de");
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
function init(){

 listar();

   //cambia el titulo de la ventana modal cuando se da click al boton
 $("#add_button").click(function(){
     $(".modal-title").text("Agregar nombre");
   });
}

function limpiar()
{
  $('#nombre').val("");
	$('#descripcion').val("");
	$('#id_unidad').val("");;
}

//Función Listar
function listar()
{
 tabla=$('#unidad_data').dataTable(
 {
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    "bStateSave" : true,
    dom: 'Bfrtip',//Definimos los elementos del control de tabla
    buttons: [
               /*'copyHtml5',
               'excelHtml5',
               'csvHtml5',
               'pdf'*/],
   "ajax":
       {
         url: '../controlador/unidad.php?op=listar',
         type : "get",
         dataType : "json",
         error: function(e){
           console.log(e.responseText);
         }
       },
       "bDestroy": true,
       "responsive": true,
       "bInfo":true,
       "iDisplayLength": 10,//Por cada 10 registros hace una paginación
       "order": [[ 0, "desc" ]],//Ordenar (columna,orden)
       //configuraciones para el lenguaje del dataTable
         "language": {

             "sProcessing":     "Procesando...",
             "sLengthMenu":     "Mostrar _MENU_ registros",
             "sZeroRecords":    "No se encontraron resultados",
             "sEmptyTable":     "Ningún dato disponible en esta tabla",
             "sInfo":           "Mostrando un total de _TOTAL_ registros",
             "sInfoEmpty":      "Mostrando un total de 0 registros",
             "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
             "sInfoPostFix":    "",
             "sSearch":         "Buscar:",
             "sUrl":            "",
             "sInfoThousands":  ",",
             "sLoadingRecords": "Cargando...",
             "oPaginate": {
                 "sFirst":    "Primero",
                 "sLast":     "Último",
                 "sNext":     "Siguiente",
                 "sPrevious": "Anterior"
             },

             "oAria": {
                 "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                 "sSortDescending": ": Activar para ordenar la columna de manera descendente"
             }

        }//cerrando language

 }).DataTable();
}


function mostrar(id_unidad)
{
 $.post("../controlador/unidad.php?op=mostrar",{id_unidad : id_unidad}, function(data, status)
 {
   data = JSON.parse(data);

       $('#unidadModal').modal('show');
       $('#nombre').val(data.nombre);

       $('#descripcion').val(data.descripcion);
       $('.modal-title').text("Editar Categoria");
       $('#id_unidad').val(id_unidad);
       $('#action').val("Edit");

   });
 }


 //la funcion guardaryeditar(e); se llama cuando se da click al boton submit
function guardaryeditar(e)
{
 e.preventDefault(); //No se activará la acción predeterminada del evento
 var formData = new FormData($("#unidad_form")[0]);

   $.ajax({
     url: "../controlador/unidad.php?op=guardaryeditar",
       type: "POST",
       data: formData,
       contentType: false,
       processData: false,

       success: function(datos)
       {
      console.log(datos);
       $('#unidad_form')[0].reset();
       $('#unidadModal').modal('hide');
       $('#resultados_ajax').html(datos);
       $('#unidad_data').DataTable().ajax.reload(null, false);
               limpiar();

       }

   });

}


function eliminar(id_unidad){

    //IMPORTANTE: asi se imprime el valor de una funcion
      //alert(categoria_id);

   bootbox.confirm("¿Está seguro de eliminar la unidad?", function(result){
 if(result)
 {
     $.ajax({
       url:"../controlador/unidad.php?op=eliminar_unidad",
       method:"POST",
       data:{id_unidad:id_unidad},

       success:function(data)
       {
         //alert(data);
         $("#resultados_ajax").html(data);
         $("#unidad_data").DataTable().ajax.reload(null, false);
       }
     });
   }
  });//bootbox
}

init();

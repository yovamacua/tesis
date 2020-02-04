var tabla;
//// INICIO DE VALIDACION DEL FORMULARIO///
// funcion para validar formulario de usuario
$(function() {
    //creando variables y ocultando campos de error
    $("#error_categoria").hide();
    $("#error_descripcion").hide();
 


    // se declaran variables con valor false para ver si pasa o no la validacion
    var error_categoria = false;
    var error_descripcion = false;
    
    // se ejecuta funcion en el id del control cuando se pierde el foco
    $("#categoria").focusout(function() {
        campo_categoria();
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

    function campo_categoria() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ\s]*$/;
        var titulo = $("#categoria").val();
        if (pattern.test(titulo) && titulo !== '') {
            $("#error_categoria").hide();
            $("#categoria").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_categoria").html("Solo se permiten letras");
            $("#error_categoria").css("position", "absolute");
            $("#error_categoria").css("color", "red");
            $("#error_categoria").show();
            $("#categoria").css("border-bottom", "2px solid #F90A0A");
             error_categoria = true;
        }
        var titulo = $("#categoria").val().length;
        if (titulo <= 0) {
            $("#error_categoria").html("No se permiten campos vacios");
            $("#error_categoria").css("position", "absolute");
            $("#error_categoria").css("color", "red");
            $("#error_categoria").show();
            $("#categoria").css("border-bottom", "2px solid #F90A0A");
            error_categoria = true;
        }
    }

    // se valida el formulario
    $("#categoria_form").on("submit", function(e) {
        // asignacion de valor a vaiables
        error_categoria = false;
        error_descripcion = false;
      


        // se invoca a las funciones para tener el valor de las variables
        campo_categoria();
        campo_descripcion();


        //comparacion
        if (error_categoria === false &&
            error_descripcion === false) {
            // si todo funciona las barrita de color boton se reseta despues del submit
            $("#categoria").css("border-bottom", "1px solid #d2d6de");
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
     $(".modal-title").text("Agregar Categoría");
   });
}

function limpiar()
{
  $('#categoria').val("");
	$('#descripcion').val("");
	$('#id_categoria').val("");
    /** reinicia la validacion cuando se sale de la ventana modal **/
    $("#categoria").css("border-bottom", "1px solid #d2d6de");
    $("#descripcion").css("border-bottom", "1px solid #d2d6de");
    
    $("#error_categoria").hide();
    $("#error_descripcion").hide();
}

//Función Listar
function listar()
{
 tabla=$('#categoria_data').dataTable(
 {
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    "bStateSave" : true,
    dom: 'Bfrtip',//Definimos los elementos del control de tabla
    buttons: [
               'copyHtml5',
               'excelHtml5',
               'csvHtml5',
               'pdf'],
   "ajax":
       {
         url: '../ajax/categoria.php?op=listar',
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


function mostrar(id_categoria)
{
 $.post("../ajax/categoria.php?op=mostrar",{id_categoria : id_categoria}, function(data, status)
 {
   data = JSON.parse(data);

       $('#categoriaModal').modal('show');
       $('#categoria').val(data.categoria);

       $('#descripcion').val(data.descripcion);
       $('.modal-title').text("Editar Categoria");
       $('#id_categoria').val(id_categoria);
       $('#action').val("Edit");

   });
 }


 //la funcion guardaryeditar(e); se llama cuando se da click al boton submit
function guardaryeditar(e)
{
 e.preventDefault(); //No se activará la acción predeterminada del evento
 var formData = new FormData($("#categoria_form")[0]);

   $.ajax({
     url: "../ajax/categoria.php?op=guardaryeditar",
       type: "POST",
       data: formData,
       contentType: false,
       processData: false,

       success: function(datos)
       {
      console.log(datos);
       $('#categoria_form')[0].reset();
       $('#categoriaModal').modal('hide');
       $('#resultados_ajax').html(datos);
       $('#categoria_data').DataTable().ajax.reload(null, false);
               limpiar();

       }

   });

}


function eliminar(id_categoria){

    //IMPORTANTE: asi se imprime el valor de una funcion
      //alert(categoria_id);

   bootbox.confirm("¿Está seguro de eliminar la categoría?", function(result){
 if(result)
 {
     $.ajax({
       url:"../ajax/categoria.php?op=eliminar_categoria",
       method:"POST",
       data:{id_categoria:id_categoria},

       success:function(data)
       {
         //alert(data);
         $("#resultados_ajax").html(data);
         $("#categoria_data").DataTable().ajax.reload(null, false);
       }
     });
   }
  });//bootbox
}

init();

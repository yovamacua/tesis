var tabla;
// funcion para validar formulario de usuario
$(function() {
    //creando variables y ocultando campos de error
    $("#error_nombre").hide();
    $("#error_estado").hide();
  

    // se declaran variables con valor false para ver si pasa o no la validacion
    var error_nombre = false;
    var error_estado = false;
    
    // se ejecuta funcion en el id del control cuando se pierde el foco
    $("#nombre").focusout(function() {
        campo_nombre();
    });

    $("#estado").focusout(function() {
        campo_estado();
    });
    


    // funciones para validar
   

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
   
    function campo_estado() {
        var estado = document.getElementById("estado").value;
        if (estado.length <= 0) {
            $("#error_estado").html("Debe seleccionar un estado");
            $("#error_estado").css("position", "absolute");
            $("#error_estado").css("color", "red");
            $("#error_estado").show();
            error_estado= true;
        } else {
            $("#error_estado").hide();
            var error_estado = false;
        }
    }
      


    // se valida el formulario
    $("#perfiles_form").on("submit", function(e) {
        // asignacion de valor a vaiables
        error_nombre= false;
        error_estado = false;
      


        // se invoca a las funciones para tener el valor de las variables
        campo_nombre();
        campo_estado();


        //comparacion
        if (error_nombre=== false &&
            error_estado== false) {
            // si todo funciona las barrita de color boton se reseta despues del submit
            $("#nombre").css("border-bottom", "1px solid #d2d6de");
            $("#estado").css("border-bottom", "1px solid #d2d6de");
            guardaryeditar(e);
        } else {
            // se muestra un mensaje si los campos no estan correctos
            bootbox.alert("Complete/Revise los campos");
            return false;
        }
    });
});
//Función que se ejecuta al inicio
function init(){

 listar();


   //cambia el titulo de la ventana modal cuando se da click al boton
 $("#add_button").click(function(){
     $(".modal-title").text("Agregar Perfil");
   });
}

function limpiar()
{
$('#nombre').val("");
	$('#codigo').val("");
	$('#estado').val("");;
     /** reinicia la validacion cuando se sale de la ventana modal **/
    $("#nombre").css("border-bottom", "1px solid #d2d6de");
    $("#estado").css("border-bottom", "1px solid #d2d6de");
 

    $("#error_nombre").hide();
    $("#error_estado").hide();
   
}


//Función Listar
function listar()
{
 tabla=$('#perfil_data').dataTable(
 {
   "aProcessing": true,//Activamos el procesamiento del datatables
     "aServerSide": true,//Paginación y filtrado realizados por el servidor
     dom: 'Bfrtip',//Definimos los elementos del control de tabla
     buttons: [
               'copyHtml5',
               'excelHtml5',
               'csvHtml5',
               'pdf'
           ],
   "ajax":
       {
         url: '../ajax/perfiles.php?op=listar',
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


function mostrar(idperfil)
{
 $.post("../ajax/perfiles.php?op=mostrar",{idperfil : idperfil}, function(data, status)
 {
   data = JSON.parse(data);

       $('#perfilModal').modal('show');
       $('#nombre').val(data.nombre);

       $('#clave').val(data.codigo);
       $('#estado').val(data.estado);
       $('.modal-title').text("Editar perfil");
       $('#idperfil').val(idperfil);
       $('#action').val("Edit");

   });
 }


 //la funcion guardaryeditar(e); se llama cuando se da click al boton submit
function guardaryeditar(e)
{
 e.preventDefault(); //No se activará la acción predeterminada del evento
 var formData = new FormData($("#perfiles_form")[0]);

   $.ajax({
     url: "../ajax/perfiles.php?op=guardaryeditar",
       type: "POST",
       data: formData,
       contentType: false,
       processData: false,

       success: function(datos)
       {
      console.log(datos);
       $('#perfiles_form')[0].reset();
       $('#perfilModal').modal('hide');
       $('#resultados_ajax').html(datos);
       $('#perfil_data').DataTable().ajax.reload();
               limpiar();

       }

   });

}
function editarcantidad(e){
    e.preventDefault(); // no se activa la accion predeterminada del evento
    var formData = new FormData($("#asignar_form")[0]);

      $.ajax({
        url: "../ajax/perfiles.php?op=asignar",
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,

          success: function(datos){
            console.log(datos);
            $('#asignar_form')[0].reset();
            $('#resultados_ajax').html(datos);
         }

      });
  }

function eliminar(idperfil){

    //IMPORTANTE: asi se imprime el valor de una funcion

   bootbox.confirm("¿Está seguro de eliminar el perfil?", function(result){
 if(result)
 {
     $.ajax({
       url:"../ajax/perfiles.php?op=eliminar_perfil",
       method:"POST",
       data:{idperfil:idperfil},

       success:function(data)
       {
         //alert(data);
         $("#resultados_ajax").html(data);
         $("#perfil_data").DataTable().ajax.reload();
       }
     });
   }
  });//bootbox
}

init();
var tabla;
//funcion para validar formulario de usuario
$(function() {
    //creando variables y ocultando campos de error
    $("#error_nombre").hide();
    $("#error_modulo").hide();
    $("#error_descripcion").hide();

  

    // se declaran variables con valor false para ver si pasa o no la validacion
    var error_nombre = false;
    var error_estado = false;
     var error_descripcion = false;
    
    // se ejecuta funcion en el id del control cuando se pierde el foco
    $("#nombre").focusout(function() {
        campo_nombre();
    });

    $("#modulo").focusout(function() {
        campo_modulo();
    });
     $("#descripcion").focusout(function() {
        campo_descripcion();
    });
    
    


    // funciones para validar
   
 function campo_nombre() {
        var nombre = document.getElementById("nombre").value;
        if (nombre.length <= 0) {
            $("#error_nombre").html("Debe seleccionar un rol");
            $("#error_nombre").css("position", "absolute");
            $("#error_nombre").css("color", "red");
            $("#error_nombre").show();
            error_nombre= true;
        } else {
            $("#error_nombre").hide();
            var error_nombre = false;
        }
    }
  
    function campo_modulo() {
        var modulo = document.getElementById("modulo").value;
        if (modulo.length <= 0) {
            $("#error_modulo").html("Debe seleccionar un modulo");
            $("#error_modulo").css("position", "absolute");
            $("#error_modulo").css("color", "red");
            $("#error_modulo").show();
            error_modulo= true;
        } else {
            $("#error_modulo").hide();
            var error_modulo = false;
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
      


    // se valida el formulario
    $("#rol_form").on("submit", function(e) {
        // asignacion de valor a vaiables
        error_nombre= false;
        error_modulo = false;
        error_descripcion = false;
      


        // se invoca a las funciones para tener el valor de las variables
        campo_nombre();
        campo_modulo();
        campo_descripcion();


        //comparacion
        if (error_nombre=== false &&
            error_modulo=== false && error_descripcion== false ) {
            // si todo funciona las barrita de color boton se reseta despues del submit
            $("#nombre").css("border-bottom", "1px solid #d2d6de");
            $("#modulo").css("border-bottom", "1px solid #d2d6de");
            $("#descripcion").css("border-bottom", "1px solid #d2d6de");
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
     $(".modal-title").text("Agregar Rol");
   });
}

function limpiar()
{
$('#nombre').val("");
$('#descripcion').val("");
$('#modulo').val("");
 /** reinicia la validacion cuando se sale de la ventana modal **/
    $("#nombre").css("border-bottom", "1px solid #d2d6de");
    $("#modulo").css("border-bottom", "1px solid #d2d6de");
      $("#descripcion").css("border-bottom", "1px solid #d2d6de");
 

    $("#error_nombre").hide();
     $("#error_modulo").hide();
    $("#error_descripcion").hide();
}

//Función Listar
function listar()
{
 tabla=$('#roles_data').dataTable(
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
         url: '../controlador/roles.php?op=listar',
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


function mostrar(idroles)
{
 $.post("../controlador/roles.php?op=mostrar",{idroles : idroles}, function(data, status)
 {
 	  
     data = JSON.parse(data);

       $('#rolModal').modal('show');
       $('#nombre').val(data.nombre);
       $('#codigo').val(data.codigo);
       $('#modulo').val(data.idmodulo);
       $('#descripcion').val(data.descripcion);
       $('.modal-title').text("Editar roles");
       $('#idroles').val(data.idrol);
       $('#action').val("Edit");
       

   });
 }


 //la funcion guardaryeditar(e); se llama cuando se da click al boton submit
function guardaryeditar(e)
{
 e.preventDefault(); //No se activará la acción predeterminada del evento
 var formData = new FormData($("#rol_form")[0]);

   $.ajax({
     url: "../controlador/roles.php?op=guardaryeditar",
       type: "POST",
       data: formData,
       contentType: false,
       processData: false,

       success: function(datos)
       {
      console.log(datos);
       $('#rol_form')[0].reset();
       $('#rolModal').modal('hide');
       $('#resultados_ajax').html(datos);
       $('#roles_data').DataTable().ajax.reload();
               limpiar();

       }

   });

}
function editarcantidad(e){
    e.preventDefault(); // no se activa la accion predeterminada del evento
    var formData = new FormData($("#asignar_form")[0]);

      $.ajax({
        url: "../controlador/perfiles.php?op=asignar",
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
function myFunction() {
  var selectRol = document.getElementById("nombre").value;   
  var select = document.getElementById("modulo"), //El <select>
        value = select.value, //El valor seleccionado
        text = select.options[select.selectedIndex].innerText; //El
var cod1= selectRol.substr(0,2);
var cod2= text.substr(0,4);
var result= cod1+cod2;
  document.getElementById("codigo").value = result;
}

function eliminar(idroles){

    //IMPORTANTE: asi se imprime el valor de una funcion
      //alert(categoria_id);

   bootbox.confirm("¿Está seguro de eliminar el rol?", function(result){
 if(result)
 {
     $.ajax({
       url:"../controlador/roles.php?op=eliminar_perfil",
       method:"POST",
       data:{idroles:idroles},

       success:function(data)
       {
         //alert(data);
         $("#resultados_ajax").html(data);
         $("#roles_data").DataTable().ajax.reload();
       }
     });
   }
  });//bootbox
}

init();
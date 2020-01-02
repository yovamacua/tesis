var tabla;
//Función que se ejecuta al inicio
function init(){

 listar();

  //cuando se da click al boton submit entonces se ejecuta la funcion guardaryeditar(e);
 $("#rol_form").on("submit",function(e)
 {
   guardaryeditar(e);
 })

   //cambia el titulo de la ventana modal cuando se da click al boton
 $("#add_button").click(function(){
     $(".modal-title").text("Agregar Rol");
   });
}

function limpiar()
{
$('#nombre').val("");
$('#descripcion').val("");
$('#modulo').val("");;
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
         url: '../ajax/roles.php?op=listar',
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
 $.post("../ajax/roles.php?op=mostrar",{idroles : idroles}, function(data, status)
 {
 	  
    data=   JSON.parse(data);

       $('#rolModal').modal('show');
       $('#nombre').val(data.nombre);
       $('#codigo').val(data.codigo);
       $('#modulo').val(data.idmodulo);
       $('#descripcion').val(data.descripcion);
       $('.modal-title').text("Editar roles");
       $('#idroles').val(idroles);
       $('#action').val("Edit");
       

   });
 }


 //la funcion guardaryeditar(e); se llama cuando se da click al boton submit
function guardaryeditar(e)
{
 e.preventDefault(); //No se activará la acción predeterminada del evento
 var formData = new FormData($("#rol_form")[0]);

   $.ajax({
     url: "../ajax/roles.php?op=guardaryeditar",
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
      //alert(categoria_id);

   bootbox.confirm("¿Está Seguro de eliminar el perfil?", function(result){
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
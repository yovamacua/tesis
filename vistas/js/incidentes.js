var tabla;
//Función que se ejecuta al inicio
function init(){

 listar();

  //cuando se da click al boton submit entonces se ejecuta la funcion guardaryeditar(e);
 $("#incidente_form").on("submit",function(e)
 {
   guardaryeditar(e);
 })

   //cambia el titulo de la ventana modal cuando se da click al boton
 $("#add_button").click(function(){
     $(".modal-title").text("Agregar Incidente");
   });
}

function limpiar()
{
$('#titulo').val("");
$('#descripcion').val("");
$('#fecha').val("");
 $('#id_incidente').val("");
}

//Función Listar
function listar()
{
 tabla=$('#incidente_data').dataTable(
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
         url: '../ajax/incidente.php?op=listar',
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


function mostrar(id_incidente)
{
 $.post("../ajax/incidente.php?op=mostrar",{id_incidente : id_incidente}, function(data, status)
 {
   data = JSON.parse(data);

       $('#incidenteModal').modal('show');
       $('#titulo').val(data.titulo);

       $('#descripcion').val(data.descripcion);
       $('#fecha').val(data.fecha);
       $('.modal-title').text("Editar Incidente");
       $('#id_incidente').val(id_incidente);
       $('#action').val("Edit");

   });
 }


 //la funcion guardaryeditar(e); se llama cuando se da click al boton submit
function guardaryeditar(e)
{
 e.preventDefault(); //No se activará la acción predeterminada del evento
 var formData = new FormData($("#incidente_form")[0]);

   $.ajax({
     url: "../ajax/incidente.php?op=guardaryeditar",
       type: "POST",
       data: formData,
       contentType: false,
       processData: false,

       success: function(datos)
       {
      console.log(datos);
       $('#incidente_form')[0].reset();
       $('#incidenteModal').modal('hide');
       $('#resultados_ajax').html(datos);
       $('#incidente_data').DataTable().ajax.reload();
               limpiar();

       }

   });

}


function eliminar(id_incidente){

    //IMPORTANTE: asi se imprime el valor de una funcion
      //alert(categoria_id);

   bootbox.confirm("¿Está Seguro de eliminar el incidente?", function(result){
 if(result)
 {
     $.ajax({
       url:"../ajax/incidente.php?op=eliminar_incidente",
       method:"POST",
       data:{id_incidente:id_incidente},

       success:function(data)
       {
         //alert(data);
         $("#resultados_ajax").html(data);
         $("#incidente_data").DataTable().ajax.reload();
       }
     });
   }
  });//bootbox
}

init();

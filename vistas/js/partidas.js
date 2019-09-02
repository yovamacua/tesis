var tabla;
//Función que se ejecuta al inicio
function init(){

 listar();

  //cuando se da click al boton submit entonces se ejecuta la funcion guardaryeditar(e);
 $("#partida_form").on("submit",function(e)
 {
   guardaryeditar(e);
 })

   //cambia el titulo de la ventana modal cuando se da click al boton
 $("#add_button").click(function(){
     $(".modal-title").text("Agregar partida");
   });
}

function limpiar()
{
$('#nombrepartida').val("");
$('#titulo').val("");
 $('#id_partida').val("");
}

//Función Listar
function listar()
{
 tabla=$('#partida_data').dataTable(
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
         url: '../ajax/partida.php?op=listar',
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


function mostrar(id_partida)
{
 $.post("../ajax/partida.php?op=mostrar",{id_partida : id_partida}, function(data, status)
 {
   data = JSON.parse(data);

       $('#partidaModal').modal('show');
       $('#nombrepartida').val(data.nombrepartida);
       $('#responsable').val(data.responsable);
       $('.modal-title').text("Editar partida");
       $('#id_partida').val(id_partida);
       $('#action').val("Edit");
   });
 }


 //la funcion guardaryeditar(e); se llama cuando se da click al boton submit
function guardaryeditar(e)
{
 e.preventDefault(); //No se activará la acción predeterminada del evento
 var formData = new FormData($("#partida_form")[0]);

   $.ajax({
     url: "../ajax/partida.php?op=guardaryeditar",
       type: "POST",
       data: formData,
       contentType: false,
       processData: false,
       success: function(datos)
       {
      console.log(datos);
       $('#partida_form')[0].reset();
       $('#partidaModal').modal('hide');
       $('#resultados_ajax').html(datos);
       $('#partida_data').DataTable().ajax.reload();
               limpiar();
       }

   });

}


function eliminar(id_partida){

   bootbox.confirm("¿Está Seguro de eliminar el partida?", function(result){
 if(result)
 {
     $.ajax({
       url:"../ajax/partida.php?op=eliminar_partida",
       method:"POST",
       data:{id_partida:id_partida},

       success:function(data)
       {
         //alert(data);
         $("#resultados_ajax").html(data);
         $("#partida_data").DataTable().ajax.reload();
       }
     });
   }
  });//bootbox
}

init();

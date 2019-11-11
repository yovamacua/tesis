var tabla; 
//Función que se ejecuta al inicio
function init(){
  mostrarformulario(false);
  listar();

  //cuando se da click al boton submit entonces se ejecuta la funcion guardaryeditar(e);
 $("#capacitacion_form").on("submit",function(e)
 {
   guardaryeditar(e);
 });

 $("#detallecapacitados_form").on("submit",function(e)
 {
   guardaryeditardetalle(e);
 });

   //cambia el titulo de la ventana modal cuando se da click al boton
 $("#add_button").click(function(){
     $(".modal-title").text("Agregar capacitacion");
   });
}

function limpiardetalle()
{
  $('#nombres').val("");
	$('#apellidos').val("");
  $('#dui').val("");
	$('#id_capacitacion').val("");
  $('#id_detallecapacitados').val("");
}

function limpiar()
{
  $('#fecha').val("");
  $('#nombreGrupo').val("");
  $('#cargo').val("");
  $('#encargado').val("");
  $('#id_capacitacion').val("");
}

//Función mostrar formulario
function mostrarformulario(flag)
{

  if (flag)
  {
    $("#letra").show();
    $("#capacitacionModal").show();
    $("#add_button").hide();
    $("#listadoregistros").hide();
    $("#letra1").hide();

  }else{
    $("#letra").hide();
    $("#letra1").hide();
    $("#capacitacionModal").hide();
    $("#capacitadosModal").hide();
  }
}

function verdetalle(id_capacitacion){
  $("#letra1").show();
  $("#capacitadosModal").show();
  listarDetalleCapacitados(id_capacitacion);
  $("#letra").hide();
  $("#capacitacionModal").hide();
  $("#add_button").hide();
  $("#listadoregistros").hide();
}

//Función cancelarform
function cancelarform()
{
  limpiar();
  location.reload();
  mostrarformulario(false);
}

//Función Listar
function listar()
{
 tabla=$('#capacitacion_data').dataTable(
 {
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    "bStateSave" : true,
    dom: 'Bfrtip',//Definimos los elementos del control de tabla
    buttons: [],
    "ajax":
       {
          url: '../ajax/capacitacion.php?op=listar',
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

//Función Listar
function listarDetalleCapacitados(id_capacitacion)
{
  tabla=$('#detallecapacitados_data').dataTable(//detallecapacitados_form
  {
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
      dom: 'Bfrtip',//Definimos los elementos del control de tabla
      buttons: [

            ], 
    "ajax":
        {
          url:"../ajax/capacitacion.php?op=listardetalle&id="+id_capacitacion,
          method:"POST",
          data:{id_capacitacion:id_capacitacion},

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

function mostrar(id_capacitacion)
{
 $.post("../ajax/capacitacion.php?op=mostrar",{id_capacitacion : id_capacitacion}, function(data, status)
 {
    data = JSON.parse(data);

       $('#capacitacionModal').show();
       $("#letra").show();
       $('#listadoregistros').hide();
       $("#add_button").hide();
       $('#fecha').val(data.fecha);
       $('#nombreGrupo').val(data.nombreGrupo);
       $('#cargo').val(data.cargo);
       $('#encargado').val(data.encargado);
       $('.modal-title').text("Editar Capacitacion");
       $('#id_capacitacion').val(id_capacitacion);  //AGREGAR EL ID DEL DETALLE
       $('#action').val("Edit");

    });
  }

function mostrardetalle(id_detallecapacitados)
{
 $.post("../ajax/capacitacion.php?op=mostrardetalle",{id_detallecapacitados : id_detallecapacitados}, function(data, status)
 {
    data = JSON.parse(data);

       $('#detallecapacitadosModal').modal('show');
       $('#nombres').val(data.nombres);
       $('#apellidos').val(data.apellidos);
       $('#dui').val(data.dui);
       $('#id_capacitacion').val(data.id_capacitacion); //-----------ID DE LA TABLA PADRE-------
       $('.modal-title').text("Editar Capacitado");
       $('#id_detallecapacitados').val(id_detallecapacitados);//AGREGAR EL ID DEL DETALLE
       $('#action').val("Edit");

    });
  }

 //la funcion guardaryeditar(e); se llama cuando se da click al boton submit
function guardaryeditar(e)
{
  e.preventDefault(); //No se activará la acción predeterminada del evento
  var formData = new FormData($("#capacitacion_form")[0]);

    $.ajax({
        url: "../ajax/capacitacion.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

       success: function(datos)
       {
          console.log(datos);
          $('#capacitacion_form')[0].reset();
          $('#capacitacionModal').modal('hide');
          $('#resultados_ajax').html(datos);
          $('#capacitacion_data').DataTable().ajax.reload(null, false);
          limpiar();
       }
   });
}

function guardaryeditardetalle(e)
{
  e.preventDefault(); //No se activará la acción predeterminada del evento
  var formData = new FormData($("#detallecapacitados_form")[0]);

    $.ajax({
        url: "../ajax/capacitacion.php?op=guardaryeditardetalle",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

       success: function(datos)
       {
          console.log(datos);
          $('#detallecapacitados_form')[0].reset();
          $('#detallecapacitadosModal').modal('hide');
          $('#resultados_ajax').html(datos);
          $('#detallecapacitados_data').DataTable().ajax.reload(null, false);
          limpiardetalle();
       }
   });
}

function eliminar(id_capacitacion){

    //IMPORTANTE: asi se imprime el valor de una funcion
      //alert(capacitacion_id);

  bootbox.confirm("¿Está Seguro de eliminar la capacitacion?", function(result){
    if(result)
    {
      $.ajax({
            url:"../ajax/capacitacion.php?op=eliminar_capacitaciones",
            method:"POST",
            data:{id_capacitacion:id_capacitacion},

          success:function(data)
          {
            //alert(data);
            $("#resultados_ajax").html(data);
            $("#capacitacion_data").DataTable().ajax.reload(null, false);
          }
      });
    }
  });//bootbox
}

function eliminardetalle(id_detallecapacitados){

    //IMPORTANTE: asi se imprime el valor de una funcion
      //alert(capacitacion_id);

  bootbox.confirm("¿Está Seguro de eliminar el capacitado?", function(result){
    if(result)
    {
      $.ajax({
            url:"../ajax/capacitacion.php?op=eliminar_detallecapacitados",
            method:"POST",
            data:{id_detallecapacitados:id_detallecapacitados},

          success:function(data)
          {
            //alert(data);
            $("#resultados_ajax").html(data);
            $("#detallecapacitados_data").DataTable().ajax.reload(null, false);
          }
      });
    }
  });//bootbox
}

init();
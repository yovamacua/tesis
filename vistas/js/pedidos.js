var tabla; 

//Función que se ejecuta al inicio
function init(){
  mostrarformulario(false);
  listar();

  //cuando se da click al boton submit entonces se ejecuta la funcion guardaryeditar(e);
 $("#pedido_form").on("submit",function(e)
 {
   guardaryeditar(e);
 });

 $("#detallepedidos_form").on("submit",function(e)
 {
   guardaryeditardetalle(e);
 });

   //cambia el titulo de la ventana modal cuando se da click al boton
 $("#add_button").click(function(){
     $(".modal-title").text("Agregar pedido");
   });
}

function limpiardetalle()
{
  $('#nombreInsumo').val("");
  $('#cantidad').val("");
  $('#descripcion').val("");
  $('#unidadMedida').val("");
  $('#id_detallepedido').val("");
  v1 = document.getElementById("id_pedido").value;
  p1 = v1;
  document.getElementById("id_pedido").value = p1;
  v2 = document.getElementById("fecha1").value;
  p2 = v2;
  document.getElementById("fecha1").value = p2;
}

function limpiar()
{
  $('#fecha1').val("");
  $('#id_pedido').val("");
}

//Función mostrar formulario
function mostrarformulario(flag)
{

  if (flag) 
  {
    $("#letra").show();
    $("#pedidoModal").show();
    $("#add_button").hide();
    $("#listadoregistros").hide();
    $("#fecha1").focus();
    $("#addInsumo").hide();
    $("#btnCancelar").hide();
    $("#btnArchivo").hide();
  }else if($("#id_pedido").val().length == 0){
    $("#letra").hide();
    $("#pedidoModal").hide();
    $("#detallepedidos_data").hide();
    $("#btnArchivo").show();
    $("#btnGuardarCap").show();
  }else{
    $("#addInsumo").show();
    $("#btnCancelar").show();
    $("#btnArchivo").show();
  }
}

//Función cancelarform
function cancelarform()
{
  limpiar();
  location.reload();
  mostrarformulario(false);
}

  function verdetalle(id_pedido){
   $.post("../ajax/pedido.php?op=mostrar",{id_pedido : id_pedido}, function(data, status)
 {
    data = JSON.parse(data);
       $('#pedidoModal').show();
       $("#letra").show();
       $('#listadoregistros').hide();
       $("#add_button").hide();
       $("#detallepedidos_data").show();
       $('#fecha1').val(data.fecha);
       $('#id_pedido').val(data.id_pedido);  //AGREGAR EL ID DEL DETALLE
       $('#id_p').val(data.id_pedido); 
       $('#id_pe').val(data.id_pedido);  
       $('#fechaA').val(data.fecha);
    });
      document.getElementById('fecha1').readOnly = true; 
      document.getElementById('fecha1').disabled = true;
      document.getElementById('id_pedido').disabled = true;
      listarDetallePedido(id_pedido);
      $("#btnGuardarCap").hide();
}

//Función Listar
function listar()
{
 tabla=$('#pedido_data').dataTable(
 {
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    "bStateSave" : true,
    dom: 'Bfrtip',//Definimos los elementos del control de tabla
    buttons: [],
    "ajax":
       {
          url: '../ajax/pedido.php?op=listar',
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

//Función listarDetallePedido
function listarDetallePedido(id_pedido)
{

  tabla=$('#detallepedidos_data').dataTable(
  {
    "aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    dom: 'Bfrtip',//Definimos los elementos del control de tabla
    buttons: [ ],
    "ajax":
       {
          url:"../ajax/pedido.php?op=listardetalle&id="+id_pedido,
          method:"POST",
          data:{id_pedido:id_pedido},

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
    $('#detallepedidos_data').DataTable().ajax.reload();
}

//Función mostrar para mostrar datos en el modal des pedido
function mostrar(id_pedido)
{
 $.post("../ajax/pedido.php?op=mostrar",{id_pedido : id_pedido}, function(data, status)
 {
    data = JSON.parse(data);

       $('#pedidoModal').show();
       $("#letra").show();
       $('#listadoregistros').hide();
       $("#add_button").hide();
       $("#detallepedidos_data").hide();
       $("#addInsumo").hide();
       $('#fecha1').val(data.fecha);
       $('.modal-title').text("Editar Pedido");
       $('#id_pedido').val(data.id_pedido);  //AGREGAR EL ID DEL DETALLE
       $('#action').val("Edit");
       $("#botones").hide();
    });
  }

//Función mostrardetalle para mostrar datos en el modal des detallepedido
function mostrardetalle(id_detallepedido)
{
 $.post("../ajax/pedido.php?op=mostrardetalle",{id_detallepedido : id_detallepedido}, function(data, status)
 {
    data = JSON.parse(data);

       $('#detallepedidosModal').modal('show');
       $('#nombreInsumo').val(data.nombreInsumo);
       $('#cantidad').val(data.cantidad);
       $('#descripcion').val(data.descripcion);
       $('#unidadMedida').val(data.unidadMedida);
       $('#id_pedido1').val(data.id_pedido); //-----------ID DE LA TABLA PADRE-------
       $('.modal-title').text("Editar Capacitado");
       $('#id_detallepedido').val(id_detallepedido);//AGREGAR EL ID DEL DETALLE
       $('#action').val("Edit");

    });
  }

//funcion guardaryeditar(e); se llama cuando se da click al boton submit del pedido_form
function guardaryeditar(e)
{
  e.preventDefault(); //No se activará la acción predeterminada del evento
  var formData = new FormData($("#pedido_form")[0]);

    $.ajax({
        url: "../ajax/pedido.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

       success: function(datos)
       {
          console.log(datos);
          $('#pedido_form')[0].reset();
          $('#pedidoModal').modal('hide');
          $('#resultados_ajax').html(datos);
          $('#pedido_data').DataTable().ajax.reload(null, false);
          cancelarform();
       }
   });
}

//funcion guardaryeditardetalle(e); se llama cuando se da click al boton submit del detallepedidos_form
function guardaryeditardetalle(e)
{
  e.preventDefault(); //No se activará la acción predeterminada del evento
  var formData = new FormData($("#detallepedidos_form")[0]);

    $.ajax({
        url: "../ajax/pedido.php?op=guardaryeditardetalle",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

       success: function(datos)
       {
          console.log(datos);
          $('#detallepedidos_form')[0].reset();
          $('#detallepedidosModal').modal('hide');
          $('#resultados_ajax').html(datos);
          $('#detallepedidos_data').DataTable().ajax.reload(null, false);
          limpiardetalle();
       }
   });
}

//funcion eliminar pedido
function eliminar(id_pedido){

  bootbox.confirm("¿Está Seguro de eliminar el pedido?", function(result){
    if(result)
    {
      $.ajax({
            url:"../ajax/pedido.php?op=eliminar_pedidos",
            method:"POST",
            data:{id_pedido:id_pedido},

          success:function(data)
          {
            $("#resultados_ajax").html(data);
            $("#pedido_data").DataTable().ajax.reload(null, false);
          }
      });
    }
  });//bootbox
}

//funcion eliminar detallepedido
function eliminar_detallepedidos(id_detallepedido){

    //IMPORTANTE: asi se imprime el valor de una funcion
      //alert(id_detallepedido);

  bootbox.confirm("¿Está Seguro de eliminar el producto?", function(result){
    if(result)
    {
      $.ajax({
            url:"../ajax/pedido.php?op=eliminar_detallepedidos",
            method:"POST",
            data:{id_detallepedido:id_detallepedido},

          success:function(data)
          {
            $("#resultados_ajax").html(data);
            $("#detallepedidos_data").DataTable().ajax.reload(null, false);
            listarDetallePedido(id_pedido);
          }
      });
    }
  });//bootbox
}

init();
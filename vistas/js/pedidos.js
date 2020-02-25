var tabla; 

//// INICIO DE VALIDACION DEL FORMULARIO 1///
// funcion para validar formulario pedido
$(function() {
    //creando variables y ocultando campos de error
    $("#error_fecha1").hide();

    // se declaran variables con valor false para ver si pasa o no la validacion
    var error_fecha1 = false;

    // se ejecuta funcion en el id del control cuando se pierde el foco
    $("#fecha1").focusout(function() {
        campo_fecha1();
      });

    function campo_fecha1() {
        var pattern = /^([0-2][0-9]|3[0-1])(\/|-)(0[1-9]|1[0-2])\2(\d{4})$/;
        var fecha1 = $("#fecha1").val();
        if (pattern.test(fecha1) && fecha1 !== '') {
            $("#error_fecha1").hide();
            $("#fecha1").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_fecha1").html("Solo se permiten números y el símbolos /");
            $("#error_fecha1").css("position", "absolute");
            $("#error_fecha1").css("color", "red");
            $("#error_fecha1").show();
            $("#fecha1").css("border-bottom", "2px solid #F90A0A");
            error_fecha1 = true;
        }
        var fecha1 = $("#fecha1").val().length;
        if (fecha1 <= 0) {
            $("#error_fecha1").html("No se permiten campos vacios");
            $("#error_fecha1").css("position", "absolute");
            $("#error_fecha1").css("color", "red");
            $("#error_fecha1").show();
            $("#fecha1").css("border-bottom", "2px solid #F90A0A");
            error_fecha1 = true;
        }
    }

    // se valida el formulario
    $("#pedido_form").on("submit", function(e) {
      // asignacion de valor a vaiables
      
      var error_fecha1 = false;

        // se invoca a las funciones para tener el valor de las variables
        error_fecha1 = false;

        //comparacion
        if (error_fecha1 === false) {
            
            // si todo funciona las barrita de color boton se reseta despues del submit
            $("#fecha1").css("border-bottom", "1px solid #d2d6de");
            guardaryeditar(e);
        } else {
            // se muestra un mensaje si los campos no estan correctos
            alert("Complete/Revise los campos");
            return false;
        }
    });
});

// FIN VALIDACION FORMULARIO 1

//// INICIO DE VALIDACION DEL FORMULARIO 2///
// funcion para validar formulario capacitados
$(function() {
    //creando variables y ocultando campos de error
    $("#error_nombreInsumo").hide();
    $("#error_cantidad").hide();
    $("#error_descripcion").hide();
    $("#error_id_uni").hide();

    // se declaran variables con valor false para ver si pasa o no la validacion
    var error_nombreInsumo = false;
    var error_cantidad = false;
    var error_descripcion = false;
    var error_id_uni = false;
    
    // se ejecuta funcion en el id del control cuando se pierde el foco
    $("#nombreInsumo").focusout(function() {
        campo_nombreInsumo();
      });

    $("#cantidad").focusout(function() {
        campo_cantidad();
      });

    $("#descripcion").focusout(function() {
      campo_descripcion();
    });

    $("#id_uni").focusout(function() {
      campo_id_uni();
    });
    
    function campo_nombreInsumo() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9\s]*$/;
        var nombreInsumo = $("#nombreInsumo").val();
        if (pattern.test(nombreInsumo) && nombreInsumo !== '') {
            $("#error_nombreInsumo").hide();
            $("#nombreInsumo").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_nombreInsumo").html("Solo se permiten letras y números");
            $("#error_nombreInsumo").css("position", "absolute");
            $("#error_nombreInsumo").css("color", "red");
            $("#error_nombreInsumo").show();
            $("#nombreInsumo").css("border-bottom", "2px solid #F90A0A");
            error_nombreInsumo = true;
        }
        var nombreInsumo = $("#nombreInsumo").val().length;
        if (nombreInsumo <= 0) {
            $("#error_nombreInsumo").html("No se permiten campos vacios");
            $("#error_nombreInsumo").css("position", "absolute");
            $("#error_nombreInsumo").css("color", "red");
            $("#error_nombreInsumo").show();
            $("#insumo").css("border-bottom", "2px solid #F90A0A");
            error_nombreInsumo = true;
        }
    }

    function campo_cantidad() {
        var pattern = /^[0-9]*$/;   
        var cantidad = $("#cantidad").val();
        if (pattern.test(cantidad) && cantidad !== '') {
            $("#error_cantidad").hide();
            $("#cantidad").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_cantidad").html("Solo se permiten números enteros");
            $("#error_cantidad").css("position", "absolute");
            $("#error_cantidad").css("color", "red");
            $("#error_cantidad").show();
            $("#cantidad").css("border-bottom", "2px solid #F90A0A");
            error_cantidad = true;
        }
        var cantidad = $("#cantidad").val().length;
        if (cantidad <= 0) {
            $("#error_cantidad").html("No se permiten campos vacios");
            $("#error_cantidad").css("position", "absolute");
            $("#error_cantidad").css("color", "red");
            $("#error_cantidad").show();
            $("#cantidad").css("border-bottom", "2px solid #F90A0A");
            error_cantidad = true;
        }
    }

    function campo_descripcion() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9.:,¿?!¡\s]*$/;
        var descripcion = $("#descripcion").val();
        if (pattern.test(descripcion) && descripcion !== '') {
            $("#error_descripcion").hide();
            $("#descripcion").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_descripcion").html("Solo se permiten letras, números y los simbolos . : , ¿ ? ! ¡");
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

    function campo_id_uni() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9.:,¿?!¡\s]*$/;
        var id_uni = $("#id_uni").val();
        if (pattern.test(id_uni) && id_uni !== '') {
            $("#error_id_uni").hide();
            $("#id_uni").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_id_uni").html("Solo se permiten letras");
            $("#error_id_uni").css("position", "absolute");
            $("#error_id_uni").css("color", "red");
            $("#error_id_uni").show();
            $("#id_uni").css("border-bottom", "2px solid #F90A0A");
            error_id_uni = true;
        }
        var id_uni = $("#id_uni").val().length;
        if (id_uni <= 0) {
            $("#error_id_uni").html("No se permiten campos vacios");
            $("#error_id_uni").css("position", "absolute");
            $("#error_id_uni").css("color", "red");
            $("#error_id_uni").show();
            $("#id_uni").css("border-bottom", "2px solid #F90A0A");
            error_id_uni = true;
        }
    }

    // se valida el formulario
    $("#detallepedidos_form").on("submit", function(e) {
      // asignacion de valor a vaiables
      
      var error_nombreInsumo = false;
      var error_cantidad = false;
      var error_descripcion = false;
      var error_id_uni = false;

        // se invoca a las funciones para tener el valor de las variables
         error_nombreInsumo = false;
         error_cantidad = false;
         error_descripcion = false;
         error_id_uni = false;

        //comparacion
        if (error_nombreInsumo === false && error_cantidad === false && 
          error_descripcion === false && error_id_uni === false) {
            
            // si todo funciona las barrita de color boton se reseta despues del submit
            $("#nombreInsumo").css("border-bottom", "1px solid #d2d6de");
            $("#cantidad").css("border-bottom", "1px solid #d2d6de");
            $("#descripcion").css("border-bottom", "1px solid #d2d6de");
            $("#id_uni").css("border-bottom", "1px solid #d2d6de");
            guardaryeditardetalle(e);
        } else {
            // se muestra un mensaje si los campos no estan correctos
            alert("Complete/Revise los campos");
            return false;
        }
    });
});

// FIN VALIDACION FORMULARIO 2
//Función que se ejecuta al inicio
function init(){
  mostrarformulario(false);
  listar();

   //cambia el titulo de la ventana modal cuando se da click al boton
 $("#add_button").click(function(){
     $(".modal-title").text("Agregar fecha de pedido");
   });
}

//mostrar y esconder el form de agregar pedido
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
  });
}

function limpiardetalle()
{
  $('#nombreInsumo').val("");
  $('#cantidad').val("");
  $('#descripcion').val("");
  $('#id_uni').val("");
  $('#id_detallepedido').val("");
  v1 = document.getElementById("id_pedido").value;
  p1 = v1;
  document.getElementById("id_pedido").value = p1;

  /** reinicia la validacion cuando se sale de la ventana modal **/
    $("#nombreInsumo").css("border-bottom", "1px solid #d2d6de");
    $("#cantidad").css("border-bottom", "1px solid #d2d6de");
    $("#descripcion").css("border-bottom", "1px solid #d2d6de");
    $("#id_uni").css("border-bottom", "1px solid #d2d6de");

    $("#error_nombreInsumo").hide();
    $("#error_cantidad").hide();
    $("#error_descripcion").hide();
    $("#error_id_uni").hide();
}

function limpiar()
{
  $('#fecha1').val("");
  $('#id_pedido').val("");

  /** reinicia la validacion cuando se sale de la ventana modal **/
    $("#fecha1").css("border-bottom", "1px solid #d2d6de");

    $("#error_fecha1").hide();
}

//Función mostrar formulario
function mostrarformulario(flag)
{
   $("#listadopedido").hide();
   $("#addInsumo").hide();
   $("#btnCancelar").hide();
   $("#btnArchivo").hide();
   $("#detallepedidosModal").hide();
}

//Función cancelarform
function cancelarform()
{
  $("#add_button").show();
  $("#listadoregistros").show();
  $("#listadopedido").hide();
  $("#addInsumo").hide();
  $("#btnCancelar").hide();
  $("#btnArchivo").hide();
  $("#detallepedidosModal").hide();
}

  function verdetalle(id_pedido){
   $.post("../controlador/pedido.php?op=mostrar",{id_pedido : id_pedido}, function(data, status)
 {
    data = JSON.parse(data);
       $('#listadoregistros').hide();
       $("#add_button").hide();
       $("#listadopedido").show();
       $("#addInsumo").show();
       $("#btnCancelar").show();
       $("#btnArchivo").show();
       $('#fecha1').val(data.fecha);
       $('#id_pedido').val(data.id_pedido);  //AGREGAR EL ID DEL DETALLE
       $('#id_p').val(data.id_pedido); 
       $('#id_pe').val(data.id_pedido);  
       $('#fechaA').val(data.fecha);
    });
      listarDetallePedido(id_pedido);
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
          url: '../controlador/pedido.php?op=listar',
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
          url:"../controlador/pedido.php?op=listardetalle&id="+id_pedido,
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
 $.post("../controlador/pedido.php?op=mostrar",{id_pedido : id_pedido}, function(data, status)
 {
    data = JSON.parse(data);

       $('#pedidoModal').modal('show');
       $('#fecha1').val(data.fecha);
       $('.modal-title').text("Editar fecha del pedido");
       $('#id_pedido').val(data.id_pedido);  //AGREGAR EL ID DEL DETALLE
       $('#action').val("Edit");
       $("#botones").hide();
    });
  }

//Función mostrardetalle para mostrar datos en el modal des detallepedido
function mostrardetalle(id_detallepedido)
{
 $.post("../controlador/pedido.php?op=mostrardetalle",{id_detallepedido : id_detallepedido}, function(data, status)
 {
    data = JSON.parse(data);

       $('#nombreInsumo').val(data.nombreInsumo);
       $('#cantidad').val(data.cantidad);
       $('#descripcion').val(data.descripcion);
       $('#id_uni').val(data.id_uni);
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
        url: "../controlador/pedido.php?op=guardaryeditar",
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
        url: "../controlador/pedido.php?op=guardaryeditardetalle",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

       success: function(datos)
       {
          console.log(datos);
          $('#resultados_ajax').html(datos);
          $('#detallepedidos_data').DataTable().ajax.reload(null, false);
          limpiardetalle();
       }
   });
}

//funcion eliminar pedido
function eliminar(id_pedido){

  bootbox.confirm("¿Está seguro de eliminar el pedido?", function(result){
    if(result)
    {
      $.ajax({
            url:"../controlador/pedido.php?op=eliminar_pedidos",
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

  bootbox.confirm("¿Está seguro de eliminar el insumo?", function(result){
    if(result)
    {
      $.ajax({
            url:"../controlador/pedido.php?op=eliminar_detallepedidos",
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
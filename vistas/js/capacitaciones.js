var tabla; 

//// INICIO DE VALIDACION DEL FORMULARIO 1///
// funcion para validar formulario capacitacion
$(function() {
    //creando variables y ocultando campos de error
    $("#error_fecha1").hide();
    $("#error_nombreGrupo").hide();
    $("#error_encargado").hide();
    $("#error_cargo").hide();

    // se declaran variables con valor false para ver si pasa o no la validacion
    var error_fecha1 = false;
    var error_nombreGrupo = false;
    var error_encargado = false;
    var error_cargo = false;

    // se ejecuta funcion en el id del control cuando se pierde el foco
    $("#fecha1").focusout(function() {
        campo_fecha1();
      });

    $("#nombreGrupo").focusout(function() {
        campo_nombreGrupo();
      });

    $("#encargado").focusout(function() {
        campo_encargado();
      });

     $("#cargo").focusout(function() {
        campo_cargo();
      });

    function campo_fecha1() {
        var pattern = /^([0-2][0-9]|3[0-1])(\/|-)(0[1-9]|1[0-2])\2(\d{4})$/;
        var fecha1 = $("#fecha1").val();
        if (pattern.test(fecha1) && fecha1 !== '') {
            $("#error_fecha1").hide();
            $("#fecha1").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_fecha1").html("Solo se permiten formatos de fecha");
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

    function campo_nombreGrupo() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9\s]*$/;
        var nombreGrupo = $("#nombreGrupo").val();
        if (pattern.test(nombreGrupo) && nombreGrupo !== '') {
            $("#error_nombreGrupo").hide();
            $("#nombreGrupo").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_nombreGrupo").html("Solo se permiten letras y números");
            $("#error_nombreGrupo").css("position", "absolute");
            $("#error_nombreGrupo").css("color", "red");
            $("#error_nombreGrupo").show();
            $("#nombreGrupo").css("border-bottom", "2px solid #F90A0A");
            error_nombreGrupo = true;
        }
        var nombreGrupo = $("#nombreGrupo").val().length;
        if (nombreGrupo <= 0) {
            $("#error_nombreGrupo").html("No se permiten campos vacios");
            $("#error_nombreGrupo").css("position", "absolute");
            $("#error_nombreGrupo").css("color", "red");
            $("#error_nombreGrupo").show();
            $("#nombreGrupo").css("border-bottom", "2px solid #F90A0A");
            error_nombreGrupo = true;
        }
    }

    function campo_encargado() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ\s]*$/;
        var encargado = $("#encargado").val();
        if (pattern.test(encargado) && encargado !== '') {
            $("#error_encargado").hide();
            $("#encargado").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_encargado").html("Solo se permiten letras");
            $("#error_encargado").css("position", "absolute");
            $("#error_encargado").css("color", "red");
            $("#error_encargado").show();
            $("#encargado").css("border-bottom", "2px solid #F90A0A");
            error_encargado = true;
        }
        var encargado = $("#encargado").val().length;
        if (encargado <= 0) {
            $("#error_encargado").html("No se permiten campos vacios");
            $("#error_encargado").css("position", "absolute");
            $("#error_encargado").css("color", "red");
            $("#error_encargado").show();
            $("#encargado").css("border-bottom", "2px solid #F90A0A");
            error_encargado = true;
        }
    }

    function campo_cargo() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ\s]*$/;
        var cargo = $("#cargo").val();
        if (pattern.test(cargo) && cargo !== '') {
            $("#error_cargo").hide();
            $("#cargo").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_cargo").html("Solo se permiten letras");
            $("#error_cargo").css("position", "absolute");
            $("#error_cargo").css("color", "red");
            $("#error_cargo").show();
            $("#cargo").css("border-bottom", "2px solid #F90A0A");
            error_cargo = true;
        }
        var cargo = $("#cargo").val().length;
        if (cargo <= 0) {
            $("#error_cargo").html("No se permiten campos vacios");
            $("#error_cargo").css("position", "absolute");
            $("#error_cargo").css("color", "red");
            $("#error_cargo").show();
            $("#cargo").css("border-bottom", "2px solid #F90A0A");
            error_cargo = true;
        }
    }

    // se valida el formulario
    $("#capacitacion_form").on("submit", function(e) {
      // asignacion de valor a vaiables
      
      var error_fecha1 = false;
      var error_nombreGrupo = false;
      var error_encargado = false;
      var error_cargo = false;

        // se invoca a las funciones para tener el valor de las variables
        error_fecha1 = false;
        error_nombreGrupo = false;
        error_encargado = false;
        error_cargo = false;

        //comparacion
        if (error_fecha1 === false && error_nombreGrupo === false && 
          error_encargado === false && error_cargo === false) {
            
            // si todo funciona las barrita de color boton se reseta despues del submit
            $("#fecha1").css("border-bottom", "1px solid #d2d6de");
            $("#nombreGrupo").css("border-bottom", "1px solid #d2d6de");
            $("#encargado").css("border-bottom", "1px solid #d2d6de");
            $("#cargo").css("border-bottom", "1px solid #d2d6de");
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
    $("#error_nombres").hide();
    $("#error_apellidos").hide();
    $("#error_dui").hide();

    // se declaran variables con valor false para ver si pasa o no la validacion
    var error_nombres = false;
    var error_apellidos = false;
    var error_dui = false;

    // se ejecuta funcion en el id del control cuando se pierde el foco
    $("#nombres").focusout(function() {
        campo_nombres();
      });

    $("#apellidos").focusout(function() {
        campo_apellidos();
      });

    $("#dui").focusout(function() {
        campo_dui();
      });

    function campo_nombres() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ\s]*$/;
        var nombres = $("#nombres").val();
        if (pattern.test(nombres) && nombres !== '') {
            $("#error_nombres").hide();
            $("#nombres").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_nombres").html("Solo se permiten letras");
            $("#error_nombres").css("position", "absolute");
            $("#error_nombres").css("color", "red");
            $("#error_nombres").show();
            $("#nombres").css("border-bottom", "2px solid #F90A0A");
            error_nombres = true;
        }
        var nombres = $("#nombres").val().length;
        if (nombres <= 0) {
            $("#error_nombres").html("No se permiten campos vacios");
            $("#error_nombres").css("position", "absolute");
            $("#error_nombres").css("color", "red");
            $("#error_nombres").show();
            $("#nombres").css("border-bottom", "2px solid #F90A0A");
            error_nombres = true;
        }
    }

    function campo_apellidos() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ\s]*$/;
        var apellidos = $("#apellidos").val();
        if (pattern.test(apellidos) && apellidos !== '') {
            $("#error_apellidos").hide();
            $("#apellidos").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_apellidos").html("Solo se permiten letras");
            $("#error_apellidos").css("position", "absolute");
            $("#error_apellidos").css("color", "red");
            $("#error_apellidos").show();
            $("#apellidos").css("border-bottom", "2px solid #F90A0A");
            error_apellidos = true;
        }
        var apellidos = $("#apellidos").val().length;
        if (apellidos <= 0) {
            $("#error_apellidos").html("No se permiten campos vacios");
            $("#error_apellidos").css("position", "absolute");
            $("#error_apellidos").css("color", "red");
            $("#error_apellidos").show();
            $("#apellidos").css("border-bottom", "2px solid #F90A0A");
            error_apellidos = true;
        }
    }

    function campo_dui() {
        var pattern =/^\d{8}-\d{1}$/;
        var dui = $("#dui").val();
        if (pattern.test(dui) && dui !== '') {
            $("#error_dui").hide();
            $("#dui").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_dui").html("Solo se permiten el formato de DUI");
            $("#error_dui").css("position", "absolute");
            $("#error_dui").css("color", "red");
            $("#error_dui").show();
            $("#dui").css("border-bottom", "2px solid #F90A0A");
            error_dui = true;
        }
        var dui = $("#dui").val().length;
        if (dui <= 0) {
            $("#error_dui").html("No se permiten campos vacios");
            $("#error_dui").css("position", "absolute");
            $("#error_dui").css("color", "red");
            $("#error_dui").show();
            $("#dui").css("border-bottom", "2px solid #F90A0A");
            error_dui = true;
        }
    }


    // se valida el formulario
    $("#detallecapacitados_form").on("submit", function(e) {
      // asignacion de valor a vaiables
      
      var error_nombres = false;
      var error_apellidos = false;
      var error_dui = false;

        // se invoca a las funciones para tener el valor de las variables
        error_nombres = false;
        error_apellidos = false;
        error_dui = false;

        //comparacion
        if (error_nombres === false && error_apellidos === false && 
        error_dui === false) {
            
            // si todo funciona las barrita de color boton se reseta despues del submit
            $("#nombres").css("border-bottom", "1px solid #d2d6de");
            $("#apellidos").css("border-bottom", "1px solid #d2d6de");
            $("#dui").css("border-bottom", "1px solid #d2d6de");
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
     $(".modal-title").text("Agregar Capacitación");
   });
}

//mostrar y esconder el form de agregar capacitado
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
  $('#nombres').val("");
  $('#apellidos').val("");
  $('#dui').val("");
  $('#id_detallecapacitados').val("");

  /** reinicia la validacion cuando se sale de la ventana modal **/
    $("#nombres").css("border-bottom", "1px solid #d2d6de");
    $("#apellidos").css("border-bottom", "1px solid #d2d6de");
    $("#dui").css("border-bottom", "1px solid #d2d6de");

    $("#error_nobmres").hide();
    $("#error_apellidos").hide();
    $("#error_dui").hide();
}

function limpiar()
{
  $('#fecha1').val("");
  $('#nombreGrupo').val("");
  $('#cargo').val("");
  $('#encargado').val("");
  $('#id_capacitacion').val("");

  /** reinicia la validacion cuando se sale de la ventana modal **/
    $("#fecha1").css("border-bottom", "1px solid #d2d6de");
    $("#nombreGrupo").css("border-bottom", "1px solid #d2d6de");
    $("#cargo").css("border-bottom", "1px solid #d2d6de");
    $("#encargado").css("border-bottom", "1px solid #d2d6de");

    $("#error_fecha1").hide();
    $("#error_nombreGrupo").hide();
    $("#error_encargado").hide();
    $("#error_cargo").hide();
}

//Función mostrar formulario
function mostrarformulario(flag)
{ 
  $("#capacitadosModal").hide();
  $("#detallecapacitadosModal").hide();
  $("#btnAgregarCap").hide();
}

function verdetalle(id_capacitacion){
   $.post("../ajax/capacitacion.php?op=mostrar",{id_capacitacion : id_capacitacion}, function(data, status)
 {
    data = JSON.parse(data);
    $("#letra1").show();
    $("#btnAgregarCap").show();
    $("#distancia").hide();
    $("#capacitadosModal").show();
    listarDetalleCapacitados(id_capacitacion);
    $("#letra").hide();
    $("#capacitacionModal").hide();
    $("#add_button").hide();
    $("#listadoregistros").hide();
    $('#id_capa').val(data.id_capacitacion);
    $('#id_cap').val(data.id_capacitacion);
    });
}

//Función cancelarform
function cancelarform()
{
  $("#btnAgregarCap").hide();
  $("#capacitadosModal").hide();
  $("#add_button").show();
  $("#listadoregistros").show();
  $("#ocultar1").hide();
  $("#detallecapacitadosModal").hide();
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

       $('#capacitacionModal').modal('show');
       $('#fecha1').val(data.fecha);
       $('#nombreGrupo').val(data.nombreGrupo);
       $('#cargo').val(data.cargo);
       $('#encargado').val(data.encargado);
       $('.modal-title').text("Editar Capacitación");
       $('#id_capacitacion').val(id_capacitacion);  //AGREGAR EL ID DEL DETALLE
       $('#action').val("Edit");

    });
  }

function mostrardetalle(id_detallecapacitados)
{
 $.post("../ajax/capacitacion.php?op=mostrardetalle",{id_detallecapacitados : id_detallecapacitados}, function(data, status)
 {
    data = JSON.parse(data);

       $('#nombres').val(data.nombres);
       $('#apellidos').val(data.apellidos);
       $('#dui').val(data.dui);
       $('#id_capa').val(data.id_capacitacion); //-----------ID DE LA TABLA PADRE-------
       $('.modal-title').text("Editar Capacitado");
       $('#id_detallecapacitados').val(data.id_detallecapacitados);//AGREGAR EL ID DEL DETALLE
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
          //$('#detallecapacitados_form')[0].reset();
          $('#resultados_ajax').html(datos);
          $('#detallecapacitados_data').DataTable().ajax.reload(null, false);
          limpiardetalle();
       }
   });
}

function eliminar(id_capacitacion){

    //IMPORTANTE: asi se imprime el valor de una funcion
      //alert(capacitacion_id);

  bootbox.confirm("¿Está seguro de eliminar la capacitación?", function(result){
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

  bootbox.confirm("¿Está seguro de eliminar el capacitado?", function(result){
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
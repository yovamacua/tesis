var tabla; 

//// INICIO DE VALIDACION DEL FORMULARIO///
// funcion para validar formulario gastos
$(function() {
    //creando variables y ocultando campos de error
    $("#error_fecha1").hide();
    $("#error_donante").hide();
    $("#error_descripcion").hide();
    $("#error_cantidad").hide();
    $("#error_precio").hide();
    

    // se declaran variables con valor false para ver si pasa o no la validacion
    var error_fecha1 = false;
    var error_donante = false;
    var error_descripcion = false;
    var error_cantidad = false;
    var error_precio = false;
    

    // se ejecuta funcion en el id del control cuando se pierde el foco
    $("#fecha1").focusout(function() {
        campo_fecha1();
    	});

    $("#donante").focusout(function() {
        campo_donante();
    	});

    $("#descripcion").focusout(function() {
	    campo_descripcion();
		});

    $("#cantidad").focusout(function() {
        campo_cantidad();
    	});

     $("#precio").focusout(function() {
        campo_precio();
        });

    function campo_fecha1() {
        var pattern = /^([0-2][0-9]|3[0-1])(\/|-)(0[1-9]|1[0-2])\2(\d{4})$/;
        var fecha1 = $("#fecha1").val();
        if (pattern.test(fecha1) && fecha1 !== '') {
            $("#error_fecha1").hide();
            $("#fecha1").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_fecha1").html("Solo se permiten números y el simbolos /");
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

    function campo_donante() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9\s]*$/;
        var donante = $("#donante").val();
        if (pattern.test(donante) && donante !== '') {
            $("#error_donante").hide();
            $("#donante").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_donante").html("Solo se permiten letras y números");
            $("#error_donante").css("position", "absolute");
            $("#error_donante").css("color", "red");
            $("#error_donante").show();
            $("#donante").css("border-bottom", "2px solid #F90A0A");
            error_donante = true;
        }
        var donante = $("#donante").val().length;
        if (donante <= 0) {
            $("#error_donante").html("No se permiten campos vacios");
            $("#error_donante").css("position", "absolute");
            $("#error_donante").css("color", "red");
            $("#error_donante").show();
            $("#donante").css("border-bottom", "2px solid #F90A0A");
            error_donante = true;
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

    function campo_precio() {
        var pattern = /^[0-9]+(\.[0-9][0-9])?$/;
        var precio = $("#precio").val();
        if (pattern.test(precio) && precio !== '') {
            $("#error_precio").hide();
            $("#precio").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_precio").html("Solo se permiten números enteros y formato 0.00");
            $("#error_precio").css("position", "absolute");
            $("#error_precio").css("color", "red");
            $("#error_precio").show();
            $("#precio").css("border-bottom", "2px solid #F90A0A");
            error_precio = true;
        }
        var precio = $("#precio").val().length;
        if (precio <= 0) {
            $("#error_precio").html("No se permiten campos vacios");
            $("#error_precio").css("position", "absolute");
            $("#error_precio").css("color", "red");
            $("#error_precio").show();
            $("#precio").css("border-bottom", "2px solid #F90A0A");
            error_precio = true;
        }
    }

    // se valida el formulario
    $("#donacion_form").on("submit", function(e) {
        // asignacion de valor a vaiables
        var error_fecha1= false;
	    var error_donante= false;
	    var error_descripcion = false;
	    var error_cantidad = false;
	    var error_precio = false;

        // se invoca a las funciones para tener el valor de las variables
        error_fecha1= false;
	    error_donante= false;
	    error_descripcion = false;
	    error_cantidad = false;
	    error_precio = false;

        //comparacion
        if (error_fecha1 === false && error_donante === false && 
        	error_descripcion === false && error_cantidad === false && 
        	error_precio === false) {
            
            // si todo funciona las barrita de color boton se reseta despues del submit
            $("#error_fecha1").css("border-bottom", "1px solid #d2d6de");
            $("#error_donante").css("border-bottom", "1px solid #d2d6de");
            $("#error_descripcion").css("border-bottom", "1px solid #d2d6de");
            $("#error_cantidad").css("border-bottom", "1px solid #d2d6de");
            $("#error_precio").css("border-bottom", "1px solid #d2d6de");
            guardaryeditar(e);
        } else {
            // se muestra un mensaje si los campos no estan correctos
            alert("Complete/Revise los campos");
            return false;
        }
    });
});

// FIN VALIDACION FORMULARIO
 
//funcion que se ejecuta al inicio
function init(){
	listar();

	//cambiar el titulo de la ventana modal cuando se da click al boton
	$("#add_button").click(function(){
		$(".modal-title").text("Agregar Donación");
        $('#fecha1').datepicker('setDate', 'today');
	});

}

//funcion que limpia los campos del formulario
function limpiar(){
	$('#fecha1').val("");
	$('#donante').val("");
	$('#descripcion').val("");
	$('#cantidad').val("");
	$('#precio').val("");
	$('#id_donacion').val("");

    /** reinicia la validacion cuando se sale de la ventana modal **/
    $("#fecha1").css("border-bottom", "1px solid #d2d6de");
    $("#donante").css("border-bottom", "1px solid #d2d6de");
    $("#descripcion").css("border-bottom", "1px solid #d2d6de");
    $("#cantidad").css("border-bottom", "1px solid #d2d6de");
    $("#precio").css("border-bottom", "1px solid #d2d6de");

    $("#error_fecha1").hide();
    $("#error_donante").hide();
    $("#error_descripcion").hide();
    $("#error_cantidad").hide();
    $("#error_precio").hide();

}

// funcion listar
function listar(){
	tabla=$('#donacion_data').dataTable({
	"aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    "bStateSave" : true,
		dom: "Bfrtip", //definimos los elementos del control de tabla
		buttons: [],
		"ajax":
			{
				url: '../controlador/donacion.php?op=listar',
				type: "get",
				dataType: "json",
				error: function(e){
					console.log(e.responseText);
				}
			},
			"bDestroy": true,
       		"responsive": true,
			"iDisplayLength": 10, //por cada 10 registros hacer una paginacion
			"order":[[0, "desc"]], //ordenar (columna, orden)

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
 
//mostrar las donaciones en la ventana modal del formulario
function mostrar(id_donacion){
	$.post("../controlador/donacion.php?op=mostrar",{id_donacion : id_donacion}, function(data, status){
        //analiza una cadena de texto como json
        data = JSON.parse(data);

	 		$('#donacionModal').modal("show");
	 		$('#fecha1').datepicker('setDate', data.fecha);
	 		$('#donante').val(data.donante);
	 		$('#descripcion').val(data.descripcion);
	 		$('#cantidad').val(data.cantidad);
	 		$('#precio').val(data.precio);
	 		$('.modal-title').text("Editar donación");
	 		$('#id_donacion').val(id_donacion);
	 		$('#action').val("Edit");
	 });
 
}  
	//la funcion guardaryeditar(e); se llama cuando se da click al boton submit
	function guardaryeditar(e){
		e.preventDefault(); // no se activa la accion predeterminada del evento
		var formData = new FormData($("#donacion_form")[0]);

	    $.ajax({
	     	url: "../controlador/donacion.php?op=guardaryeditar",
	       	type: "POST",
	       	data: formData,
	       	contentType: false,
	       	processData: false,

	       	success: function(datos){
	      		console.log(datos);
		       	$('#donacion_form')[0].reset();
		       	$('#donacionModal').modal('hide');
		       	$('#resultados_ajax').html(datos);
		       	$('#donacion_data').DataTable().ajax.reload(null, false);
		        limpiar();
	       }

	   	});
	}

function eliminar(id_donacion){

    //IMPORTANTE: asi se imprime el valor de una funcion
	bootbox.confirm("¿Está seguro de eliminar la donación?", function(result){
		if(result){
	    	$.ajax({
	       		url:"../controlador/donacion.php?op=eliminar_donacion",
	      		method:"POST",
	       		data:{id_donacion:id_donacion},

	       		success:function(data){
		         //alert(data);
		         $("#resultados_ajax").html(data);
		         $("#donacion_data").DataTable().ajax.reload(null, false);
	       		}
	     	});
   		}
  	});//bootbox
}

init();
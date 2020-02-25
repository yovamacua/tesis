var tabla;

//// INICIO DE VALIDACION DEL FORMULARIO///
// funcion para validar formulario gastos
$(function() {
    //creando variables y ocultando campos de error
    $("#error_fecha1").hide();
    $("#error_precio").hide();
    $("#error_descripcion").hide();

    // se declaran variables con valor false para ver si pasa o no la validacion
    var error_fecha1 = false;
    var error_precio = false;
    var error_descripcion = false;


    // se ejecuta funcion en el id del control cuando se pierde el foco
    $("#fecha1").focusout(function() {
        campo_fecha1();
    });

    $("#precio").focusout(function() {
        campo_precio();
    });

    $("#descripcion").focusout(function() {
        campo_descripcion();
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

    function campo_descripcion() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9.:,¿?!¡\s]*$/;
        var descripcion = $("#descripcion").val();
        if (pattern.test(descripcion) && descripcion !== '') {
            $("#error_descripcion").hide();
            $("#descripcion").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_descripcion").html("Solo se permiten letras, números y los símbolos . : , ¿ ? ! ¡");
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
    $("#gasto_form").on("submit", function(e) {
        // asignacion de valor a vaiables
        var error_fecha1 = false;
        var error_precio = false;
        var error_descripcion = false;

        // se invoca a las funciones para tener el valor de las variables
        error_fecha1 = false;
        error_precio = false;
        error_descripcion = false;

        //comparacion
        if (error_fecha1 === false && error_precio === false && error_descripcion === false ) {
            
            // si todo funciona las barrita de color boton se reseta despues del submit
            $("#fecha1").css("border-bottom", "1px solid #d2d6de");
            $("#precio").css("border-bottom", "1px solid #d2d6de");
            $("#descripcion").css("border-bottom", "1px solid #d2d6de");
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
		$(".modal-title").text("Agregar Gasto");
	});

}

//funcion que limpia los campos del formulario
function limpiar(){
	$('#fecha1').val("");
	$('#descripcion').val("");
	$('#precio').val("");
	$('#id_gasto').val("");

    /** reinicia la validacion cuando se sale de la ventana modal **/
    $("#fecha1").css("border-bottom", "1px solid #d2d6de");
    $("#descripcion").css("border-bottom", "1px solid #d2d6de");
    $("#precio").css("border-bottom", "1px solid #d2d6de");
    
    $("#error_fecha1").hide();
    $("#error_descripcion").hide();
    $("#error_precio").hide();

}

// funcion listar
function listar(){
	tabla=$('#gasto_data').dataTable({
	"aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    "bStateSave" : true,
		dom: "Bfrtip", //definimos los elementos del control de tabla
		buttons: [],
		"ajax":
			{
				url: '../controlador/gasto.php?op=listar',
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
 
//mostrar los gastos en la ventana modal del formulario
function mostrar(id_gasto){
	$.post("../controlador/gasto.php?op=mostrar",{id_gasto: id_gasto}, function(data, status){
        //analiza una cadena de texto como json
        data = JSON.parse(data);

	 		$('#gastoModal').modal("show");
	 		$('#fecha1').val(data.fecha);
	 		$('#descripcion').val(data.descripcion);
	 		$('#precio').val(data.precio);
	 		$('.modal-title').text("Editar Gasto");
	 		$('#id_gasto').val(id_gasto);
	 		$('#action').val("Edit");
	 });
 
}  
	//la funcion guardaryeditar(e); se llama cuando se da click al boton submit
	function guardaryeditar(e){
		e.preventDefault(); // no se activa la accion predeterminada del evento
		var formData = new FormData($("#gasto_form")[0]);

	    $.ajax({
	     	url: "../controlador/gasto.php?op=guardaryeditar",
	       	type: "POST",
	       	data: formData,
	       	contentType: false,
	       	processData: false,

	       	success: function(datos){
	      		console.log(datos);
		       	$('#gasto_form')[0].reset();
		       	$('#gastoModal').modal('hide');
		       	$('#resultados_ajax').html(datos);
		       	$('#gasto_data').DataTable().ajax.reload(null, false);
		        limpiar();
	       }

	   	});
	}

function eliminar(id_gasto){

    //IMPORTANTE: asi se imprime el valor de una funcion
	bootbox.confirm("¿Está seguro de eliminar el gasto?", function(result){
		if(result){
	    	$.ajax({
	       		url:"../controlador/gasto.php?op=eliminar_gasto",
	      		method:"POST",
	       		data:{id_gasto:id_gasto},

	       		success:function(data){
		         //alert(data);
		         $("#resultados_ajax").html(data);
		         $("#gasto_data").DataTable().ajax.reload(null, false);
	       		}
	     	});
   		}
  	});//bootbox
}

init();
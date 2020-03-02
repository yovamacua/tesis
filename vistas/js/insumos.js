var tabla;
 
//// INICIO DE VALIDACION DEL FORMULARIO ENTRADA///
// funcion para validar formulario gastos
$(function() {
    //creando variables y ocultando campos de error
    $("#error_cantidad").hide();
    $("#error_precio").hide();
    $("#error_descripcion").hide();
    $("#error_iduni").hide();
    $("#error_fecha1").hide();
    $("#error_cantidad1").hide();
    $("#error_idcategoria").hide();
    
    // se declaran variables con valor false para ver si pasa o no la validacion
    var error_cantidad = false;
    var error_precio = false;
    var error_descripcion = false;
    var error_iduni = false;
    var error_fecha1 = false;
    var error_cantidad1 = false; 
	var error_idcategoria = false;

    // se ejecuta funcion en el id del control cuando se pierde el foco
    $("#cantidad").focusout(function() {
        campo_cantidad();
    });

    $("#precio").focusout(function() {
        campo_precio();
    });

    $("#descripcion").focusout(function() {
        campo_descripcion();
    });

    $("#iduni").focusout(function() {
        campo_iduni();
    });

    $("#fecha1").focusout(function() {
        campo_fecha1();
    });

    $("#cantidad1").focusout(function() {
        campo_cantidad1();
    });

    $("#idcategoria").focusout(function() {
        campo_idcategoria();
    }); 
 	
    
    function campo_cantidad() {
        var pattern = /^[0-9]*$/;   
        var cantidad = $("#cantidad").val();
        if (pattern.test(cantidad) && cantidad !== '') {
            $("#error_cantidad").hide();
            $("#cantidad").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_cantidad").html("Solo se permiten números");
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

    function campo_iduni() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9.:,¿?!¡\s]*$/;
        var iduni = $("#iduni").val();
        if (pattern.test(iduni) && iduni !== '') {
            $("#error_iduni").hide();
            $("#iduni").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_iduni").html("Solo se permiten letras");
            $("#error_iduni").css("position", "absolute");
            $("#error_iduni").css("color", "red");
            $("#error_iduni").show();
            $("#iduni").css("border-bottom", "2px solid #F90A0A");
            error_iduni = true;
        }
        var iduni = $("#iduni").val().length;
        if (iduni <= 0) {
            $("#error_iduni").html("No se permiten campos vacios");
            $("#error_iduni").css("position", "absolute");
            $("#error_iduni").css("color", "red");
            $("#error_iduni").show();
            $("#iduni").css("border-bottom", "2px solid #F90A0A");
            error_iduni = true;
        }
    }

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

    function campo_cantidad1() {
        var pattern = /^[0-9]*$/;   
        var cantidad1 = $("#cantidad1").val();
        if (pattern.test(cantidad1) && cantidad1 !== '') {
            $("#error_cantidad1").hide();
            $("#cantidad1").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_cantidad1").html("Solo se permiten números enteros");
            $("#error_cantidad1").css("position", "absolute");
            $("#error_cantidad1").css("color", "red");
            $("#error_cantidad1").show();
            $("#cantidad1").css("border-bottom", "2px solid #F90A0A");
            error_cantidad1 = true;
        }
        var cantidad1 = $("#cantidad1").val().length;
        if (cantidad1 <= 0) {
            $("#error_cantidad1").html("No se permiten campos vacios");
            $("#error_cantidad1").css("position", "absolute");
            $("#error_cantidad1").css("color", "red");
            $("#error_cantidad1").show();
            $("#cantidad1").css("border-bottom", "2px solid #F90A0A");
            error_cantidad1 = true;
        }
    }

    function campo_idcategoria() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9.:,¿?!¡\s]*$/;
        var idcategoria = $("#idcategoria").val();
        if (pattern.test(idcategoria) && idcategoria !== '') {
            $("#error_idcategoria").hide();
            $("#idcategoria").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_idcategoria").html("Solo se permiten letras");
            $("#error_idcategoria").css("position", "absolute");
            $("#error_idcategoria").css("color", "red");
            $("#error_idcategoria").show();
            $("#idcategoria").css("border-bottom", "2px solid #F90A0A");
            error_idcategoria = true;
        }
        var idcategoria = $("#idcategoria").val().length;
        if (idcategoria <= 0) {
            $("#error_idcategoria").html("No se permiten campos vacios");
            $("#error_idcategoria").css("position", "absolute");
            $("#error_idcategoria").css("color", "red");
            $("#error_idcategoria").show();
            $("#idcategoria").css("border-bottom", "2px solid #F90A0A");
            error_idcategoria = true;
        }
    }

    // se valida el formulario
    $("#insumo_form").on("submit", function(e) {
        // asignacion de valor a vaiables
        var error_cantidad = false;
	    var error_precio = false;
	    var error_descripcion = false;
	    var error_iduni = false;
	    var error_fecha1 = false;
        var error_cantidad1 = false;
		var error_idcategoria = false;

        // se invoca a las funciones para tener el valor de las variables
        error_cantidad = false;
	    error_precio = false;
	    error_descripcion = false;
	    error_iduni = false;
	    error_fecha1 = false;
        error_cantidad1 = false;
		error_idcategoria = false;

        //comparacion
        if (error_cantidad === false && error_precio === false && 
        	error_descripcion === false && error_iduni=== false && 
        	error_fecha1 === false && error_cantidad1 === false && error_idcategoria === false) {
            
            // si todo funciona las barrita de color boton se reseta despues del submit
            $("#cantidad").css("border-bottom", "1px solid #d2d6de");
            $("#precio").css("border-bottom", "1px solid #d2d6de");
            $("#descripcion").css("border-bottom", "1px solid #d2d6de");
            $("#iduni").css("border-bottom", "1px solid #d2d6de");
            $("#fecha1").css("border-bottom", "1px solid #d2d6de");
            $("#cantidad1").css("border-bottom", "1px solid #d2d6de");
            $("#idcategoria").css("border-bottom", "1px solid #d2d6de");
            guardaryeditar(e);
        } else {
            // se muestra un mensaje si los campos no estan correctos
            alert("Complete/Revise los campos");
            return false;
        }
    });
});

//// INICIO DE VALIDACION DEL FORMULARIO SALIDA///
// funcion para validar formulario capacitados
$(function() {
    //creando variables y ocultando campos de error
    $("#error_Id_insumo").hide();
    $("#error_Cantidad").hide();
    $("#error_Fecha").hide();

    // se declaran variables con valor false para ver si pasa o no la validacion
    var error_Id_insumo = false;
    var error_Cantidad = false;
    var error_Fecha = false;

    // se ejecuta funcion en el id del control cuando se pierde el foco
    $("#Id_insumo").focusout(function() {
        campo_Id_insumo();
      });

    $("#Cantidad").focusout(function() {
        campo_Cantidad();
      });

    $("#Fecha").focusout(function() {
        campo_Fecha();
      });

	function campo_Id_insumo() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9.:,¿?!¡\s]*$/;
        var Id_insumo = $("#Id_insumo").val();
        if (pattern.test(Id_insumo) && Id_insumo !== '') {
            $("#error_Id_insumo").hide();
            $("#Id_insumo").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_Id_insumo").html("Solo se permiten letras");
            $("#error_Id_insumo").css("position", "absolute");
            $("#error_Id_insumo").css("color", "red");
            $("#error_Id_insumo").show();
            $("#Id_insumo").css("border-bottom", "2px solid #F90A0A");
            error_Id_insumo = true;
        }
        var Id_insumo = $("#Id_insumo").val().length;
        if (Id_insumo <= 0) {
            $("#error_Id_insumo").html("No se permiten campos vacios");
            $("#error_Id_insumo").css("position", "absolute");
            $("#error_Id_insumo").css("color", "red");
            $("#error_Id_insumo").show();
            $("#idcategoria").css("border-bottom", "2px solid #F90A0A");
            error_Id_insumo = true;
        }
    }
    function campo_Cantidad() {
        var pattern = /^[0-9]*$/;   
        var Cantidad = $("#Cantidad").val();
        if (pattern.test(Cantidad) && Cantidad !== '') {
            $("#error_Cantidad").hide();
            $("#Cantidad").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_Cantidad").html("Solo se permiten números");
            $("#error_Cantidad").css("position", "absolute");
            $("#error_Cantidad").css("color", "red");
            $("#error_Cantidad").show();
            $("#Cantidad").css("border-bottom", "2px solid #F90A0A");
            error_Cantidad = true;
        }
        var Cantidad = $("#Cantidad").val().length;
        if (Cantidad <= 0) {
            $("#error_Cantidad").html("No se permiten campos vacios");
            $("#error_Cantidad").css("position", "absolute");
            $("#error_Cantidad").css("color", "red");
            $("#error_Cantidad").show();
            $("#Cantidad").css("border-bottom", "2px solid #F90A0A");
            error_Cantidad = true;
        }
    }

    function campo_Fecha() {
        var pattern = /^([0-2][0-9]|3[0-1])(\/|-)(0[1-9]|1[0-2])\2(\d{4})$/;
        var Fecha = $("#Fecha").val();
        if (pattern.test(Fecha) && Fecha !== '') {
            $("#error_Fecha").hide();
            $("#Fecha").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_Fecha").html("Solo se permiten números y el símbolos /");
            $("#error_Fecha").css("position", "absolute");
            $("#error_Fecha").css("color", "red");
            $("#error_Fecha").show();
            $("#Fecha").css("border-bottom", "2px solid #F90A0A");
            error_Fecha = true;
        }
        var Fecha = $("#Fecha").val().length;
        if (Fecha <= 0) {
            $("#error_Fecha").html("No se permiten campos vacios");
            $("#error_Fecha").css("position", "absolute");
            $("#error_Fecha").css("color", "red");
            $("#error_Fecha").show();
            $("#Fecha").css("border-bottom", "2px solid #F90A0A");
            error_Fecha = true;
        }
    } 

    // funcion para validar que la cantidad no sea mayor a lo disponible
    function validarCantidad(id_insumo){
    var idIns = document.getElementById("Id_insumo").value;
    var salida = document.getElementById("Cantidad").value;
    var disp = document.getElementById("disponible").value;
       if(parseInt(salida, 10) > disp) {
            return false;
        }else{
            return true;
        }
    } 

    // se valida el formulario
    $("#kardexinsumo_form").on("submit", function(e) {
        // asignacion de valor a vaiables
        var error_Id_insumo = false;
	    var error_Cantidad = false;
	    var error_Fecha = false;

        // se invoca a las funciones para tener el valor de las variables
        error_Id_insumo = false;
        error_Cantidad = false;
        error_Fecha = false;

        //comparacion
        if (error_Id_insumo === false && error_Cantidad === false && 
          error_Fecha === false && validarCantidad(true)) {
            // si todo funciona las barrita de color boton se reseta despues del submit
            $("#Id_insumo").css("border-bottom", "1px solid #d2d6de");
            $("#Cantidad").css("border-bottom", "1px solid #d2d6de");
            $("#Fecha").css("border-bottom", "1px solid #d2d6de");
            editarcantidad(e); 
        } else {
            // se muestra un mensaje si los campos no estan correctos
            alert("La cantidad es mayor que la existencia");
            return false;
        }
    });
});

// FIN VALIDACION FORMULARIO SALIDA


// FIN VALIDACION FORMULARIO ENTRADA
//funcion que se ejecuta al inicio
function init(){
	listar();

	//cambiar el titulo de la ventana modal cuando se da click al boton
	$("#add_button").click(function(){
        $(".ofield").hide();
		$(".modal-title").text("Agregar Insumo");
	});

	//cambiar el titulo de la ventana modal cuando se da click al boton
	$("#minus_button").click(function(){
		$(".modal-title2").text("Descontar Insumo");
	});

}

//funcion que limpia los campos del formulario
function limpiar(){
	$('#cantidad').val("");
	$('#precio').val("");
	$('#iduni').val("");
	$('#descripcion').val("");
	$('#fecha1').val("");
    $('#cantidad1').val("");
	$('#idcategoria').val("");
	$('#id_insumo').val("");

	/** reinicia la validacion cuando se sale de la ventana modal **/
    $("#cantidad").css("border-bottom", "1px solid #d2d6de");
    $("#precio").css("border-bottom", "1px solid #d2d6de");
    $("#iduni").css("border-bottom", "1px solid #d2d6de");
    $("#descripcion").css("border-bottom", "1px solid #d2d6de");
    $("#fecha1").css("border-bottom", "1px solid #d2d6de");
    $("#cantidad1").css("border-bottom", "1px solid #d2d6de");
    $("#idcategoria").css("border-bottom", "1px solid #d2d6de");

    $("#error_cantidad").hide();
    $("#error_precio").hide();
    $("#error_iduni").hide();
    $("#error_descripcion").hide();
    $("#error_fecha1").hide();
    $("#error_cantidad1").hide();
    $("#error_idcategoria").hide();

}

//funcion que limpia los campos del formulario2
function limpiar2(){
	$('#Cantidad').val("");
	$('#Fecha').val("");
	$('#Id_insumo').val("");

	/** reinicia la validacion cuando se sale de la ventana modal **/
    $("#Cantidad").css("border-bottom", "1px solid #d2d6de");
    $("#Fecha").css("border-bottom", "1px solid #d2d6de");
    $("#Id_insumo").css("border-bottom", "1px solid #d2d6de");

    $("#error_Cantidad").hide();
    $("#error_Fecha").hide();
    $("#error_Id_insumo").hide();

}

// funcion listar
function listar(){
	tabla = $('#insumo_data').dataTable({
	"aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    "bStateSave" : true,
		dom: "Bfrtip", //definimos los elementos del control de tabla
		buttons: [],

		"ajax":
			{
				url: '../controlador/insumo.php?op=listar',
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
 
//mostrar los insumos en la ventana modal del formulario
function mostrar(id_insumo){
	$.post("../controlador/insumo.php?op=mostrar",{id_insumo: id_insumo}, function(data, status){
        //analiza una cadena de texto como json
        data = JSON.parse(data);

            $(".ofield").show();
	 		$('#insumoModal').modal("show");
	 		$('#cantidad').val(data.cantidad);
	 		$('#precio').val(data.precio);
	 		$('#iduni').val(data.iduni);
	 		$('#descripcion').val(data.descripcion);
	 		$('#fecha1').val(data.fecha);
	 		//$('#idpe').val(data.idpedido);
	 		$('#idcategoria').val(data.idcategoria);
	 		$('.modal-title').text("Editar Insumo");
	 		$('#id_insumo').val(id_insumo);
	 		$('#action').val("Edit");
	 });
 
}  
	//la funcion guardaryeditar(e); se llama cuando se da click al boton submit
	function guardaryeditar(e){
		e.preventDefault(); // no se activa la accion predeterminada del evento
		var formData = new FormData($("#insumo_form")[0]);

	    $.ajax({
	     	url: "../controlador/insumo.php?op=guardaryeditar",
	       	type: "POST",
	       	data: formData,
	       	contentType: false,
	       	processData: false,

	       	success: function(datos){
	      		console.log(datos);
		       	$('#insumo_form')[0].reset();
		       	$('#insumoModal').modal('hide');
		       	$('#resultados_ajax').html(datos);
		       	$('#insumo_data').DataTable().ajax.reload(null, false);
		        limpiar();
                location.reload();
	       }

	   	});
	}

	//la funcion editarcantidad(e); se llama cuando se da click al boton submit
	function editarcantidad(e){
		e.preventDefault(); // no se activa la accion predeterminada del evento
		var formData = new FormData($("#kardexinsumo_form")[0]);

	    $.ajax({
	     	url: "../controlador/insumo.php?op=editarcantidad",
	       	type: "POST",
	       	data: formData,
	       	contentType: false,
	       	processData: false,

	       	success: function(datos){
	      		console.log(datos);
		       	$('#kardexinsumo_form')[0].reset();
		       	$('#kardexinsumoModal').modal('hide');
		       	$('#resultados_ajax').html(datos);
		        limpiar2();
                location.reload();
	       }

	   	});
	}

function eliminar(id_insumo){

    //IMPORTANTE: asi se imprime el valor de una funcion
	bootbox.confirm("¿Está seguro de eliminar el insumo?", function(result){
		if(result){
	    	$.ajax({
	       		url:"../controlador/insumo.php?op=eliminar_insumo",
	      		method:"POST",
	       		data:{id_insumo:id_insumo},

	       		success:function(data){
		         //alert(data);
		         $("#resultados_ajax").html(data);
		         $("#insumo_data").DataTable().ajax.reload(null, false);
	       		}
	     	});
   		}
  	});//bootbox
}
// funcion para mostrar la cantidad disponible del insumo
function InsumoDisp(id_insumo){
    var idIns = document.getElementById("Id_insumo").value;
    $.post("../controlador/insumo.php?op=cantidad_insumo",{id_insumo: idIns}, function(data, status){
        //analiza una cadena de texto como json
        data = JSON.parse(data);
        $('#disponible').val(data.cantidad);
     });
} 

init();
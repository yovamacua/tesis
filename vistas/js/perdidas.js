var tabla;

//// INICIO DE VALIDACION DEL FORMULARIO///
// funcion para validar formulario perdidas
$(function() {
    //creando variables y ocultando campos de error
    $("#error_idproducto").hide();
    $("#error_cantidad").hide();
    $("#error_precioProduc").hide();
    $("#error_unidadDelProduc").hide();
    $("#error_descripcion").hide();
    $("#error_fecha1").hide();

    // se declaran variables con valor false para ver si pasa o no la validacion
    var error_idproducto= false;
    var error_cantidad = false;
    var error_precioProduc = false;
    var error_unidadDelProduc = false;
    var error_descripcion = false;
    var error_fecha1= false;

    // se ejecuta funcion en el id del control cuando se pierde el foco
    $("#idproducto").focusout(function() {
        campo_idproducto();
    	});

    $("#cantidad").focusout(function() {
        campo_cantidad();
    	});

    $("#precioProduc").focusout(function() {
        campo_precioProduc();
    	});

     $("#unidadDelProduc").focusout(function() {
        campo_unidadDelProduc();
    	});

	$("#descripcion").focusout(function() {
	    campo_descripcion();
		});

	$("#fecha1").focusout(function() {
	    campo_fecha1();
	    });


    function campo_idproducto() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9.:,¿?!¡\s]*$/;
        var idproducto = $("#idproducto").val();
        if (pattern.test(idproducto) && idproducto !== '') {
            $("#error_idproducto").hide();
            $("#idproducto").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_idproducto").html("Solo se permiten letras");
            $("#error_idproducto").css("position", "absolute");
            $("#error_idproducto").css("color", "red");
            $("#error_idproducto").show();
            $("#idproducto").css("border-bottom", "2px solid #F90A0A");
            error_idproducto = true;
        }
        var idproducto = $("#idproducto").val().length;
        if (idproducto <= 0) {
            $("#error_idproducto").html("No se permiten campos vacios");
            $("#error_idproducto").css("position", "absolute");
            $("#error_idproducto").css("color", "red");
            $("#error_idproducto").show();
            $("#idproducto").css("border-bottom", "2px solid #F90A0A");
            error_idproducto = true;
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

    function campo_precioProduc() {
        var pattern =  /^[0-9]+(\.[0-9][0-9])?$/;
        var precioProduc = $("#precioProduc").val();
        if (pattern.test(precioProduc) && precioProduc !== '') {
            $("#error_precioProduc").hide();
            $("#precioProduc").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_precioProduc").html("Solo se permiten números enteros y formato 0.00");
            $("#error_precioProduc").css("position", "absolute");
            $("#error_precioProduc").css("color", "red");
            $("#error_precioProduc").show();
            $("#precioProduc").css("border-bottom", "2px solid #F90A0A");
            error_precioProduc = true;
        }
        var precioProduc = $("#precioProduc").val().length;
        if (precioProduc <= 0) {
            $("#error_precioProduc").html("No se permiten campos vacios");
            $("#error_precioProduc").css("position", "absolute");
            $("#error_precioProduc").css("color", "red");
            $("#error_precioProduc").show();
            $("#precioProduc").css("border-bottom", "2px solid #F90A0A");
            error_precioProduc = true;
        }
    }

    function campo_unidadDelProduc() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9.:,¿?!¡\s]*$/;
        var unidadDelProduc = $("#unidadDelProduc").val();
        if (pattern.test(unidadDelProduc) && unidadDelProduc !== '') {
            $("#error_unidadDelProduc").hide();
            $("#unidadDelProduc").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_unidadDelProduc").html("Solo se permiten letras");
            $("#error_unidadDelProduc").css("position", "absolute");
            $("#error_unidadDelProduc").css("color", "red");
            $("#error_unidadDelProduc").show();
            $("#unidadDelProduc").css("border-bottom", "2px solid #F90A0A");
            error_unidadDelProduc = true;
        }
        var unidadDelProduc = $("#unidadDelProduc").val().length;
        if (unidadDelProduc <= 0) {
            $("#error_unidadDelProduc").html("No se permiten campos vacios");
            $("#error_unidadDelProduc").css("position", "absolute");
            $("#error_unidadDelProduc").css("color", "red");
            $("#error_unidadDelProduc").show();
            $("#unidadDelProduc").css("border-bottom", "2px solid #F90A0A");
            error_unidadDelProduc = true;
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

    // se valida el formulario
    $("#perdida_form").on("submit", function(e) {
        // asignacion de valor a vaiables
        var error_idproducto= false;
	    var error_cantidad = false;
	    var error_precioProduc = false;
	    var error_unidadDelProduc = false;
	    var error_descripcion = false;
	    var error_fecha1 = false;

        // se invoca a las funciones para tener el valor de las variables
        error_idproducto = false;
        error_cantidad = false;
        error_precioProduc = false;
        error_unidadDelProduc = false;
        error_descripcion = false;
        error_fecha1 = false;

        //comparacion
        if (error_idproducto === false && error_cantidad === false && 
        	error_precioProduc === false && error_unidadDelProduc === false && 
        	error_descripcion === false && error_fecha1 === false) {
            
            // si todo funciona las barrita de color boton se reseta despues del submit
            $("#idproducto").css("border-bottom", "1px solid #d2d6de");
            $("#cantidad").css("border-bottom", "1px solid #d2d6de");
            $("#precioProduc").css("border-bottom", "1px solid #d2d6de");
            $("#unidadDelProduc").css("border-bottom", "1px solid #d2d6de");
            $("#descripcion").css("border-bottom", "1px solid #d2d6de");
            $("#fecha1").css("border-bottom", "1px solid #d2d6de");
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
		$(".modal-title").text("Agregar Pérdida");
        $('#fecha1').datepicker('setDate', 'today');
	});

}

//funcion que limpia los campos del formulario
function limpiar(){
	$('#idproducto').val("");
	$('#cantidad').val("");
	$('#descripcion').val("");
	$('#precioProduc').val("");
	$('#fecha1').val("");
	$('#unidadDelProduc').val("");
	$('#id_perdida').val("");

    /** reinicia la validacion cuando se sale de la ventana modal **/
    $("#idproducto").css("border-bottom", "1px solid #d2d6de");
    $("#cantidad").css("border-bottom", "1px solid #d2d6de");
    $("#descripcion").css("border-bottom", "1px solid #d2d6de");
    $("#precioProduc").css("border-bottom", "1px solid #d2d6de");
    $("#fecha1").css("border-bottom", "1px solid #d2d6de");
    $("#unidadDelProduc").css("border-bottom", "1px solid #d2d6de");

    $("#error_idproducto").hide();
    $("#error_cantidad").hide();
    $("#error_precioProduc").hide();
    $("#error_unidadDelProduc").hide();
    $("#error_descripcion").hide();
    $("#error_fecha1").hide();

}

// funcion listar
function listar(){
	tabla=$('#perdida_data').dataTable({
	"aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
    "bStateSave" : true,
		dom: "Bfrtip", //definimos los elementos del control de tabla
		buttons: [],

		"ajax":
			{
				url: '../controlador/perdida.php?op=listar',
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
 
//mostrar las perdidas en la ventana modal del formulario
function mostrar(id_perdida){
	$.post("../controlador/perdida.php?op=mostrar",{id_perdida : id_perdida}, function(data, status){
        //analiza una cadena de texto como json
        data = JSON.parse(data);

	 		$('#perdidaModal').modal("show");
	 		$('#idproducto').val(data.idproducto);
            $('#idproducto option:not(:selected)').attr('disabled',true);
	 		$('#cantidad').val(data.cantidad);
            $('#cantidad').attr("readonly","readonly");
	 		$('#descripcion').val(data.descripcion);
	 		$('#precioProduc').val(data.precioProduc);
            $('#fecha1').datepicker('setDate', data.fecha);
	 		$('#unidadDelProduc').val(data.unidadDelProduc);
            $('#unidadDelProduc option:not(:selected)').attr('disabled',true);
	 		$('.modal-title').text("Editar Pérdida");
	 		$('#id_perdida').val(id_perdida);
	 		$('#action').val("Edit");
	 });
 
}  
 //la funcion guardaryeditar(e); se llama cuando se da click al boton submit
function guardaryeditar(e)
{
 e.preventDefault(); //No se activará la acción predeterminada del evento
 var formData = new FormData($("#perdida_form")[0]);

   $.ajax({
     url: "../controlador/perdida.php?op=guardaryeditar",
       type: "POST",
       data: formData,
       contentType: false,
       processData: false,

       success: function(datos)
       {
      console.log(datos);
       $('#perdida_form')[0].reset();
       $('#perdidaModal').modal('hide');
       $('#resultados_ajax').html(datos);
       $('#perdida_data').DataTable().ajax.reload(null, false);
        limpiar();
       }

   });

}

function eliminar(id_perdida){

    //IMPORTANTE: asi se imprime el valor de una funcion
	bootbox.confirm("¿Está seguro de eliminar la perdida?", function(result){
		if(result){
	    	$.ajax({
	       		url:"../controlador/perdida.php?op=eliminar_perdida",
	      		method:"POST",
	       		data:{id_perdida:id_perdida},

	       		success:function(data){
		         //alert(data);
		         $("#resultados_ajax").html(data);
		         $("#perdida_data").DataTable().ajax.reload(null, false);
	       		}
	     	});
   		}
  	});//bootbox
}

// funcion para mostrar el precio del producto
function precioProd(idproducto){
    var idPro = document.getElementById("idproducto").value;
    $.post("../controlador/perdida.php?op=precio_producto",{idproducto: idPro}, function(data, status){
        //analiza una cadena de texto como json
        data = JSON.parse(data);
        $('#precioProduc').val(data.precio_venta);
     });
} 

init();
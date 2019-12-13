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
    $("#error_mes").hide();
    $("#error_anio").hide();

    // se declaran variables con valor false para ver si pasa o no la validacion
    var error_idproducto= false;
    var error_cantidad = false;
    var error_precioProduc = false;
    var error_unidadDelProduc = false;
    var error_descripcion = false;
    var error_mes = false;
    var error_anio = false;

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

	$("#mes").focusout(function() {
	    campo_mes();
	    });

	$("#anio").focusout(function() {
	    campo_anio();
	    });


    function campo_idproducto() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9.:,¿?!¡\s]*$/;
        var idproducto = $("#idproducto").val();
        if (pattern.test(idproducto) && idproducto !== '') {
            $("#error_idproducto").hide();
            $("#idproducto").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_idproducto").html("Solo se permiten letras, números y los símbolos . : , ¿ ? ! ¡");
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

    function campo_precioProduc() {
        var pattern = /^[0-9]+[.]+[0-9]*$/;
        var precioProduc = $("#precioProduc").val();
        if (pattern.test(precioProduc) && precioProduc !== '') {
            $("#error_precioProduc").hide();
            $("#precioProduc").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_precioProduc").html("Solo se permite el formato 0.00");
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
            $("#error_unidadDelProduc").html("Solo se permiten letras, números y los símbolos . : , ¿ ? ! ¡");
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

    function campo_mes() {
        var pattern = /^[0-9]*$/;   
        var mes = $("#mes").val();
        if (pattern.test(mes) && mes !== '') {
            $("#error_mes").hide();
            $("#mes").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_mes").html("Solo se permiten números");
            $("#error_mes").css("position", "absolute");
            $("#error_mes").css("color", "red");
            $("#error_mes").show();
            $("#mes").css("border-bottom", "2px solid #F90A0A");
            error_mes = true;
        }
        var mes = $("#mes").val().length;
        if (mes <= 0) {
            $("#error_mes").html("No se permiten campos vacios");
            $("#error_mes").css("position", "absolute");
            $("#error_mes").css("color", "red");
            $("#error_mes").show();
            $("#mes").css("border-bottom", "2px solid #F90A0A");
            error_mes = true;
        }
    }

    function campo_anio() {
        var pattern = /^[0-9]*$/;   
        var anio = $("#anio").val();
        if (pattern.test(anio) && anio !== '') {
            $("#error_anio").hide();
            $("#anio").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_anio").html("Solo se permiten números");
            $("#error_anio").css("position", "absolute");
            $("#error_anio").css("color", "red");
            $("#error_anio").show();
            $("#anio").css("border-bottom", "2px solid #F90A0A");
            error_danio = true;
        }
        var anio = $("#anio").val().length;
        if (anio <= 0) {
            $("#error_anio").html("No se permiten campos vacios");
            $("#error_anio").css("position", "absolute");
            $("#error_anio").css("color", "red");
            $("#error_anio").show();
            $("#anio").css("border-bottom", "2px solid #F90A0A");
            error_anio = true;
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
	    var error_mes = false;
	    var error_anio = false;

        // se invoca a las funciones para tener el valor de las variables
        error_idproducto = false;
        error_cantidad = false;
        error_precioProduc = false;
        error_unidadDelProduc = false;
        error_descripcion = false;
        error_mes = false;
        error_anio = false;

        //comparacion
        if (error_idproducto === false && error_cantidad === false && 
        	error_precioProduc === false && error_unidadDelProduc === false && 
        	error_descripcion === false && error_mes === false && 
        	error_anio === false) {
            
            // si todo funciona las barrita de color boton se reseta despues del submit
            $("#idproducto").css("border-bottom", "1px solid #d2d6de");
            $("#cantidad").css("border-bottom", "1px solid #d2d6de");
            $("#precioProduc").css("border-bottom", "1px solid #d2d6de");
            $("#unidadDelProduc").css("border-bottom", "1px solid #d2d6de");
            $("#descripcion").css("border-bottom", "1px solid #d2d6de");
            $("#mes").css("border-bottom", "1px solid #d2d6de");
            $("#anio").css("border-bottom", "1px solid #d2d6de");
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
	});

}

//funcion que limpia los campos del formulario
function limpiar(){
	$('#idproducto').val("");
	$('#cantidad').val("");
	$('#descripcion').val("");
	$('#precioProduc').val("");
	$('#mes').val("");
	$('#anio').val("");
	$('#unidadDelProduc').val("");
	$('#id_perdida').val("");

    /** reinicia la validacion cuando se sale de la ventana modal **/
    $("#idproducto").css("border-bottom", "1px solid #d2d6de");
    $("#cantidad").css("border-bottom", "1px solid #d2d6de");
    $("#descripcion").css("border-bottom", "1px solid #d2d6de");
    $("#precioProduc").css("border-bottom", "1px solid #d2d6de");
    $("#mes").css("border-bottom", "1px solid #d2d6de");
    $("#anio").css("border-bottom", "1px solid #d2d6de");
    $("#unidadDelProduc").css("border-bottom", "1px solid #d2d6de");

    $("#error_idproducto").hide();
    $("#error_cantidad").hide();
    $("#error_precioProduc").hide();
    $("#error_unidadDelProduc").hide();
    $("#error_descripcion").hide();
    $("#error_mes").hide();
    $("#error_anio").hide();

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
				url: '../ajax/perdida.php?op=listar',
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
	$.post("../ajax/perdida.php?op=mostrar",{id_perdida : id_perdida}, function(data, status){
        //analiza una cadena de texto como json
        data = JSON.parse(data);

	 		$('#perdidaModal').modal("show");
	 		$('#idproducto').val(data.idproducto);
	 		$('#cantidad').val(data.cantidad);
	 		$('#descripcion').val(data.descripcion);
	 		$('#precioProduc').val(data.precioProduc);
	 		$('#mes').val(data.mes);
	 		$('#anio').val(data.anio);
	 		$('#unidadDelProduc').val(data.unidadDelProduc);
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
     url: "../ajax/perdida.php?op=guardaryeditar",
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
	bootbox.confirm("¿Está Seguro de eliminar la perdida?", function(result){
		if(result){
	    	$.ajax({
	       		url:"../ajax/perdida.php?op=eliminar_perdida",
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

init();
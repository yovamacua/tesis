var tabla;
 
//funcion que se ejecuta al inicio
function init(){
	listar();
	//cuando se de click al boton submit se ejecuta la funcion guardar
	$("#insumo_form").on("submit",function(e){
		guardaryeditar(e);
	});

	//cuando se de click al boton submit se ejecuta la funcion editar la cantidad
	$("#kardexinsumo_form").on("submit",function(e){
		editarcantidad(e);
	});

	//cambiar el titulo de la ventana modal cuando se da click al boton
	$("#add_button").click(function(){
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
	$('#unidaMedida').val("");
	$('#descripcion').val("");
	$('#fecha').val("");
	$('#idpedido').val("");
	$('#idcategoria').val("");
	$('#id_insumo').val("");

}

//funcion que limpia los campos del formulario2
function limpiar2(){
	$('#Cantidad').val("");
	$('#Fecha').val("");
	$('#Id_insumo').val("");

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
				url: '../ajax/insumo.php?op=listar',
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
	$.post("../ajax/insumo.php?op=mostrar",{id_insumo: id_insumo}, function(data, status){
        //analiza una cadena de texto como json
        data = JSON.parse(data);

	 		$('#insumoModal').modal("show");
	 		$('#cantidad').val(data.cantidad);
	 		$('#precio').val(data.precio);
	 		$('#unidaMedida').val(data.unidaMedida);
	 		$('#descripcion').val(data.descripcion);
	 		$('#fecha').val(data.fecha);
	 		$('#idpedido').val(data.idpedido);
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
	     	url: "../ajax/insumo.php?op=guardaryeditar",
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
	       }

	   	});
	}

	//la funcion editarcantidad(e); se llama cuando se da click al boton submit
	function editarcantidad(e){
		e.preventDefault(); // no se activa la accion predeterminada del evento
		var formData = new FormData($("#kardexinsumo_form")[0]);

	    $.ajax({
	     	url: "../ajax/insumo.php?op=editarcantidad",
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
	       }

	   	});
	}

function eliminar(id_insumo){

    //IMPORTANTE: asi se imprime el valor de una funcion
	bootbox.confirm("¿Está Seguro de eliminar el insumo?", function(result){
		if(result){
	    	$.ajax({
	       		url:"../ajax/insumo.php?op=eliminar_insumo",
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

init();
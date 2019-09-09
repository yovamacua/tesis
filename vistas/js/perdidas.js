var tabla;
 
//funcion que se ejecuta al inicio
function init(){
	listar();
	//cuando se de click al boton submit se ejecuta la funcion guardar
	$("#perdida_form").on("submit",function(e){
		guardaryeditar(e);
	});

	//cambiar el titulo de la ventana modal cuando se da click al boton
	$("#add_button").click(function(){
		$(".modal-title").text("Agregar perdida");
	});

}

//funcion que limpia los campos del formulario
function limpiar(){
	$('#nombreProduc').val("");
	$('#cantidad').val("");
	$('#descripcion').val("");
	$('#precioProduc').val("");
	$('#mes').val("");
	$('#anio').val("");
	$('#unidadDelProduc').val("");
	$('#idperdidas').val("");

}

// funcion listar
function listar(){
	tabla=$('#perdida_data').dataTable({
	"aProcessing": true,//Activamos el procesamiento del datatables
    "aServerSide": true,//Paginación y filtrado realizados por el servidor
		dom: "Bfrtip", //definimos los elementos del control de tabla
		buttons: [
			'copyHtml5',
			'excelHtml5',
			'csvHtml5',
			'pdf'
		],

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
function mostrar(idperdidas){
	$.post("../ajax/perdida.php?op=mostrar",{idperdidas : idperdidas}, function(data, status){
        //analiza una cadena de texto como json
        data = JSON.parse(data);

	 		$('#perdidaModal').modal("show");
	 		$('#nombreProduc').val(data.nombreProduc);
	 		$('#cantidad').val(data.cantidad);
	 		$('#descripcion').val(data.descripcion);
	 		$('#precioProduc').val(data.precioProduc);
	 		$('#mes').val(data.mes);
	 		$('#anio').val(data.anio);
	 		$('#unidadDelProduc').val(data.unidadDelProduc);
	 		$('.modal-title').text("Editar Perdida");
	 		$('#idperdidas').val(idperdidas);
	 		$('#action').val("Edit");
	 });
 
}  
	//la funcion guardaryeditar(e); se llama cuando se da click al boton submit
	function guardaryeditar(e){
		e.preventDefault(); // no se activa la accion predeterminada del evento
		var formData = new FormData($("#perdida_form")[0]);

	    $.ajax({
	     	url: "../ajax/perdida.php?op=guardaryeditar",
	       	type: "POST",
	       	data: formData,
	       	contentType: false,
	       	processData: false,

	       	success: function(datos){
	      		console.log(datos);
		       	$('#perdida_form')[0].reset();
		       	$('#perdidaModal').modal('hide');
		       	$('#resultados_ajax').html(datos);
		       	$('#perdida_data').DataTable().ajax.reload();
		        limpiar();
	       }

	   	});
	}

function eliminar(idperdidas){

    //IMPORTANTE: asi se imprime el valor de una funcion
	bootbox.confirm("¿Está Seguro de eliminar la perdida?", function(result){
		if(result){
	    	$.ajax({
	       		url:"../ajax/perdida.php?op=eliminar_perdida",
	      		method:"POST",
	       		data:{idperdidas:idperdidas},

	       		success:function(data){
		         //alert(data);
		         $("#resultados_ajax").html(data);
		         $("#perdida_data").DataTable().ajax.reload();
	       		}
	     	});
   		}
  	});//bootbox
}

init();
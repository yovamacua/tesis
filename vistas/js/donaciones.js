var tabla;
 
//funcion que se ejecuta al inicio
function init(){
	listar();
	//cuando se de click al boton submit se ejecuta la funcion guardar
	$("#donacion_form").on("submit",function(e){
		guardaryeditar(e);
	});

	//cambiar el titulo de la ventana modal cuando se da click al boton
	$("#add_button").click(function(){
		$(".modal-title").text("Agregar Donación");
	});

}

//funcion que limpia los campos del formulario
function limpiar(){
	$('#fecha').val("");
	$('#donante').val("");
	$('#descripcion').val("");
	$('#cantidad').val("");
	$('#precio').val("");
	$('#id_donacion').val("");

}

// funcion listar
function listar(){
	tabla=$('#donacion_data').dataTable({
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
				url: '../ajax/donacion.php?op=listar',
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
	$.post("../ajax/donacion.php?op=mostrar",{id_donacion : id_donacion}, function(data, status){
        //analiza una cadena de texto como json
        data = JSON.parse(data);

	 		$('#donacionModal').modal("show");
	 		$('#fecha').val(data.fecha);
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
	     	url: "../ajax/donacion.php?op=guardaryeditar",
	       	type: "POST",
	       	data: formData,
	       	contentType: false,
	       	processData: false,

	       	success: function(datos){
	      		console.log(datos);
		       	$('#donacion_form')[0].reset();
		       	$('#donacionModal').modal('hide');
		       	$('#resultados_ajax').html(datos);
		       	$('#donacion_data').DataTable().ajax.reload();
		        limpiar();
	       }

	   	});
	}

function eliminar(id_donacion){

    //IMPORTANTE: asi se imprime el valor de una funcion
	bootbox.confirm("¿Está seguro de eliminar la donación?", function(result){
		if(result){
	    	$.ajax({
	       		url:"../ajax/donacion.php?op=eliminar_donacion",
	      		method:"POST",
	       		data:{id_donacion:id_donacion},

	       		success:function(data){
		         //alert(data);
		         $("#resultados_ajax").html(data);
		         $("#donacion_data").DataTable().ajax.reload();
	       		}
	     	});
   		}
  	});//bootbox
}

init();
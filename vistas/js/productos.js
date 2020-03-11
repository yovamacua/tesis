var tabla;
//// INICIO DE VALIDACION DEL FORMULARIO///
// funcion para validar formulario de usuario
$(function() {
    //creando variables y ocultando campos de error
    $("#error_producto").hide();
    $("#error_precio").hide();
    $("#error_stock").hide();
    $("#error_stock1").hide();
     $("#error_categoria").hide();
      $("#error_unidad").hide();
 


    // se declaran variables con valor false para ver si pasa o no la validacion
    var error_producto = false;
    var error_precio = false;
    var error_stock = false;
    var error_stock1 = false;
    var error_categoria = false;
      var error_unidad= false;
    
    // se ejecuta funcion en el id del control cuando se pierde el foco
    $("#producto").focusout(function() {
        campo_producto();
    });

    $("#precio_venta").focusout(function() {
        campo_precio();
    });
      $("#stock").focusout(function() {
        campo_stock();
    });
       $("#stock1").focusout(function() {
        campo_stock1();
    });
      $("#categoria").focusout(function() {
        campo_categoria();
    });
       $("#id_unidad").focusout(function() {
        campo_unidad();
    });



    // funciones para validar
   

    function campo_precio() {
        var pattern = /^[0-9.\s]*$/;
        var precio = $("#precio_venta").val();
        if (pattern.test(precio) && precio !== '') {
            $("#error_precio").hide();
            $("#precio_venta").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_precio").html("numeros");
            $("#error_precio").css("position", "absolute");
            $("#error_precio").css("color", "red");
            $("#error_precio").show();
            $("#precio_venta").css("border-bottom", "2px solid #F90A0A");
            error_precio = true;
        }
        var precio = $("#precio_venta").val().length;
        if (precio <= 0) {
            $("#error_precio").html("No se permiten campos vacios");
            $("#error_precio").css("position", "absolute");
            $("#error_precio").css("color", "red");
            $("#error_precio").show();
            $("#precio_venta").css("border-bottom", "2px solid #F90A0A");
            error_precio = true;
        }
    }

    function campo_producto() {
        var pattern = /^[a-záéíóúñA-ZÁÉÍÓÚÑ\s]*$/;
        var titulo = $("#producto").val();
        if (pattern.test(titulo) && titulo !== '') {
            $("#error_producto").hide();
            $("#producto").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_producto").html("Solo se permiten letras");
            $("#error_producto").css("position", "absolute");
            $("#error_producto").css("color", "red");
            $("#error_producto").show();
            $("#producto").css("border-bottom", "2px solid #F90A0A");
             error_producto = true;
        }
        var titulo = $("#producto").val().length;
        if (titulo <= 0) {
            $("#error_producto").html("No se permiten campos vacios");
            $("#error_producto").css("position", "absolute");
            $("#error_producto").css("color", "red");
            $("#error_producto").show();
            $("#producto").css("border-bottom", "2px solid #F90A0A");
            error_producto = true;
        }
    }
    function campo_stock() {
        var pattern = /^[0-9]*$/;
        var precio = $("#stock").val();
        if (pattern.test(precio) && precio !== '') {
            $("#error_stock").hide();
            $("#stock").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_stock").html("numeros");
            $("#error_stock").css("position", "absolute");
            $("#error_stock").css("color", "red");
            $("#error_stock").show();
            $("#stock").css("border-bottom", "2px solid #F90A0A");
            error_stock = true;
        }
        var precio = $("#stock").val().length;
        if (precio <= 0) {
            $("#error_stock").html("No se permiten campos vacios");
            $("#error_stock").css("position", "absolute");
            $("#error_stock").css("color", "red");
            $("#error_stock").show();
            $("#stock").css("border-bottom", "2px solid #F90A0A");
            error_stock = true;
        }
    }
    function campo_stock1() {
        var pattern = /^[0-9]*$/;
        var precio = $("#stock1").val();
        if (pattern.test(precio) && precio !== '') {
            $("#error_stock1").hide();
            $("#stock1").css("border-bottom", "2px solid #34F458");
        } else {
            $("#error_stock1").html("numeros");
            $("#error_stock1").css("position", "absolute");
            $("#error_stock1").css("color", "red");
            $("#error_stock1").show();
            $("#stock1").css("border-bottom", "2px solid #F90A0A");
            error_stock1 = true;
        }
        var precio = $("#stock1").val().length;
        if (precio <= 0) {
            $("#error_stock1").html("No se permiten campos vacios");
            $("#error_stock1").css("position", "absolute");
            $("#error_stock1").css("color", "red");
            $("#error_stock1").show();
            $("#stock1").css("border-bottom", "2px solid #F90A0A");
            error_stock1 = true;
        }
    }
    function campo_categoria() {
        var categoria = document.getElementById("categoria").value;
        if (categoria.length <= 0) {
            $("#error_categoria").html("Debe seleccionar una categoria");
            $("#error_categoria").css("position", "absolute");
            $("#error_categoria").css("color", "red");
            $("#error_categoria").show();
            error_categoria = true;
        } else {
            $("#error_categoria").hide();
            var error_categoria = false;
        }
    }
      function campo_unidad() {
        var categoria = document.getElementById("id_unidad").value;
        if (categoria.length <= 0) {
            $("#error_unidad").html("Debe seleccionar una unidad");
            $("#error_unidad").css("position", "absolute");
            $("#error_unidad").css("color", "red");
            $("#error_unidad").show();
            error_categoria = true;
        } else {
            $("#error_unidad").hide();
            var error_unidad = false;
        }
    }


    // se valida el formulario
    $("#producto_form").on("submit", function(e) {
        // asignacion de valor a vaiables
        error_producto = false;
        error_precio = false;
         error_stock = false;
         error_stock1 = false;
           error_categoria = false;
             error_unidad = false;
      


        // se invoca a las funciones para tener el valor de las variables
        campo_producto();
        campo_precio();
        campo_stock();
        campo_stock1();
         campo_categoria();
          campo_unidad();


        //comparacion
        if (error_producto=== false &&
            error_precio === false && error_stock == false && error_categoria== false && error_stock1== false ) {
            // si todo funciona las barrita de color boton se reseta despues del submit
            $("#categoria").css("border-bottom", "1px solid #d2d6de");
            $("#precio_venta").css("border-bottom", "1px solid #d2d6de");
            $("#stock").css("border-bottom", "1px solid #d2d6de");
             $("#stock1").css("border-bottom", "1px solid #d2d6de");
              $("#categoria").css("border-bottom", "1px solid #d2d6de")
               $("#id_unidads").css("border-bottom", "1px solid #d2d6de")
            guardaryeditar(e);
        } else {
            // se muestra un mensaje si los campos no estan correctos
            bootbox.alert("Complete/Revise los campos");
            return false;
        }
    });
});

// FIN VALIDACION FORMULARIO
 //Función que se ejecuta al inicio
function init(){
	
	listar();

	 
 
    //cambia el titulo de la ventana modal cuando se da click al boton
	$("#add_button").click(function(){
			$(".ofield").hide();
             $("#stock").removeAttr('readonly');
			$(".modal-title").text("Agregar Producto");
	
	  });
	
}


//Función limpiar
/*IMPORTANTE: no limpiar el campo oculto del id_usuario, sino no se registra
la categoria*/
function limpiar()
{
	
    $("#id_producto").val("");
	//$("#id_usuario").val("");
    $("#categoria").val("");
	$('#producto').val("");
    $('#id_unidad').val("");
	$('#precio_venta').val("");
	$('#stock').val("");
      /** reinicia la validacion cuando se sale de la ventana modal **/
    $("#categoria").css("border-bottom", "1px solid #d2d6de");
    $("#producto").css("border-bottom", "1px solid #d2d6de");
   $("#precio_venta").css("border-bottom", "1px solid #d2d6de");
    $("#stock").css("border-bottom", "1px solid #d2d6de");
     $("#stock1").css("border-bottom", "1px solid #d2d6de");
     $("#id_unidad").css("border-bottom", "1px solid #d2d6de");

    $("#error_categoria").hide();
    $("#error_producto").hide();
    $("#error_precio").hide();
    $("#error_stock").hide();
    $("#error_stock1").hide();
    $("#error_unidad").hide();
   
}

//Función Listar
function listar()
{
	tabla=$('#producto_data').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    "bStateSave" : true,
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [],
		"ajax":
				{
					url: '../controlador/producto.php?op=listar',
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

 //Mostrar datos del producto en la ventana modal 
function mostrar(id_producto)
{
	$.post("../controlador/producto.php?op=mostrar",{id_producto : id_producto}, function(data, status)
	{
		//data = JSON.parse(data);
            data=   JSON.parse(data);
		// alert(data.cedula);
		
			 $('.ofield').show();

              $("#stock").attr("readonly","true");
    
           
				$('#productoModal').modal('show');
                $('#categoria').val(data.id_categoria);
                $('#producto').val(data.producto);
				$('#id_unidad').val(data.id_unidad);
				$('#precio_venta').val(data.precio_venta);
				$('#stock').val(data.stock);
				$('.modal-title').text("Editar Producto");
				$('#id_producto').val(id_producto);
				$('#action').val("Edit");
				$('#resultados_ajax').html(data);
				$("#producto_data").DataTable().ajax.reload(null, false);
				
		});
        
        
	}


	//la funcion guardaryeditar(e); se llama cuando se da click al boton submit
function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#producto_form")[0]);


		$.ajax({
			url: "../controlador/producto.php?op=guardaryeditar",
		    type: "POST",
		    data: formData,
		    contentType: false,
		    processData: false,

		    success: function(datos)
		    {                    
		         /* bootbox.alert(datos);	          
		          mostrarform(false);
		          tabla.ajax.reload();

		        alert(datos);
                 
                 /*imprimir consulta en la consola debes hacer un print_r($_POST) al final del metodo 
                    y si se muestran los valores es que esta bien, y se puede imprimir la consulta desde el metodo
                    y se puede ver en la consola o desde el mensaje de alerta luego pegar la consulta en phpmyadmin*/
		         console.log(datos);
	            $('#producto_form')[0].reset();
				$('#productoModal').modal('hide');
				$('#resultados_ajax').html(datos);
				$('#producto_data').DataTable().ajax.reload(null, false);
				
                limpiar();
					
		    }

		});
    
}
function eliminar(id_producto){

    //IMPORTANTE: asi se imprime el valor de una funcion
      //alert(categoria_id);

   bootbox.confirm("¿Está seguro de eliminar el producto?", function(result){
 if(result)
 {
     $.ajax({
       url:"../controlador/producto.php?op=eliminar_producto",
       method:"POST",
       data:{id_producto:id_producto},

       success:function(data)
       {
         //alert(data);
         $("#resultados_ajax").html(data);
         $("#categoria_data").DataTable().ajax.reload(null, false);
       }
     });
   }
  });//bootbox
}

init();
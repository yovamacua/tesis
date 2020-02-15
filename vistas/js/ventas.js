var tabla;

var tabla_ventas;

var tabla_ventas_mes
//// INICIO DE VALIDACION DEL FORMULARIO///
// funcion para validar formulario de usuario
$(function() {
    //creando variables y ocultando campos de error
    $("#error_fecha").hide();


    // se declaran variables con valor false para ver si pasa o no la validacion
    
    var error_fecha = false;

    // se ejecuta funcion en el id del control cuando se pierde el foco

    $("#fecha").focusout(function() {
        campo_fecha();
    });


    // funciones para validar
    function campo_fecha() {
        var fecha = document.getElementById("fecha").value;
        if (fecha.length <= 0) {
            $("#error_fecha").html("Debe colocar una fecha");
            $("#error_fecha").css("color", "red");
            $("#error_fecha").show();
            error_fecha = true;
        } else {
            $("#error_fecha").hide();
            $("#fecha").css("border-bottom", "2px solid #34F458");
            var error_fecha = false;
        }
    }
    // se valida el formulario
    $("#formulario").on("submit", function(e) {
        // asignacion de valor a vaiables
        error_fecha = false;
    


        // se invoca a las funciones para tener el valor de las variables
    
        campo_fecha();
        


        //comparacion
        if (error_titulo === false) {
            // si todo funciona las barrita de color boton se reseta despues del submit
            $("#fecha").css("border-bottom", "1px solid #d2d6de");
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
	mostrarformulario(false);
	listar();
	 //cuando se da click al boton submit entonces se ejecuta la funcion guardaryeditar(e);
	$("#formulario").on("submit",function(e)
	{

		guardaryeditar(e);
	})

    //cambia el titulo de la ventana modal cuando se da click al boton
	$("#add_button").click(function(){

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
	$('#producto').val("");
	//$('#fila0').remove();
    $('#numero_venta').val("");
	$('#precio_venta').val("");
	$('#total_pagar').val("");

	$('#stock').val("");
}

//Función mostrar formulario
function mostrarformulario(flag)
{

	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		//$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		$("#ventasfechas").hide();
		$("#ocultar").hide();
		listarProductoVenta();
		$("#letra").show();
		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").show();
		detalles=0;
	}
	else
	{
        $("#listadoregistros").show();
        $("#ventasfechas").show();
        $("#ocultar").show();
		$("#formularioregistros").hide();
		$("#letra").hide();
		$("#btnagregar").show();
	}
}
//Función cancelarform
function cancelarform()
{
	
	limpiar();
	//location.reload();
	mostrarformulario(false);
	//cargar();
}

function cancelar(){

	limpiar();
	mostrarformulario(false);
	
}
function cargar(){

	window.location.reload();
}
//Función Listar
function listar()
{
	tabla=$('#ventas_data').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    "bStateSave" : true,
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [],
		"ajax":
				{
					url: '../ajax/venta.php?op=listar',
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
//Función Listar
function listarProductoVenta()
{
	tabla=$('#tblarticulos').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    "bStateSave" : true,
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [

		        ],
		"ajax":
				{
					url: '../ajax/venta.php?op=listarProductoVenta',
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
//Declaración de variables necesarias para trabajar con las compras y
//sus detalles
//var impuesto=13;
var cont=0;
var detalles=0;
function agregarDetalle(id_producto,producto,precio_venta,stock)
  {
  	var cantidad=1;
    

    if (id_producto!="")
    {
    	var subtotal=cantidad*precio_venta;
    	var fila='<tr class="filas" style="text-align: center" id="fila'+cont+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
    	'<td><input type="hidden"  name="id_producto[]" value="'+id_producto+'">'+producto+'</td>'+
    	'<td><input type="text" maxlength="5"  style="WIDTH: 58px; text-align: center" name="stock[]" id="stock[]" value="'+stock+' " readonly></td>'+
    	'<td><input type="number" maxlength="5"  style="WIDTH: 58px; text-align: center" onchange="modificarSubototales()" name="cantidad[]" id="cantidad[]" value="'+cantidad+'" min="0" max="1000"></td>'+
    	'<td><input type="text"  maxlength="5"  style="WIDTH: 58px; text-align: center" name="precio_venta[]" id="precio_venta[]" value="'+precio_venta+' "></td>'+
    	'<td><span name="subtotal" id="subtotal'+cont+'">'+subtotal+'</span></td>'+
    	//'<td><button type="button" onclick="modificarSubototales()" class="btn btn-info"><i class="fa fa-refresh"></i></button></td>'+
    	'</tr>';
    	cont++;
    	detalles=detalles+1;
    	$('#detalles').append(fila);
    	modificarSubototales();


    }
    else
    {
    	alert("Error al ingresar el detalle, revisar los datos del producto");
    }
  }
  function modificarSubototales()
  {
    var stock = document.getElementsByName("stock[]");  	
  	var cant = document.getElementsByName("cantidad[]");
    var prec = document.getElementsByName("precio_venta[]");
    var desc = document.getElementsByName("descuento[]");
    var sub = document.getElementsByName("subtotal");
  
    var i=0;
     while(i <cant.length){
          var inpC=cant[i];
    	var inpP=prec[i];
    	var inpS=sub[i];
    	var inpK= stock[i];   
    	if(parseInt(inpC.value)  >= parseInt(inpK.value)){

    		
    		bootbox.alert("producto insuficiente");
    	} else{
           inpS.value=Math.ceil((inpC.value * inpP.value)*100)/100;
       document.getElementsByName("subtotal")[i].innerHTML = inpS.value;

    	}
      
            
    		
     	i++;
     }

    /*for (var i = 0; i <cant.length; i++) {
    	var inpC=cant[i];
    	var inpP=prec[i];
    	var inpS=sub[i];
var inpK= stock[i]; 
    		if(parseInt(inpC.value)  >= parseInt(inpK.value)){

    		alert("producto insuficiente");
    	} else{
           inpS.value=Math.ceil((inpC.value * inpP.value)*100)/100;
       document.getElementsByName("subtotal")[i].innerHTML = inpS.value;

    	}
    	
    }*/
    calcularTotales();

  }




  function calcularTotales(){
  	var sub = document.getElementsByName("subtotal");
  	var total = 0.0;

  	for (var i = 0; i <sub.length; i++) {
		total += document.getElementsByName("subtotal")[i].value;

	}
  	
	$("#total").html("$" + total);
    $("#total_pagar").val(total);
    evaluar();
  }

  function evaluar(){
  	if (detalles>0)
    {
      $("#btnGuardar").show();
    }
    else
    {
      $("#btnGuardar").hide();
      cont=0;
    }
  }

  function eliminarDetalle(indice){
  	$("#fila" + indice).remove();
  	calcularTotales();
  	detalles=detalles-1;
  	evaluar()
  }
	//la funcion guardaryeditar(e); se llama cuando se da click al boton submit
function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	bootbox.confirm("¿Está seguro de realizar la compra?", function(result){
 if(result)
 {
	var formData = new FormData($("#formulario")[0]);


		$.ajax({
			url: "../ajax/venta.php?op=guardaryeditar",
		    type: "POST",
		    data: formData,
		    contentType: false,
		    processData: false,

		    success: function(datos)
		    {
		         /*bootbox.alert(datos);
		          mostrarform(false);
		          tabla.ajax.reload();

		        alert(datos);

                 /*imprimir consulta en la consola debes hacer un print_r($_POST) al final del metodo
                    y si se muestran los valores es que esta bien, y se puede imprimir la consulta desde el metodo
                    y se puede ver en la consola o desde el mensaje de alerta luego pegar la consulta en phpmyadmin*/
		         console.log(datos);
	            $('#formulario')[0].reset();
				$('#ventas_data').DataTable().ajax.reload(null, false);

                limpiar();

		    }

		});
		}
  });//bootbox
}


 //anular venta
       //importante:id_usuario, est se envia por post via ajax
       function anularventa(idventas,estado){
        bootbox.confirm("¿Está seguro de anular la venta?", function(result){
		        if(result)
		          {
           $.ajax({
				url:"../ajax/venta.php?op=anular",
				 method:"POST",
				//toma el valor del id y del estado
				data:{idventas:idventas, estado:estado},
				success: function(data){
        $('#ventas_data').DataTable().ajax.reload(null, false);
        //tabla.ajax.reload();
         $("#idventas").css('visibility', 'hidden');

			    }

			});

    }
    //btn.style.visibility = 'hidden';
 });//bootbox

}
//CONSULTA VENTAS-FECHA
           $(document).on("click","#btn_venta_fecha", function(){


           	var fecha_inicial= $("#datepicker").val();
           	var fecha_final= $("#datepicker2").val();

           	//alert(fecha_inicial);
           	//alert(fecha_final);

        //validamos si existe las fechas entonces se ejecuta el ajax

        if(fecha_inicial!="" && fecha_final!=""){

	       // BUSCA LAS COMPRAS POR FECHA
	      tabla_ventas= $('#ventas_fecha_data').DataTable({

	    
	       "aProcessing": true,//Activamos el procesamiento del datatables
	       "aServerSide": true,//Paginación y filtrado realizados por el servidor
	       "bStateSave" : true,
	      dom: 'Bfrtip',//Definimos los elementos del control de tabla
	      buttons: [],

	         "ajax":{
	            url:"../ajax/venta.php?op=buscar_ventas_fecha",
                type : "post",
				//dataType : "json",
				data:{fecha_inicial:fecha_inicial,fecha_final:fecha_final},						
				error: function(e){
					console.log(e.responseText);

				},

	          
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
			 
			    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			 
			    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
			 
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

			   }, //cerrando language

			    //"scrollX": true



	      });
	         }//cerrando condicional de las fechas

	    });
      
//FECHA VENTA POR MES

           $(document).on("click","#btn_venta_fecha_mes", function(){

           	//var proveedor= $("#proveedor").val();

           	var mes= $("#mes").val();
           	var ano= $("#ano").val();

           	//alert(mes);
           	//alert(ano);

        //validamos si existe las fechas entonces se ejecuta el ajax

        if(mes!="" && ano!=""){

	       // BUSCA LAS COMPRAS POR FECHA
	      var tabla_ventas_mes= $('#ventas_fecha_mes_data').DataTable({
	        
	       "aProcessing": true,//Activamos el procesamiento del datatables
	       "aServerSide": true,//Paginación y filtrado realizados por el servidor
	       "bStateSave" : true,
	      dom: 'Bfrtip',//Definimos los elementos del control de tabla
	      buttons: [],

	         "ajax":{
	            url:"../ajax/venta.php?op=buscar_ventas_fecha_mes",
                type : "post",
				//dataType : "json",
				data:{mes:mes,ano:ano},						
				error: function(e){
					console.log(e.responseText);

				},

	          
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
			 
			    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			 
			    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
			 
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

			   }, //cerrando language

			    //"scrollX": true



	      });

	        }//cerrando condicional de las fechas

	    });

function mostrar(idventas)
{
	$.post("../ajax/venta.php?op=mostrar",{idventas : idventas}, function(data, status)
	{
		//data = JSON.parse(data);
		data =JSON.parse(data);		
		mostrarformulario(true);

		$("#idventa").val(data.idventa);
		$("#nombre").val(data.usuario);
		$('#fecha').datepicker('setDate', data.fecha);
		$("#numero_venta").val(data.numero_venta); 
		//Ocultar y mostrar los botones
		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").hide();
 	});

 	$.post("../ajax/venta.php?op=listarDetalle&id="+idventas,function(r){
	        $("#detalles").html(r);
	});	
}

init();

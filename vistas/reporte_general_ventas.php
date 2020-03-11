<?php
   
    require_once("../config/conexion.php");
      require_once("../modelos/Roles.php");

    if(isset($_SESSION["id_usuario"])){

   	require_once("../modelos/Venta.php");
   	require_once("../modelos/Perdidas.php");
   	 $usuario = new Roles();

   	$ventas = new Ventas();
   	$datos = $ventas->get_ventas_reporte_general();
   	$datos_ano = $ventas->suma_ventas_total_ano();

	$perdidas = new Perdidas();
	$datosp = $perdidas->get_perdidas_reporte_general();
	$datosp_anio = $perdidas->suma_perdidas_total_anio();
?>

<!-- INICIO DEL HEADER - LIBRERIAS -->
<?php 
#variable para mostrar como item activo
$activar = 'item_reporteVenta';
$activar1 = 'item_reporteVenta1';
require_once("header.php");?>

<!-- FIN DEL HEADER - LIBRERIAS -->

 <?php if($_SESSION["VENTA"]==1)
     {

     ?>

  	<!-- Content Wrapper. Contains page content -->
  	<div class="content-wrapper">
<section class="content-header">
      
      <h1>Reporte de ventas y perdidas mes y año</h1>
      
      <!-- migas de pan -->
      <ol class="breadcrumb">
         <li><a href="inicio.php"><i class="fa fa-home"></i>Inicio</a></li>
         <li><i class="fa fa-file-text"></i> Reportes V/P por M/A</li>
      </ol>

   </section>
<section class="content">
	<div class="box panel-body">
		  	<h2 class="reporte_compras_general container-fluid bg-red text-white col-lg-12 text-center mh-50">
		        Reporte de ventas y perdidas mes y año
		   	</h2>

		   	<div class="panel panel-default">
		        
		        <div class="panel-body">

		         <div class="btn-group text-center">
                 <?php 
                             $rol=$usuario->listar_roles_por_usuario($_SESSION['id_usuario']);
                            $valores=array();
                            //Almacenamos los permisos marcados en el array
                             foreach($rol as $rows){

                             $valores[]= $rows["codigo"];
                                }   
                                if(in_array("COREPO",$valores)){
                                  echo '<button type="button" id="buttonExport" class="btn btn-primary btn-lg" ><i class="fa fa-print" aria-hidden="true"></i> Imprimir</button>';
              }
                            ?>
		         
		         </div>
		       </div>
		    </div>

<!--DATOS DE VENTAS-->
	<div class="row">
	 <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
	    <div class="box">
	       <div class="" id="tab">
				<h2 class="reporte_compras_general container-fluid bg-primary text-white col-lg-12 text-center mh-50">Reporte general de ventas</h2>
				              
				  <table class="table table-bordered">
				    <thead>
				      <tr>
				        <th>AÑO</th>
				        <th>N° MES</th>
				        <th>NOMBRE MES</th>
				        <th>TOTAL</th>
				      </tr>
				    </thead>
				    <tbody>
				     
                   <?php
                   
                   		$arregloReg = array();

	                    for($i=0; $i<count($datos_ano); $i++){
	                  
				        	array_push($arregloReg, 
						            array(
					
					     	'año' => $datos_ano[$i]["año"],

					     	'total_venta_año' => $datos_ano[$i]["total_venta_año"]
					               
					            )
					        );
					    }
          
	                    $total_ventas = 0;
	                    for($j=0; $j<count($arregloReg); $j++){
	                       	$total_ventas = $total_ventas + $datos_ano[$j]["total_venta_año"];
	                   	}

                    	for($i=0;$i<count($datos);$i++){

				    	//imprime la fecha por separado ejemplo: dia, mes y año
                       	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 
                       	$fecha = $datos[$i]["mes"];
                       	$fecha_mes = $meses[date("n", strtotime($fecha))-1];
                        
				     	?>

					      <tr>
					        <td align="center"><?php echo $datos[$i]["año"]?></td>
					        <td align="center"><?php echo $datos[$i]["numero_mes"]?></td>
					        <td align="center"><?php echo $fecha_mes?></td>
					     
					        <td align="center"><?php echo "$"." ".$datos[$i]["total_venta"]?></td>
					      </tr>
					      
				     	<?php

                    }//cierre del for
                   
				      ?>
                    
	                  	<tr>
		                	<td><strong>Total:</strong></td>
		                	<td><strong></strong></td>
		                	<td><strong></strong></td>
		                	<td align="center"><strong>$ <?php echo $total_ventas?></strong></td>
		                </tr>
				    </tbody>
				  </table>

		   	</div><!--fin box-body-->
      	</div><!--fin box-->	
	</div><!--fin col-xs-12-->

	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
		<div class="box">
            <div class="" id="tab2">
				<h2 class="reporte_compras_general container-fluid bg-red text-white col-lg-12 text-center mh-50">Porcentaje por año de ventas</h2>
		         
		        <table class="table table-bordered">
	                <thead>
	                    <th>AÑO</th>
				        <th>TOTAL</th>
				        <th>PORCENTAJE %</th>
	                </thead>

	                <tbody>
                 
                    <?php 

                    $arregloReg = array();
                    for($i=0; $i<count($datos_ano); $i++){
                  
			            array_push($arregloReg, 
					            array(
					
						     	'año' => $datos_ano[$i]["año"],
						     	'total_venta_año' => $datos_ano[$i]["total_venta_año"]
				            )
				        );
				   }//cierre del primer ciclo for

				   //segundo for
                   $sumaTotal = 0;

				   for($j=0;$j<count($arregloReg);$j++){
                     
                     //sumo el total de los años
                     $sumaTotal = $sumaTotal + $datos_ano[$j]["total_venta_año"];
 
				    }
                   
                    $porcentaje_total=0;

					for($i=0;$i<count($arregloReg);$i++) {

	             		//CALCULO DEL PORCENTAJE
				  		$dato_por_ano=$arregloReg[$i]["total_venta_año"];
				 
				 		$porcentaje_por_ano= round(($dato_por_ano/$sumaTotal)*100,2);	

				  		$porcentaje_total= $porcentaje_total+ $porcentaje_por_ano;
	              
	                    ?>

		                 <tr>
		                 	<td align="center"><?php echo $arregloReg[$i]["año"];?></td>
		                 	<td align="center">$ <?php echo $arregloReg[$i]["total_venta_año"];?></td>
		                    <td align="center"><?php echo $porcentaje_por_ano?></td>
		                 </tr>

		                 <?php 

	                } //cierre delfor

	                ?>
		                <tr>
		                	<td align="center"><strong>Total:</strong>  </td>
		                	<td align="center"><strong>$ <?php echo $sumaTotal?> </strong></td>
		                	<td align="center"> <strong> <?php echo $porcentaje_total?> </strong></td>
		                </tr>

	                </tbody>
	             </table>

		        </div><!--fin box-body-->
            </div><!--fin box-->
		</div><!--fin col-xs-6-->
    </div><!--fin row-->

  <!--FILA DE LA GRAFICAS-->
	<div class="row">

	     <!--VENTAS HECHAS-->

		 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

		    <div class="box">

		       <div class="">

				<h2 class="reporte_compras_general container-fluid bg-red text-white col-lg-12 text-center mh-50">Gráfico reporte general de ventas</h2>
  
          <!--GRAFICA-->
           <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>

	            </div><!--fin box-body-->
	        </div><!--fin box-->
		</div><!--fin col-lg-6-->
 
        <!--VENTAS CANCELADAS-->

		 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

		    <div class="box">

		       <div class="">

				<h2 class="reporte_compras_general container-fluid bg-primary text-white col-lg-12 text-center mh-50">Gráfico general de ventas canceladas</h2>

		          <!--GRAFICA-->
		           <div id="container_cancelada" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>

	            </div><!--fin box-body-->
	        </div><!--fin box-->
		</div><!--fin col-lg-6-->
	</div><!--fin row-->

<!--DATOS DE PERDIDAS-->
	<div class="row">
		<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
	    	<div class="box">
	       		<div class="" id="perd1">
					<h2 class="reporte_compras_general container-fluid bg-primary text-white col-lg-12 text-center mh-50">Reporte general de perdidas</h2>
				              
				  	<table class="table table-bordered">
					    <thead>
					      	<tr>
						        <th>AÑO</th>
						        <th>N° MES</th>
						        <th>NOMBRE MES</th>
						        <th>TOTAL</th>
					      	</tr>
				    	</thead>
				    <tbody>
				     
                    <?php
                   
                   		$arregloReg = array();

	                    for($i=0; $i<count($datosp); $i++){
	                  
				        	array_push($arregloReg, 
						            array(
					
					     	'anio' => $datosp[$i]["anio"],

					     	'totalPerdida' => $datosp[$i]["totalPerdida"]
					               
					            )
					        );
					    }
          
	                    $total_perdidas = 0;
	                    for($j=0; $j<count($arregloReg); $j++){
	                       	$total_perdidas = $total_perdidas + $datosp[$j]["totalPerdida"];
	                   	}

	                   	 $sumaTotal = 0;

				   		for($j=0;$j<count($arregloReg);$j++){
	                     	//sumo el total de los años
	                     	$sumaTotal = $sumaTotal + $datosp[$j]["totalPerdida"];
				    	}

		                $porcentaje_total = 0;
	                    for($i=0; $i<count($datosp); $i++){

					    //imprime la fecha por separado ejemplo: dia, mes y año
	                       $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	 
	                       $fecha = $datosp[$i]["mes"];
	                       $fecha_mes = $meses[date("n", strtotime($fecha))-1];

	                       
	                        
					     	?>

						      <tr>
						        <td align="center"><?php echo $datosp[$i]["anio"]?></td>
						        <td align="center"><?php echo $datosp[$i]["numero_mes"]?></td>
						        <td align="center"><?php echo $fecha_mes?></td>
						        <td align="center"><?php echo "$"." ".$datosp[$i]["totalPerdida"]?></td>
						      </tr>
						      
					     	<?php

	                    }//cierre del for
                   
				      ?>
	                  	<tr>
		                	<td align="center"><strong>Total:</strong></td>
		                	<td><strong></strong></td>
		                	<td><strong></strong></td>
		                	<td align="center"><strong>$ <?php echo $total_perdidas?></strong></td>
		                </tr>
				    </tbody>
				  </table>

		   </div><!--fin box-body-->
      	</div><!--fin box-->		
	</div><!--fin col-xs-12-->

<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
		<div class="box">
            <div class="" id="perd">
				<h2 class="reporte_compras_general container-fluid bg-red text-white col-lg-12 text-center mh-50">Porcentaje por año de perdidas</h2>
		         
		        <table class="table table-bordered">
	                <thead>
	                    <th>AÑO</th>
				        <th>TOTAL</th>
				        <th>PORCENTAJE %</th>
	                </thead>

	                <tbody>
                 
                    <?php 

                    $arregloReg = array();
                    for($i=0; $i<count($datosp_anio); $i++){
                  
			            array_push($arregloReg, 
					            array(
					
						     	'anio' => $datosp_anio[$i]["anio"],
						     	'total_perdida_anio' => $datosp_anio[$i]["total_perdida_anio"]
				            )
				        );
				   }//cierre del primer ciclo for

				   //segundo for
                   $sumaTotal = 0;

				   for($j=0;$j<count($arregloReg);$j++){
                     
                     //sumo el total de los años
                     $sumaTotal = $sumaTotal + $datosp_anio[$j]["total_perdida_anio"];
 
				    }
                   
                    $porcentaje_total=0;

					for($i=0;$i<count($arregloReg);$i++) {

				  		//CALCULO DEL PORCENTAJE
					  		$dato_por_anio = $arregloReg[$i]["total_perdida_anio"];
					 		$porcentaje_por_anio = round(($dato_por_anio/$sumaTotal)*100,2);	
					  		$porcentaje_total = $porcentaje_total + $porcentaje_por_anio;
	              
	                    ?>

		                 <tr>
		                 	<td align="center"><?php echo $arregloReg[$i]["anio"];?></td>
		                 	<td align="center">$ <?php echo $arregloReg[$i]["total_perdida_anio"];?></td>
		                    <td align="center"><?php echo $porcentaje_por_anio?></td>
		                 </tr>

		                 <?php 

	                } //cierre delfor

	                ?>
		                <tr>
		                	<td align="center"><strong>Total:</strong>  </td>
		                	<td align="center"><strong>$ <?php echo $sumaTotal?> </strong></td>
		                	<td align="center"> <strong> <?php echo $porcentaje_total?> </strong></td>
		                </tr>

	                </tbody>
	             </table>

		        </div><!--fin box-body-->
            </div><!--fin box-->
		</div><!--fin col-xs-6-->
    </div><!--fin row-->

 <!--FILA DE LA GRAFICAS-->
	<div class="row">
     <!--VENTAS HECHAS-->
	 	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	    	<div class="box">
	       		<div class="">

					<h2 class="reporte_compras_general container-fluid bg-primary text-white col-lg-12 text-center mh-50">Gráfico reporte general de perdidas</h2>
	      
		          <!--GRAFICA-->
		           <div id="container_perdidas" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>

 				</div><!--fin box-body-->
		    </div><!--fin box-->
		</div><!--fin col-lg-6-->
	</div><!--fin row-->
	</div>
	</section>
</div><!-- /.content-wrapper -->

<?php require_once("footer.php");?>
<script type="text/javascript">

	//VENTAS GENERALES
    $(document).ready(function() {

	//Highcharts.chart('container', {

	var chart = new Highcharts.Chart({
	//$('#container').highcharts({
        
    chart: {
    	
        renderTo: 'container', 
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },

        exporting: {
        url: 'http://export.highcharts.com/',
        enabled: false

    },

    title: {
        text: ''
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
        	showInLegend:true,
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',

                    fontSize: '20px'
                }
            }
        }
    },
     legend: {
        symbolWidth: 12,
        symbolHeight: 18,
        padding: 0,
        margin: 15,
        symbolPadding: 5,
        itemDistance: 40,
        itemStyle: { "fontSize": "17px", "fontWeight": "normal" }
    },

    series: [

    {
		name: 'Brands',
		colorByPoint: true,
		data: [

		<?php echo $datos_grafica= $ventas->suma_ventas_total_grafica();?>
		    ]
    }], 

    exporting: {
    enabled: false
 }

});

	//VENTAS CANCELADAS

	var chart = new Highcharts.Chart({
    //$('#container').highcharts({
        
	    chart: {
	    	
	        renderTo: 'container_cancelada', 
	        plotBackgroundColor: null,
	        plotBorderWidth: null,
	        plotShadow: false,
	        type: 'pie'
	    },

	        exporting: {
	        url: 'http://export.highcharts.com/',
	        enabled: false

        },

	    title: {
	        text: ''
	    },
	    tooltip: {
	        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
	    },
	    plotOptions: {
	        pie: {
	        	showInLegend:true,
	            allowPointSelect: true,
	            cursor: 'pointer',
	            dataLabels: {
	                enabled: true,
	                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
	                style: {
	                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',

	                    fontSize: '20px'
	                }
	            }
	        }
	    },
	     legend: {
	        symbolWidth: 12,
	        symbolHeight: 18,
	        padding: 0,
	        margin: 15,
	        symbolPadding: 5,
	        itemDistance: 40,
	        itemStyle: { "fontSize": "17px", "fontWeight": "normal" }
	    },

	    series: [

        {
			name: 'Brands',
			colorByPoint: true,
			data: [

  			<?php echo $datos_grafica= $ventas->suma_ventas_cancelada_total_grafica();?>
	    ]

	    }], 

	    exporting: {
        enabled: false
     }

	});


	//PERDIDAS GENERALES
	var chart = new Highcharts.Chart({
	//$('#container').highcharts({
        
    chart: {
    	
        renderTo: 'container_perdidas', 
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },

        exporting: {
        url: 'http://export.highcharts.com/',
        enabled: false

    },

    title: {
        text: ''
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
        	showInLegend:true,
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',

                    fontSize: '20px'
                }
            }
        }
    },
     legend: {
        symbolWidth: 12,
        symbolHeight: 18,
        padding: 0,
        margin: 15,
        symbolPadding: 5,
        itemDistance: 40,
        itemStyle: { "fontSize": "17px", "fontWeight": "normal" }
    },

    series: [

    {
		name: 'Brands',
		colorByPoint: true,
		data: [

		<?php echo $datos_grafica = $perdidas->get_perdidas_general_grafica();?>
		    ]
    }], 

    exporting: {
    enabled: false
 }

});

	/*****FIN VENTAS CANCELADAS************************************/

			//si se le da click al boton entonces se envia la imagen al archivo PDF por ajax
			$('#buttonExport').click(function() {
           
			   //alert("clic");
	            imprSelec()
				document.addEventListener("DOMContentLoaded", function(event) {
				 imprSelec()
				});

    		}); 
			//fin prueba
});

 //function
		function imprSelec() {
    var grafica1 = document.getElementById("container_perdidas");
    var grafica2 = document.getElementById("container");
    var tabla1 = document.getElementById("tab");
     var tabla2= document.getElementById("tab2");
      var tabla3 = document.getElementById("perd");
       var tabla4 = document.getElementById("perd2")
    var ventimp = window.open(' ', 'popimpr');
   
    ventimp.document.write('<div align="center">');
     ventimp.document.write('<p><h1>Campo Escuela Salcoatitan</h1><br>' );
    ventimp.document.write(tabla1.innerHTML );
    ventimp.document.write(tabla2.innerHTML );
     ventimp.document.write(grafica2.innerHTML );
     ventimp.document.write(tabla3.innerHTML );
     //ventimp.document.write(tabla4.innerHTML );
     ventimp.document.write(grafica1.innerHTML );
     ventimp.document.write('<div>');
     
    ventimp.document.close();
    ventimp.print( );
    ventimp.close();
  }
	
</script>
<?php  } else {

       require("noacceso.php");
  }
   
  ?><!--CIERRE DE SESSION DE PERMISO -->

<?php
   }
?>
<?php


   
   require_once("../config/conexion.php");
   require_once("../modelos/Roles.php");

   if(isset($_SESSION["id_usuario"])){
 $usuario = new Roles();
   	require_once("../modelos/Venta.php");

   	 
//SI EXISTE EL POST ENTONCES SE LLAMA AL METODO PARA SELECCIONAR LA FECHA
     
    $ventas=new Ventas();

   	if(isset($_POST["year"])){
   

      $datos= $ventas->get_ventas_mensual($_POST["year"]);  
 
    } else {

    	$fecha_inicial=date("Y");

        $datos= $ventas->get_ventas_mensual($fecha_inicial);  
    }


     $fecha_ventas= $ventas->get_year_ventas();
?>


<!-- INICIO DEL HEADER - LIBRERIAS -->
<?php 
#variable para mostrar como item activo
$activar = 'item_reporteVenta';
$activar2 = 'item_reporteVenta2';
require_once("header.php");?>

<!-- FIN DEL HEADER - LIBRERIAS -->
<?php if($_SESSION["VENTA"]==1)
     {

     ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
<section class="content-header">
      
      <h1>Reporte de ventas mensual</h1>
      
      <!-- migas de pan -->
      <ol class="breadcrumb">
         <li><a href="inicio.php"><i class="fa fa-home"></i>Inicio</a></li>
         <li><i class="fa fa-file-text"></i> Reportes V por M</li>
      </ol>

   </section>
<section class="content">
	<div class="box panel-body">

   <h2 class="reporte_compras_general container-fluid bg-red text-white col-lg-12 text-center mh-50">
        
         Reporte de ventas mensual
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

   <div class="panel panel-default" >
        
        <div class="panel-body">

            <form  action="reporte_ventas_mensual.php" class="form-inline" method="post">

            
              <div class="form-group">
                <!--<label for="staticEmail" class="col-sm-2 col-form-label">Año</label>-->
                 <div class="col-sm-10">
                  <select class="form-control" name="year" id="year">
						 <option value="0">Seleccione...</option>
						 <?php
                       
                         
                       //si se envia el POST
                       if(isset($_POST["year"])){
                          
                          //$year= date("Y");

						 for($i=0; $i<count($fecha_ventas); $i++){

                          //if($i==$datos[0]["ano"]){

                          	if($fecha_ventas[$i]["fecha"]==$_POST["year"]){


                          	echo '<option value="'.$fecha_ventas[$i]["fecha"].'" selected=selected>'.$fecha_ventas[$i]["fecha"].'</option>';
                                  
       	      
                            }else{ 

                                   	echo '<option value="'.$fecha_ventas[$i]["fecha"].'">'.$fecha_ventas[$i]["fecha"].'</option>';
                             } 

                        }//cierre del ciclo for

                       
                       //SI NO SE ENVIA EL POST
                       } else {

                            //$year= date("Y");

						 for ($i=0; $i<count($fecha_ventas); $i++){


						//if($fecha_compras[$i]["fecha"]==$year){
       

                    echo '<option value="'. $fecha_ventas[$i]["fecha"].'" selected=selected>'. $fecha_ventas[$i]["fecha"].'</option>';
                           
						 //}          

                        }//cierre del ciclo for

                      }//cierre del ese*/

					  ?>
						 
					 </select>
                 </div>
              </div>

             

               <div class="btn-group text-center">
               	 <?php 
                             $rol=$usuario->listar_roles_por_usuario($_SESSION['id_usuario']);
                            $valores=array();
                            //Almacenamos los permisos marcados en el array
                             foreach($rol as $rows){

                             $valores[]= $rows["codigo"];
                                }   
                                if(in_array("COREPO",$valores)){
                                  echo '<button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Consultar</button>';
              }
                            ?>
                 
               </div>
           </form>

       </div>
      </div>

 

	<div class="row">

	 <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">

	    <div class="box">

	       <div class="" id="tab">

				  <h2 class="reporte_compras_general container-fluid bg-primary text-white col-lg-12 text-center mh-50">reporte de ventas mensuales</h2>
				              
				  <table class="table table-bordered" >
				    <thead >
				      <tr >
				        <th>AÑO</th>
				        <th>N° MES</th>
				        <th>NOMBRE MES</th>
				        <th>TOTAL</th>
				      </tr>
				    </thead>

				     <tbody>

				     
                   <?php


			   	  //si existe el envia del post entonces se llama al metodo
			   	  if(isset($_POST["year"])){
			    
				//SI EXISTE EL POST ENTONCES SE LLAMA AL METODO

			      $datos= $ventas->get_ventas_mensual($_POST["year"]);  

				    
                    for($i=0;$i<count($datos);$i++){

                    	  //imprime la fecha por separado ejemplo: dia, mes y año
                      $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 
                       $fecha= $datos[$i]["mes"];

                       $fecha_mes = $meses[date("n", strtotime($fecha))-1];

    			     ?>


					      <tr >
					        <td><?php echo $datos[$i]["año"]?></td>
					        <td><?php echo $datos[$i]["numero_mes"]?></td>
					        <td><?php echo $fecha_mes?></td>
                            <td><?php echo "$"." ".$datos[$i]["total_venta"]?></td>
					      </tr>
					      
				      <?php

                       
                        }//cierre del for

                     

                     } else {


                     //SI NO EXISTE EL POST ENTONCES SE LLAMA AL METODO

                     	$fecha_inicial=date("Y");

			           $datos= $ventas->get_ventas_mensual($fecha_inicial);  

				    
                        for($i=0;$i<count($datos);$i++){


                    	  //imprime la fecha por separado ejemplo: dia, mes y año
                      $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 
                       $fecha= $datos[$i]["mes"];

                       $fecha_mes = $meses[date("n", strtotime($fecha))-1];


    			     ?>


					      <tr>
					        <td align="center"><?php echo $datos[$i]["año"]?></td>
					        <td align="center"><?php echo $datos[$i]["numero_mes"]?></td>
					        <td align="center"><?php echo $fecha_mes?></td>
                            <td><?php echo "$"." ".$datos[$i]["total_venta"]?></td>
					      </tr>
					      
				      <?php

                       
                        }//cierre ciclo for

                     }//cierre condicional else
                                 
				      ?>
                      
                  
				    </tbody>

				   
				  </table>

		   </div><!--fin box-body-->
      </div><!--fin box-->
			
		</div><!--fin col-xs-12-->

		  <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
		  	  <div class="box">

	             <div class="" id="tab">

				   
		         <h2  class="reporte_compras_general container-fluid bg-red text-white col-lg-12 text-center mh-50">Reporte de ventas mensuales</h2>

      
	          <!--GRAFICA-->
	           <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
		        


		         </div><!--fin box-body-->
               </div><!--fin box-->
		  </div><!--fin col-xs-6-->

  </div><!--fin row-->

</div>
</section>

</div>
  <!-- /.content-wrapper -->

 

   <?php require_once("footer.php");?>

      <!--AJAX COMPRAS-->
<!--<script type="text/javascript" src="js/compras.js"></script>-->



				<script type="text/javascript">

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

          <?php 

           //si existe el envia del post entonces se llama al metodo
		  if(isset($_POST["year"])){

          echo $datos_grafica= $ventas->sumas_ventas_anio_mes_grafica($_POST["year"]);

           } else {

           //sino existe el envio post entonces se mostraran los datos de la grafica del año actual
           
           $fecha_inicial=date("Y");
          

           	echo $datos_grafica= $ventas->sumas_ventas_anio_mes_grafica($fecha_inicial);
           }

          ?>
			    ]

			    }], 

			    exporting: {
                enabled: false
             }

			});

			//si se le da click al boton entonces se envia la imagen al archivo PDF por ajax
			$('#buttonExport').click(function() {
           

			   
         imprSelec();
            
			document.addEventListener("DOMContentLoaded", function(event) {
			
       imprSelec(); 
			});

  
    }); 
			//fin prueba

});

 //function para imprimir la informacion

	function imprSelec() {
    var grafica = document.getElementById("container");
    var tabla = document.getElementById("tab");
    var ventimp = window.open(' ', 'popimpr');
   
    ventimp.document.write('<div align="center">');
     ventimp.document.write('<p><h1>Campo Escuela Salcoatitan</h1><br>' );
    ventimp.document.write(tabla.innerHTML );
     ventimp.document.write(grafica.innerHTML );
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
<?php
   require_once("../config/conexion.php");
    if(isset($_SESSION["correo"])){
      /*Se llaman los modelos y se crean los objetos para llamar el numero de registros en el menu lateral izquierdo y en el home*/
      
      require_once("../modelos/Venta.php");
      require_once("../modelos/Perdidas.php");
       require_once("../controlador/infocajas.php");
      
      $venta = new Ventas();
      $perdidas = new Perdidas();
      $informacion= new infocajas();

      $datos_venta = $venta->get_ventas_anio_actual();
      $datos = $perdidas->get_perdidas_anio_actual();
?>

<?php
$activar = 'item_home';
require_once("header.php");?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Inicio
      </h1>

<?php 
if(isset($_SESSION["bienvenida"])){}else{ ?>
<div class="alert alert-info alert-dismissible" style="margin-top: 1rem;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4 style="margin-bottom: 0px!important;"><i class="icon fa fa-info"></i> Bienvenido! <?php echo $_SESSION["usuario"]?></h4>
              <!-- Aqui puede ir algo más -->
              </div>

<?php }
$_SESSION["bienvenida"]=1; ?>

    </section>

    <!-- Main content -->
      <section class="content">
      <div class="container-fluid">
        
        <div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box" >
      <span class="info-box-icon bg-info" style="background-color: #17a2b8 !important"><i class="fa fa-usd" aria-hidden="true"></i></span>

              <div class="info-box-content">
                <span class="info-box-text" >Ventas</span>
                <?php 
                $informacion-> infoventas();

               ?>
              
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-success" style="background-color: #28a745 !important"><i class="fa fa-leaf" ></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Productos</span>
                <?php 
                $informacion-> infoproducto();

               ?>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-warning"  style="background-color: #ffc107!important"><i class="fa fa-paperclip"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Incidentes</span>
                <?php 
                $informacion-> infoincidentes();

               ?>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-danger"  style="background-color: #dc3545!important;"><i class="fa fa-gift" aria-hidden="true"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Donaciones</span>
                <?php 
                $informacion-> infodonaciones();

               ?>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>


 <!--INICIO CONTENIDO-->

      <h2 class="container-fluid bg-primary text-white text-center mh-50">
          Resumen de perdida del año <?php echo date("Y");?>
      </h2>

    <!--COMPRAS ACTUAL-->
        
        <div class="">
           
           <div class="box">

            <div class="box-body">

                      
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="width: 10%">AÑO</th>
                <th style="width: 10%">MES</th>
                <th style="width: 10%">PORCENTAJE(%)</th>
                <th style="width: 10%">TOTAL</th>
                <th style="width: 30%" class="hidden-xs">BARRA PROGRESO DE PERDIDA MENSUALES</th>
              </tr>
            </thead>

             <tbody>

               <?php
                
                $arregloReg = array();
           
               for($i=0;$i<count($datos);$i++){

                  array_push($arregloReg, array(

                      "anio" => $datos[$i]["anio"],
                      "mes" => $datos[$i]["mes"],
                      "totalPerdida" => $datos[$i]["totalPerdida"]
                    )

                  );

                }

             ?>

             <?php  
                    
                    $sumaTotal = 0;

                    for($i=0;$i<count($arregloReg);$i++){

                     //sumo el total de los años en porcentajes
                      
                      $sumaTotal = $sumaTotal + $datos[$i]["totalPerdida"];
                    }

                 ?>

                 <?php

                    for($i=0;$i<count($arregloReg);$i++){

                     //imprime la fecha por separado ejemplo: dia, mes y año
                      $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 
                      $fecha= $arregloReg[$i]["mes"];

                      $fecha_mes = $meses[date("n", strtotime($fecha))-1];

                      //calculo de porcentaje
                      $porcentaje = round($arregloReg[$i]["totalPerdida"]/$sumaTotal*100,2);
                
                 ?>


                <tr>
                  <td><?php echo $arregloReg[$i]["anio"]?></td>
                  <td><?php echo $fecha_mes?></td>
                  <td><?php echo $porcentaje?></td>
                  <td><?php echo "US$"." ".$arregloReg[$i]["totalPerdida"]?></td>


                  <td class="hidden-xs">
                     <div class="progress progress-xs" style="height: 30%" >

                       <?php

                       /*poner los colores de la barra de acuerdo al %*/
                           
                           if($porcentaje>24){

                            $clase="progress-bar progress-bar-primary";


                           } else if($porcentaje>10 or $porcentaje<24) {

                               $clase="progress-bar progress-bar-yellow";
                             
                             } else if($porcentaje<=10) {

                               $clase="progress-bar progress-bar-danger";
                             
                             }

                       ?>


                        <div class="<?php echo $clase;?>" style="width: <?php echo $porcentaje;?>%">
                        <?php echo $porcentaje;?>%
                        </div>
                     </div>
                  </td>
                </tr>
                
              <?php

                       
            }//cierre del for


              ?>

              <td></td>
              <td><strong>TOTAL (<?php echo date("Y");?>)</strong></td>
              <td><strong>100%</strong></td>
              <td><strong><?php echo "US$ ".$sumaTotal?></strong></td>
                  
            </tbody>

           
          </table>

       </div><!--fin box-body-->
      </div><!--fin box-->
      
    </div><!--fin col-sm-6-->

     


        <h2 class="container-fluid bg-red text-white text-center mh-50"> 
            Resumen de ventas del año <?php echo date("Y");?>
        </h2>

    <!--VENTAS ACTUAL-->


        
        <div class="">
           
           <div class="box">

            <div class="box-body">

                      
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="width: 10%">AÑO</th>
                <th style="width: 10%">MES</th>
                <th style="width: 10%">PORCENTAJE(%)</th>
                <th style="width: 10%">TOTAL</th>
                <th style="width: 30%" class="hidden-xs">BARRA PROGRESO DE VENTAS MENSUALES</th>
              </tr>
            </thead>

             <tbody>

                   <?php
                    
                    $arregloReg= array();
               
                    for($i=0;$i<count($datos_venta);$i++){

                      array_push($arregloReg, array(

                          "ano" => $datos_venta[$i]["año"],
                          "mes" => $datos_venta[$i]["mes"],
                          "total_venta_mes" => $datos_venta[$i]["total_venta_mes"]

                          )

                      );

                    }

                 ?>

                 <?php  
                    
                    $sumaTotal=0;

                    for($i=0;$i<count($arregloReg);$i++){

                     //sumo el total de los años
                      
                      $sumaTotal = $sumaTotal + $datos_venta[$i]["total_venta_mes"];
                    }

                 ?>


                 <?php

                    for($i=0;$i<count($arregloReg);$i++){


                     //imprime la fecha por separado ejemplo: dia, mes y año
                      $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 
                       $fecha= $arregloReg[$i]["mes"];

                       $fecha_mes = $meses[date("n", strtotime($fecha))-1];


                    //calculo de porcentaje

                     $porcentaje= round($arregloReg[$i]["total_venta_mes"]/$sumaTotal*100,2);
                

                 ?>


                <tr>
                  <td><?php echo $arregloReg[$i]["ano"]?></td>
                  <td><?php echo $fecha_mes?></td>
                  <td><?php echo $porcentaje?></td>
                  <td><?php echo "$"." ".$arregloReg[$i]["total_venta_mes"]?></td>
                  <td class="hidden-xs">
                     <div class="progress progress-xs" style="height: 30%">

                       <?php

                       /*poner los colores de la barra de acuerdo al %*/
                           
                          if($porcentaje>24){

                            $clase="progress-bar progress-bar-primary";

                          } else if($porcentaje>10 or $porcentaje<24) {

                            $clase="progress-bar progress-bar-yellow";
                             
                          } else if($porcentaje<=10) {

                            $clase="progress-bar progress-bar-danger";
                             
                          }

                       ?>

                        <div class="<?php echo $clase;?>" style="width: <?php echo $porcentaje;?>%">
                        <?php echo $porcentaje;?>%
                        </div>
                     </div>
                  </td>
                </tr>
                
              <?php

                       
            }//cierre del for
              ?>

              <td></td>
              <td><strong> TOTAL (<?php echo date("Y");?>)</strong></td>
              <td><strong>100%</strong></td>
              <td><strong><?php echo "US$ ".$sumaTotal?></strong></td>
                  
            </tbody>

           
          </table>

       </div><!--fin box-body-->
      </div><!--fin box-->
      
    </div><!--fin col-sm-6-->



 <!--GRAFICA PERDIDA-->
    <div class="row">

          <div class="col-lg-6 col-xs-12">
        
         <div class="box">

               <div class="box-body">

               <h2 class="bg-primary text-white col-lg-12 text-center">Resumen de perdida del año <?php echo date("Y");?></h2>

              <!--GRAFICA-->
             
              <div id="container_perdidas" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
            

                </div><!--fin box-body-->
          </div><!--fin box-->
      </div><!--col-sm-->


      <!--GRAFICA VENTAS-->
        <div class="col-lg-6 col-xs-12">
        
         <div class="box">

               <div class="box-body">

               <h2 class="bg-red text-white col-lg-12 text-center">Resumen de ventas del año <?php echo date("Y");?></h2>

      
              <!--GRAFICA-->
              <div id="container_ventas" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>



                </div><!--fin box-body-->
          </div><!--fin box-->
      </div><!--col-sm-->

    </div><!--fin row-->
        
           <!--FIN CONTENIDO-->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php require_once("footer.php");?>
<script type="text/javascript">
   
   
   /*GRAFICA VENTAS*/
     $(document).ready(function() {

      //Highcharts.chart('container', {

      var chart = new Highcharts.Chart({
      //$('#container').highcharts({
        
         chart: {
            
              renderTo: 'container_ventas', 
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
              <?php echo $datos_grafica = $venta->get_ventas_anio_actual_grafica();?>
            ]

          }], 

          exporting: {
                enabled: false
             }
      });

});

  //GRAFICA DE PERDIDAS
  $(document).ready(function() {

      //Highcharts.chart('container', {

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

        <?php echo $datos_grafica= $perdidas->get_perdidas_anio_actual_grafica();?>
          ]

          }], 

          exporting: {
                enabled: false
             }
             
      });

});


  
</script>

<?php
     } else {
        header("Location:".Conectar::ruta()."vistas/index.php");
        exit();
     }
  ?>

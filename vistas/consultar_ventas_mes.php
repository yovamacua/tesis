
<?php

   require_once("../config/conexion.php");

    if(isset($_SESSION["id_usuario"])){
        
      require_once("../modelos/Venta.php");
      $venta = new Ventas();
      $vent= $venta->mes();
      $anio= $venta->anio()
?>


<!-- INICIO DEL HEADER - LIBRERIAS -->
<?php 
  #variable para mostrar como item activo
  $activar = 'item_venta';
  $activar4 = 'item_venta4';
  require_once("header.php");?>

<!-- FIN DEL HEADER - LIBRERIAS -->
<?php if($_SESSION["VENTA"]==1)
     {

     ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
   
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Consulta de Ventas por mes
       
      </h1>
      <ol class="breadcrumb">
             <li><a href="inicio.php"><i class="fa fa-home"></i>Inicio</a></li>
             <li><i class="fa fa-search"></i> Consulta</li>
          </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    
   <div id="resultados_ajax"></div>

     <div class="panel panel-default">
        
        <div class="panel-body" id="ocultar">

            <form class="form-inline">
              <div class="form-group">
               
                 <div class="col-sm-10">
                    <select name="mes" id="mes" class="form-control">
                                <option value="">MES</option>
                                 <?php
                          foreach ($vent as $row) {
                            $num=$row["numero_mes"];
                            $mes=$row["meses"];
                            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 
                      $fecha= $mes;

                      $fecha_mes = $meses[date("n", strtotime($fecha))-1];

                            echo '<option value="'.$num.'">'.$fecha_mes.'</option>';
                          }

                             ?>
                              
                         
                              </select>
                 </div>
              </div>

              <div class="form-group row">
                
                <div class="col-sm-10">
                  <select name="ano" id="ano" class="form-control">
                                  <option value="">AÑO</option>
                                       <?php
                          foreach ($anio as $rows) {
                            $anios=$rows["año"];
                            print_r($anios);
                           
                            echo '<option value="'.$anios.'">'.$anios.'</option>';
                          }

                             ?>
                              
                         
                                </select>
                </div>
              </div>

            

               <div class="btn-group text-center">
                 <button type="button" class="btn btn-primary" id="btn_venta_fecha_mes"><i class="fa fa-search" onclick="mostrarformulario(true) aria-hidden="true"></i> Consultar</button>
               </div>
           </form>

       </div>
      </div>


      
    
   
      <div class="row">
        <div class="col-xs-12">
          
          <div class="table-responsive">
            <div class="box-header">
              <h3 class="box-title">Lista de Ventas por mes</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="ventasfechas">
             <table id="ventas_fecha_mes_data" class="table table-bordered table-striped">
                <thead>
                <tr style="background-color:#A9D0F5">
                   <th>Detalles</th>
                  <th>Vendedor</th>
                  <th>Total</th>
                  <th>Numero venta</th>
                  <th>fecha Venta</th>
                  <th style="background-color:#A9D0F5 !important">Estado</th>
                  
                 
                </tr>
                </thead>
                
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
       <div class="row">

          
        <div class="col-md-12">

            <div class="box">
           
              <div class="box-body">

                    <div class="panel-body table-responsive" id="formularioregistros3">
                      
                      
                       <form name="formulario" id="formulario"style="width: 90%;" method="POST">
                         <div class="form-group table-responsive">
                     <label for="" class="col-lg-3 control-label">Usuario:</label>

                  <div class="col-lg-9">
                    <input type="text" class="form-control" id="nombre" name="nombre"  style="width:50%;" value="<?php echo $_SESSION["nombre"];?>" readonly/>
                  </div>
              </div>   
              <div class="form-group">
                     <label for="" class="col-lg-3 control-label">Fecha(*)</label>

                  <div class="col-lg-9">
                    <input type="date" class="form-control" id="fecha" name="fecha" style="width:50%;"  />
                  </div>
              </div>
               <div class="form-group  ">
                     <label for="" class="col-lg-3 control-label">Numero Venta:</label>
              <div class="col-lg-9">
                    <input type="text" class="form-control" id="numero_venta" name="numero_venta" placeholder="Número" style="width:50%;" />
              </div>  
                         
                          <div class="form-group ">
                            <a data-toggle="modal" href="#myModal">           
                              <button  id="btnAgregarArt" type="button" class="btn btn-primary" onclick="listarProductoVenta()" data-toggle="modal" data-target="lista_productos_ventas_Modal"> <span class="fa fa-plus"></span> Agregar Productos</button>
                            </a>
                          </div>
                    </div>
                     <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                              <thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Venta</th>
                                    <th>Subtotal</th>
                                </thead>
                                <tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="total">$/. 0.00</h4><input type="hidden" name="total_pagar" id="total_pagar"></th> 
                                </tfoot>
                                <tbody>
                                  
                                </tbody>
                            </table>
                          </div>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" name ="Guardar" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Comprar</button>

                            <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                      <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_usuario"];?>" />
                            
                          </div>
                           </form>
                      </div>
                       
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php  } else {

       require("noacceso.php");
  }
   
  ?><!--CIERRE DE SESSION DE PERMISO -->

   <?php require_once("footer.php");?>

    <!--AJAX PROVEEDORES-->
<script type="text/javascript" src="js/ventas.js"></script>


<?php
   
  } else {

        header("Location:".Conectar::ruta()."vistas/index.php");
     }

?>
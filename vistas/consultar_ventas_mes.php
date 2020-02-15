
<?php

   require_once("../config/conexion.php");

    if(isset($_SESSION["id_usuario"])){
        

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
                                <option value="01">ENERO</option>
                                <option value="02">FEBRERO</option>
                                <option value="03">MARZO</option>
                                <option value="04">ABRIL</option>
                                <option value="05">MAYO</option>
                                <option value="06">JUNIO</option>
                                <option value="07">JULIO</option>
                                <option value="08">AGOSTO</option>
                                <option value="09">SEPTIEMBRE</option>
                                <option value="10">OCTUBRE</option>
                                <option value="11">NOVIEMBRE</option>
                                <option value="12">DICIEMBRE</option>
                              </select>
                 </div>
              </div>

              <div class="form-group row">
                
                <div class="col-sm-10">
                  <select name="ano" id="ano" class="form-control">
                                  <option value="">AÑO</option>
                                  <option value="2014">2014</option>
                                  <option value="2015">2015</option>
                                  <option value="2016">2016</option>
                                  <option value="2017">2017</option>
                                  <option value="2018">2018</option>
                                  <option value="2019">2019</option>
                                  <option value="2020">2020</option>
                                  <option value="2021">2021</option>
                                  <option value="2022">2022</option>
                                  <option value="2023">2023</option>
                                  <option value="2024">2024</option>
                                  <option value="2025">2025</option>
                                  <option value="2026">2026</option>
                                  <option value="2027">2027</option>
                                  <option value="2028">2028</option>
                                  <option value="2029">2029</option>
                                  <option value="2030">2030</option>
                                  <option value="2031">2031</option>
                                  <option value="2032">2032</option>
                                  <option value="2033">2033</option>
                                  <option value="2034">2034</option>
                                  <option value="2035">2035</option>
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

                    <div class="panel-body table-responsive" id="formularioregistros">
                      
                      
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
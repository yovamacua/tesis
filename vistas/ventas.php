<?php

   require_once("../config/conexion.php");

    if(isset($_SESSION["id_usuario"])){

       require_once("../modelos/Venta.php");
     
       $venta = new Ventas();
    
?>


<!-- INICIO DEL HEADER - LIBRERIAS -->
<?php require_once("header.php");?>
 <!--VISTA MODAL PARA AGREGAR PRODUCTO-->
 <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
             
             <div id="resultados_ajax"></div>

             <h2>Listado de Ventas</h2>

            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title" ><label id="letra">Venta</label></h1>
                            <button class="btn btn-primary btn-lg" id="btnagregar" onclick="mostrarformulario(true)" ><i class="fa fa-plus" aria-hidden="true"></i> Nueva Venta</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                   <div class="panel-body table-responsive" id="listadoregistros">
    
                          <table id="ventas_data" class="table table-bordered table-striped">
                            <thead>
                              
                                                            
                                <th width="5%">Opciones</th>
                                <th width="15%">Usuario</th>
                                <th width="10%">Fecha</th>
                                <th width="5%">Numero venta</th>
                                <th width="5%">Total_Pagar</th>
                                <th width="5%">Estado</th>
                               
                               

                                </tr>

                            </thead>

                            <tbody>
                              

                            </tbody>


                          </table>
                     
                    </div>

                     <!-- columna del formulario venta -->
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
                   <?php 
                          $numero_venta = $venta->numeroventa();
                    ?>
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
                                    <th  width="10%">Opciones</th>
                                    <th  width="10%">Producto</th>
                                    <th  width="10%">stock</th>
                                    <th  width="10%">Cantidad</th>
                                    <th  width="10%">Precio Venta</th>
                                    <th  width="10%">Subtotal</th>
                                </thead>
                                <tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th style="text-align: center"><h4 id="total">$/. 0.00</h4><input type="hidden" name="total_pagar" id="total_pagar"></th> 
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
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
 
    
 <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 40% " >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Seleccione un Producto</h4>
        </div>
        <div class="panel-body table-responsive">
          <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover" >
            <thead>
                <th width="10%">Opciones</th>
                <th width="10%">Producto</th>
                <th width="10%">Categoría</th>
                <th width="10%">Stock</th>
                <th width="10%">Precio Venta</th>
            </thead>
            <tbody>
              
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>        
      </div>
    </div>
  </div>  
  <!-- Fin modal -->
 <!--FIN FORMULARIO VENTANA MODAL-->

<?php require_once("footer.php");?>

 
<script type="text/javascript" src="js/ventas.js"></script>



<?php
   
   } else {

         header("Location:".Conectar::ruta()."vistas/index.php");

     }


?>

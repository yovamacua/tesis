<?php 
   require_once("../config/conexion.php");
    if(isset($_SESSION["id_usuario"])){

      require_once("../modelos/Pedidos.php");
      $pedido = new Pedidos();
      $p = $pedido->get_pedido();

     require_once("../modelos/Unidad.php");
     $unidad = new Unidad();
     $uni = $unidad->get_unidad();
?>

<?php
  #variable para mostrar como item activo
  $activar = 'item_pedidos';
  $activar1 = 'item_pedidos1';
  require_once("header.php");
?>
<?php if($_SESSION["Pedidos"]==1)
     {

     ?>
  <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <section class="content-header">

          <h1>Registro de Pedido</h1>

          <!-- migas de pan-->
          <ol class="breadcrumb">
             <li><a href="home.php"><i class="fa fa-home"></i>Inicio</a></li>
             <li><i class="fa fa-shopping-bag"></i> Pedido</li>
          </ol>
   
        </section>
        <!-- Main content -->
        <section class="content">
          <div id="resultados_ajax"></div>
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header boton-top">
                          <h1 class="box-title">
                            <button class="btn btn-primary btn-lg" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#pedidoModal"><i class="fa fa-plus" aria-hidden="true"></i> Registrar Pedido</button></h1>
                        <div class="box-tools pull-right"></div>
                    </div>
                    <!-- /.box-header -->

                    <!-- centro 1-->
                    <div class="panel-body table-responsive tabla-top" id="listadoregistros">
                          <table id="pedido_data" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                <th width="15%">Autor</th>
                                <th width="15%">No. de Pedido</th>
                                <th width="15%">Fecha</th>
                                <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                          </table>
                    </div>
                    <!--Fin centro 1-->

            <!--Formulario para agregar capacitados -->
            <button id="addInsumo" class="collapsible btn btn-primary btn-lg" onclick="limpiardetalle();" data-target="#detallepedidosModal"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Insumo</button>

            <div class="panel-body table-responsive contenedor" id="detallepedidosModal">
              <form method="post" id="detallepedidos_form" autocomplete="off">

                <div class="form-group col-md-12">

                  <div class="form-group col-md-3">
                    <label>Insumo</label>
                    <input type="text" name="nombreInsumo" id="nombreInsumo" class="form-control" autocomplete="off" placeholder="Insumo" required/>
                    <span class="error_form" id="error_nombreInsumo"></span>
                  </div>

                  <div class="form-group col-md-3">
                    <label>Cantidad</label>
                    <input type="text" name="cantidad" id="cantidad" class="form-control" autocomplete="off" placeholder="Cantidad" required/>
                    <span class="error_form" id="error_cantidad"></span>
                  </div>

                  <div class="form-group col-md-3">
                    <label>Unidad de Medida</label>
                    <select class="form-control" id="unidadMedida" name="unidadMedida" required>
                        <option  value="">Seleccione la Unidad</option>
                          <?php
                             for($i=0; $i<sizeof($uni);$i++){
                               ?>
                                <option value="<?php echo $uni[$i]["idunidad"]?>"><?php echo $uni[$i]["nombre"];?></option>
                               <?php
                             }
                          ?>   
                    </select>
                    <span class="error_form" id="error_unidadMedida"></span>
                  </div>

                  <div class="form-group col-md-3">
                    <label>Descripción</label>
                    <textarea rows="1" maxlength="250" style=" word-break: break-all;    max-width: 100% !important;" cols="250" name="descripcion" id="descripcion" class="form-control" placeholder="Descripción" required/></textarea>
                    <span class="error_form" id="error_descripcion"></span>
                  </div>

                </div>

                    <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_usuario"];?>" />
                    <input type="hidden" name="id_detallepedido" id="id_detallepedido"/>
                    <input type="hidden" name="id_pedido" id="id_pe">
                    <button type="submit" name="action" id="btnGuardarDet" class="btn btn-success pull-left" value="Add" onclick="desvanecer()"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                  
                </form>
              </div>
            <!--Fin formulario para agregar capacitados -->

                    <!-- centro 2-->
                    <div class="panel-body table-responsive tabla-cap" id="listadopedido">
                      <!-- Tabla de insumo -->
                        <table id="detallepedidos_data" class="table table-bordered table-striped">
                          <thead>
                              <tr>
                              <th>Nombre de Insumo</th>
                              <th>Cantidad</th>
                              <th>Descripción</th>
                              <th>Unidad de Medida</th>
                             <?php  if($_SESSION["Eliminar"]==0 and $_SESSION["Editar"]==0 and $_SESSION["Registrar"]==0){
                              
                              }else{
                                  echo '<th>Acciones</th>';
                              }
                                ?>
                              </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>

                        <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_usuario"];?>" />
                        
                    <!-- div para el boton generar archivo de pedido -->
                        <div style="width:200px;">
                         
                          <div style="width:100px; float:left;">
                            <button id="btnCancelar" class="btn btn-danger" type="button" onclick="cancelarform()"><i class="fa fa-arrow-circle-left"></i><font color=white> Regresar</font></a></button>
                          </div> 
                         
                          <div style="width:100px; float:right;">
                            <!--form para generar el archivo excel-->
                            <form action="reportes/hacer_pedido.php" method="post">
                              <input type="hidden" name="id_pedido" id="id_p"/>  
                              <input type="hidden" name="fecha" id="fechaA"/>                            
                              <button  id="btnArchivo" type="submit" class="btn btn-primary" ><i class="fa fa-file-excel-o" aria-hidden="true"></i> Generar Archivo</button>   
                            </form>
                        </div> 

                      </div> 
                    <!-- fin del div del boton generar archivo de pedido -->
                         
                    </div> <!-- /.col -->
                    <!--Fin centro 2-->

                </div>
              </div>
            </div>
          </section><!-- /.content -->
        </div>
  <!--Fin-Contenido-->

 <!--FORMULARIO VENTANA MODAL PEDIDO-->

  <div id="pedidoModal" class="modal fade">
  <div class="modal-dialog">
    <form method="post" id="pedido_form" autocomplete="off">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Registrar fecha del pedido</h4>
        </div>

        <script>
        $(function () {
            $("#fecha1").datepicker({
                format: "dd/mm/yyyy",
                firstDay: 1
            }).datepicker("setDate", new Date());
         });          
     </script>

        <div class="form-row">
          <div class="form-group col-md-12">
            <label>Fecha</label>
            <input type="text" name="fecha" id="fecha1" class="form-control" placeholder="Fecha" required/>
            <span class="error_form" id="error_fecha1"></span>
          </div>
        </div>
     
         <div class="modal-footer">
          <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_usuario"];?>" />
          <input type="hidden" name="id_pedido" id="id_pedido"/>
          <button type="submit" name="action" id="btnGuardarDet" class="btn btn-success pull-left" value="Add" onclick="desvanecer()"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
          <button type="button" onclick="limpiardetalle()" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button>
        </div>
      </div>
    </form>
  </div>
</div>
 <!--FIN FORMULARIO VENTANA MODAL-->

 <?php  } else {

       require("noacceso.php");
  }
   
  ?><!--CIERRE DE SESSION DE PERMISO -->
<?php
  require_once("footer.php");
?>
<script type="text/javascript" src="js/pedidos.js"></script>

<?php
  } else {
        header("Location:".Conectar::ruta()."vistas/index.php");
  }
?>

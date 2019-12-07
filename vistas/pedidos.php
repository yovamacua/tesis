<?php 
   require_once("../config/conexion.php");
    if(isset($_SESSION["id_usuario"])){

      require_once("../modelos/Pedidos.php");
      $pedido = new Pedidos();
      $p = $pedido->get_pedido();
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
                      <h1 class="box-title" ><label id="letra">Pedido</label></h1>
                          <h1 class="box-title">
                            <button class="btn btn-primary btn-lg" id="add_button" onclick="mostrarformulario(true)"   data-target="#pedidoModal"><i class="fa fa-plus" aria-hidden="true"></i> Registrar Pedido</button></h1>
                        <div class="box-tools pull-right"></div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="pedidoModal" >
                      <form name="formulario" id="pedido_form" method="POST">

                        <script>
                          $(function () {
                              $("#fecha1").datepicker({
                                  format: "dd/mm/yyyy",
                                  firstDay: 1
                              }).datepicker("setDate", new Date());
                           });          
                       </script>

                        <div class="form-group table-responsive" style="width: 70%;">
                          <label for="" class="col-lg-3 control-label">Fecha:</label>
                          <div class="col-lg-9">
                            <input type="text" name="fecha" id="fecha1" class="form-control" placeholder="Fecha" required style="width:50%;" class="gui-input" value=""/>
                          </div>
                        </div>

                        <div class="form-group table-responsive" style="width: 70%;">
                          <label for="" class="col-lg-3 control-label">No. de Pedido:</label>
                            <div class="col-lg-9">
                              <input type="text" name="id_pedido" id="id_pedido" class="form-control" required style="width:10%;" readonly="readonly" value=""/>
                            </div> 
                        </div> 

                        <button class="btn btn-primary" name ="Guardar" type="submit" id="btnGuardarCap" onclick="desvanecer()"><i class="fa fa-save"></i> Guardar No. de Pedido</button>
                          
                  <!-- Tabla de insumo -->
                            
                        <button  type="button" id="addInsumo" class="btn btn-primary" data-toggle="modal"data-target="#detallepedidosModal"><i class="fa fa-plus"></i> Agregar Insumo </button>
                            

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
                        
                        </form> 

                        <div style="width:200px;">
                         
                          <div style="width:100px; float:left;">
                            <button id="btnCancelar" class="btn btn-danger" type="button" onclick="cancelarform()"><i class="fa fa-arrow-circle-left"></i><font color=white>Cancelar</font></a></button>
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

                         
                    </div> <!-- /.col -->

                    <div class="panel-body table-responsive" id="listadoregistros">
                          <table id="pedido_data" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                <th width="12%">No. de Pedido</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                          </table>
                    </div>
                    <!--Fin centro -->
                    <!--Fin centro -->
                </div>
              </div>
            </div>
          </section><!-- /.content -->
        </div>
  <!--Fin-Contenido-->
    <!--FORMULARIO VENTANA MODAL-->

  <div id="detallepedidosModal" class="modal fade">
  <div class="modal-dialog">
    <form method="post" id="detallepedidos_form">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Insumo</h4>
        </div>
        
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Insumo</label>
            <input type="text" name="nombreInsumo" id="nombreInsumo" class="form-control" placeholder="Insumo" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$"/>
          </div>

          <div class="form-group col-md-6">
            <label>Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" class="form-control" autocomplete="off" placeholder="Cantidad" required/>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-12">
            <label>Descripción</label>
            <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Breve Descripcion" required pattern="[a-zA-Z_áéíóúñ\s]{0,30}$"/>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Unidad de Medida</label>
            <select class="selectpicker form-control" id="unidadMedida" name="unidadMedida" required>
                  <option value="">-- Seleccione unidad --</option>
                  <option value="kilo">kilo</option>
                  <option value="gramo">gramo</option>
                  <option value="libra">libra</option>
                  <option value="unidad">unidad</option>
                </select>
          </div>

          <div class="form-group col-md-6">
            <label>No. de Pedido</label> 
            <input type="text" name="id_pedido" id="id_pe" class="form-control" readonly="readonly"/>
          </div> 
        </div>

        <div class="modal-footer">
          <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_usuario"];?>" />
          <input type="hidden" name="id_detallepedido" id="id_detallepedido"/>
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

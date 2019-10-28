<?php 
   require_once("../config/conexion.php");
    if(isset($_SESSION["id_usuario"])){
      isset($_GET["id_pedido"]);
?>

<?php
  require_once("header.php");
?>
  <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
             <div id="resultados_ajax"></div>
             <h2>Registro de Pedido</h2>
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                      <h1 class="box-title" ><label id="letra">Pedido</label></h1>
                          <h1 class="box-title">
                            <button class="btn btn-primary btn-lg" id="add_button" onclick="mostrarformulario(true)"   data-target="#pedidoModal"><i class="fa fa-plus" aria-hidden="true"></i> Registrar Pedido</button></h1>
                        <div class="box-tools pull-right"></div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                          <table id="pedido_data" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                <th width="12%">No. Pedido</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                          </table>
                    </div>
                    <!--Fin centro -->
          
                    <div class="panel-body table-responsive" id="pedidoModal" >
                      <form name="formulario" id="pedido_form" method="POST">

                        <div class="form-group table-responsive" style="width: 70%;">
                          <label for="" class="col-lg-3 control-label">Fecha:</label>
                          <div class="col-lg-9">
                            <input type="text" name="fecha" id="fecha" class="form-control" placeholder="Fecha" required style="width:50%;"/>
                          </div>
                        </div> 

                        <div class="form-group table-responsive" style="width: 70%;">
                          <label for="" class="col-lg-3 control-label">No. Pedido:</label>
                            <div class="col-lg-9">
                              <input type="text" name="id_pedido" id="id_pedido" class="form-control"  equired style="width:10%;" readonly="readonly"/>
                            </div> 
                        </div> 
                          
                  <!-- Tabla de insumo -->
                            <div class="form-group table-responsive" style="width: 70%;" id="btnAgregarIns">
                              <button  type="button" class="btn btn-primary" data-toggle="modal"data-target="#detallepedidosModal"><i class="fa fa-plus"></i> Agregar Insumo </button>
                            </div> 

                            <table id="detallepedidos_data" class="table table-bordered table-striped">
                              <thead>
                                  <tr>
                                  <th width="12%">No. de Pedido</th>
                                  <th>Nombre de Insumo</th>
                                  <th>Cantidad</th>
                                  <th>Descripcion</th>
                                  <th>Unidad de Medida</th>
                                  <th>Precio Unitario</th>
                                  <th>Acciones</th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>

                          <button class="btn btn-primary" name ="Guardar" type="submit" id="btnGuardarCap"><i class="fa fa-save"></i> Registrar Pedido</button>

                          <button id="btnCancelar" class="btn btn-danger" type="button" onclick="limpiar()"><i class="fa fa-arrow-circle-left"></i> <a href="pedidos.php"><font color=white>Cancelar</font></a></button>
                          
                          <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_usuario"];?>" />

                        </form> 

                    </div> <!-- /.col -->
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
            <input type="text" name="nombreInsumo" id="nombreInsumo" class="form-control" placeholder="Insumo" required/>
          </div>
          <div class="form-group col-md-6">
            <label>Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" class="form-control" placeholder="Cantidad" required/>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Descripcion</label>
            <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Breve Descripcion" required/>
          </div>
          <div class="form-group col-md-6">
            <label>Unidad de Medida</label>
            <select class="selectpicker form-control" id="unidadMedida" name="unidadMedida" required>
                  <option value="">-- Seleccione unidad --</option>
                  <option value="kilo">kilo</option>
                  <option value="Gramo">gramo</option>
                  <option value="Libra">libra</option>
                </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Precio Unitario</label>
            <input type="number" name="precioUnitario" id="precioUnitario" class="form-control" placeholder="0.00" required/>
          </div>
          <div class="form-group col-md-6">
            <label>No. de Pedido</label> 
            <input type="number" name="id_pedido" id="id_pedido1" class="form-control" value="<?php echo $_GET["id_pedido"];?>" placeholder="No. de Pedido" required/>
          </div> 
        </div>

        <div class="modal-footer">
          <input type="show" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_usuario"];?>" />
          <input type="show" name="id_detallepedido" id="id_detallepedido"/>
          <button type="submit" name="action" id="btnGuardarDet" class="btn btn-success pull-left" value="Add"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
          <button type="button" onclick="limpiardetalle()" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button>
        </div>
      </div>
    </form>
  </div>
</div>
 <!--FIN FORMULARIO VENTANA MODAL-->

<?php
  require_once("footer.php");
?>
<script type="text/javascript" src="js/pedidos.js"></script>

<?php
  } else {
        header("Location:".Conectar::ruta()."vistas/index.php");
  }
?>

<?php
  require_once("../config/conexion.php");
  if(isset($_SESSION["id_usuario"])){ 
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
             <h2>Listado de Pérdidas</h2>
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">
                            <button class="btn btn-primary btn-lg" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#perdidaModal"><i class="fa fa-plus" aria-hidden="true"></i> Nueva Pérdida</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive">
                          <table id="perdida_data" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                  <th>Nombre Producto</th>
                                  <th>Cantidad</th>
                                  <th>Descripción</th>
                                  <th>Precio Producto</th>
                                  <th>Mes</th>
                                  <th>Año</th>
                                  <th>Unidad Producto</th>
                                  <th>Acciones</th>
                                  </tr>
                              </thead>
                            <tbody>
                            </tbody>
                          </table>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box --> 
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
  <!--FORMULARIO VENTANA MODAL-->
  <div id="perdidaModal" class="modal fade">
      <div class="modal-dialog">
         <form method="post" id="perdida_form">
            <div class="modal-content">
               <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                 <h4 class="modal-title">Agregar Pérdida</h4>
               </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Nombre del Producto</label>
              <input type="text" name="nombreProduc" id="nombreProduc" class="form-control" placeholder="Nombre del Producto" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$"/>
            </div>
            <div class="form-group col-md-6">
              <label>Cantidad</label>
              <input type="number" name="cantidad" id="cantidad" class="form-control" placeholder="Cantidad en número" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$"/>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Precio del Producto</label>
              <input type="number" step="any" name="precioProduc" id="precioProduc" class="form-control"placeholder="0.00" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$"/>
            </div>
            <div class="form-group col-md-6">
              <label>Unidad Producto</label>
              <input type="text" name="unidadDelProduc" id="unidadDelProduc" class="form-control" placeholder="Unidad del Producto"required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$"/>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-12">
              <label>Descripción</label>
              <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Breve descripción" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$"/>
            </div>
          </div>
          
          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Mes</label>
              <input type="number" name="mes" id="mes" class="form-control" placeholder="mm"required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$"/>
            </div>
            <div class="form-group col-md-6">
              <label>Año</label>
              <input type="number" name="anio" id="anio" class="form-control" placeholder="AAAA"required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$"/>
            </div>
          </div>
 

              <div class="modal-footer">
                 <input type="hidden" name="id_usuario" id="id_usuario"/>
                 <button type="submit" name="action" id="btnGuardar" class="btn btn-success pull-left" value="Add"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
              <button type="button" onclick="limpiar()" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button>
              </div>
            </div>
         </form>
      </div>
    </div>
<?php
  require_once("footer.php");
?>
<script type="text/javascript" src="js/perdidas.js"></script>
<?php
  } else {
    header("Location:".Conectar::ruta()."vistas/index.php");
  }
?>
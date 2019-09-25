<?php
  require_once("../config/conexion.php");
  if(isset($_SESSION["id_usuario"])){ 
?>

<?php
  require_once("header.php");
  //require_once("../modelos/Donaciones.php");
?>

  <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
             <div id="resultados_ajax"></div>
             <h2>Listado de Donaciones</h2>
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">
                            <button class="btn btn-primary btn-lg" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#donacionModal"><i class="fa fa-plus" aria-hidden="true"></i> Nueva Donación</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive">
                          <table id="donacion_data" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                  <th>Fecha</th>
                                  <th>donante</th>
                                  <th>Descripcion</th>
                                  <th>Cantidad</th>
                                  <th width="10%">Editar</th>
                                  <th width="10%">Eliminar</th>
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
  <div id="donacionModal" class="modal fade">
      <div class="modal-dialog">
         <form method="post" id="donacion_form">
            <div class="modal-content">
               <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                 <h4 class="modal-title">Agregar Donación</h4>
               </div>

          <div class="modal-body">
          <!--- codigo para mostrar calendario jquery IU -->
          <script>
          $( function() {
            $( "#fecha" ).datepicker();
          } );
          </script>
          <!--- fin codigo para mostrar calendario jquery IU -->

          <label>Fecha</label>
          <input type="text" name="fecha" id="fecha" autocomplete="off" class="form-control" placeholder="Fecha" required/>
          <br />

          <label>Donante</label>
          <input type="text" name="donante" id="donante" class="form-control" placeholder="nombre del donante" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$"/>
          <br />

          <label>Descripcion</label>
          <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Breve descripción" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$"/>
          <br />

          <label>Cantidad</label>
          <input type="number" step="any" name="cantidad" id="cantidad" class="form-control" placeholder="cantidad" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$"/>
          <br />
 
               </div>
               <div class="modal-footer">
                  <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_usuario"];?>" />
                  <input type="hidden" name="id_donacion" id="id_donacion"/>
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
<script type="text/javascript" src="js/donaciones.js"></script>
<?php
  } else {
    header("Location:".Conectar::ruta()."vistas/index.php");
  }
?>
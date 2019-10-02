<?php
   require_once("../config/conexion.php");
    if(isset($_SESSION["id_usuario"])){
?>
<?php
$activar = 'item_incidentes';
  require_once("header.php");
?>
  <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
             <div id="resultados_ajax"></div>
             <h2>Listado de Incidentes</h2>
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">
                            <button class="btn btn-primary btn-lg" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#incidenteModal"><i class="fa fa-plus" aria-hidden="true"></i> Registrar Incidente</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive">
                          <table id="incidente_data" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                <th width="5%">Titulo</th>
                                <th width="5%">Descripcion</th>
                                <th width="5%">Fecha</th>
                                <th width="5%">Editar</th>
                                <th width="5%">Eliminar</th>
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
  <div id="incidenteModal" class="modal fade">
  <div class="modal-dialog">
    <form method="post" id="incidente_form">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Incidente</h4>
        </div>
        <div class="modal-body">

          <label>Titulo</label>
          <input type="text" name="titulo" id="titulo" class="form-control" placeholder="Titulo" required/>
          <br />


          <label>Descripcion</label>
          <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Descripcion" required/>
          <br />

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

        </div>
        <div class="modal-footer">
          <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_usuario"];?>" />
           <input type="hidden" name="id_incidente" id="id_incidente"/>
          <button type="submit" name="action" id="btnGuardar" class="btn btn-success pull-left" value="Add"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
          <button type="button" onclick="limpiar()" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button>
        </div>
      </div>
    </form>
  </div>
</div>
 <!--FIN FORMULARIO VENTANA MODAL-->

<?php
  require_once("footer.php");
?>
<script type="text/javascript" src="js/incidentes.js"></script>
<?php
  } else {
        header("Location:".Conectar::ruta()."vistas/index.php");
  }
?>

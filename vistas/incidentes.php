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
        <section class="content-header">
      <h1>
        Administración de Incidentes
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i>Inicio</a></li>
        <li><i class="fa fa-book"></i> Incidentes</li>
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
                            <button class="btn btn-primary btn-lg" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#incidenteModal"><i class="fa fa-plus" aria-hidden="true"></i> Registrar Incidente</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive tabla-top">
                          <table id="incidente_data" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                <th>Titulo</th>
                                <th>Descripcion</th>
                                <th>Fecha</th>
                                <th width="15%">Acciones</th>
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
          <input type="text" maxlength="50" name="titulo" id="titulo" class="form-control" placeholder="Titulo" required/>
          <span class="error_form" id="error_titulo"></span>
          <br />


          <label>Descripción</label>
          <textarea rows="4" maxlength="500" cols="50" name="descripcion" id="descripcion" class="form-control" placeholder="Descripción" required/></textarea>
          <span class="error_form" id="error_descripcion"></span>
          <br />

          <label>Fecha</label>
          <input type="text" name="fecha" id="fecha" autocomplete="off" class="form-control" placeholder="Fecha" required/>
          <span class="error_form" id="error_fecha"></span>
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

<?php
   require_once("../config/conexion.php");
    if(isset($_SESSION["id_usuario"])){
?>
<?php
$activar = 'item_partidas';
  require_once("header.php");
?>
  <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
                <section class="content-header">
      <h1>
        Administración de Partida
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i>Inicio</a></li>
        <li><i class="fa fa-file-text-o"></i> Partidas</li>
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
                            <button class="btn btn-primary btn-lg" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#partidaModal"><i class="fa fa-plus" aria-hidden="true"></i> Registrar partida</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive tabla-top">
                          <table id="partida_data" class="table table-bordered table-striped ">
                            <thead>
                                <tr>
                                <th width="30%">Nombre Partida</th>
                                <th width="25%">Responsable</th>
                                <th width="30%" style="background: white!important; pointer-events: none;">Administrar Cuentas</th>
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
  <div id="partidaModal" class="modal fade">
  <div class="modal-dialog">
    <form method="post" id="partida_form" autocomplete="off">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Partida</h4>
        </div>
        <div class="modal-body">

          <label>Nombre Partida</label>
          <input type="text" name="nombrepartida" id="nombrepartida" class="form-control" placeholder="Nombre Partida" required/>
          <span class="error_form" id="error_nombrepartida"></span>
          <br />

          <label>Responsable</label>
          <input type="text" name="responsable" id="responsable" class="form-control" placeholder="Responsable" required/>
          <span class="error_form" id="error_responsable"></span>
          <br />

        </div>
        <div class="modal-footer">
          <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_usuario"];?>" />
           <input type="hidden" name="id_partida" id="id_partida"/>
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
<script type="text/javascript" src="js/partidas.js"></script>
<?php
  } else {
        header("Location:".Conectar::ruta()."vistas/index.php");
  }
?>

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

<?php
if (empty($_GET['msj'])) {
      echo "";
    }

    elseif ($_GET['msj'] == 1) {
      echo "<div class='alert alert-success' role='alert' style='text-align:center;'>
                  <button type='button' class='close' data-dismiss='alert'>&times;</button>
                  <strong>¡Listo!</strong>  Se ha restaurado el respaldo de la base de datos.
              </div>";
    }
?>

             <div id="resultados_ajax"></div>
             <h2>Restaurar y Respaldar Base de Datos</h2>
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive">
<script>
function Generado() {
alert("El respaldo se ha generado y su descarga se ha iniciado.");
}
</script>
<!--- generar respaldo -->
        <div class="col-md-5">
            <form method="post" action="../modelos/backup/crear_respaldo.php" style="text-align:center;">
              <fieldset>
                <legend>Crear Respaldo</legend>
                <button type="submit" name="Descargar" onclick="Generado()" title="Descargar base de datos" class="btn btn-primary btn-info"> Crear y Descargar Respaldo <span class="glyphicon glyphicon-download-alt"></span>
                </button>
              </fieldset>
            </form>
        </div>
<!---- restaurar respaldo --->
        <div class="col-md-7">
              <form style="text-align:center;" class="form-horizontal"  action="../modelos/backup/importar_respaldo.php" method="POST" name="formulario" enctype="multipart/form-data">
                    <fieldset>
                  <!-- Form Name -->
                    <legend>Restaurar Respaldo</legend>
                          <!-- File Button -->
                            <div class="form-group">
                              <label class="col-md-4 control-label" for="filebutton">Seleccionar Archivo</label>
                                <div class="col-md-6">
                                  <input type="file" name="archivo"  class="form-control" accept=".sql" required>
                                      </div>
                                      <div class="col-md-2">
    <button type="submit" title="Restaurar Respaldo" id="submit" name="Import" class="btn btn-sm btn-primary button-loading" data-loading-text="Cargando...">Importar <i class="fa fa-upload" aria-hidden="true"></i></button>
                                      </div>
                                  </div>
                              </fieldset>
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

<?php
  require_once("footer.php");
?>
<?php
  } else {
        header("Location:".Conectar::ruta()."vistas/index.php");
  }
?>

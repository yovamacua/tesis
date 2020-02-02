<?php
  #metodo conexion
   require_once("../config/conexion.php");
  #valida si la session existe
  if(isset($_SESSION["id_usuario"])){
  #amostrar como item activo
  $activar = 'item_respaldo';
  #incluir el header
  require_once("header.php");
  #mensaje al restaurar respaldo

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
<?php if($_SESSION["RESPALDO"]==1)
     {

     ?>
<!-- Script para confirmar generado del backup -->
<script>
function Generado() {
  bootbox.alert("El respaldo se ha generado y su descarga se ha iniciado.");
}              
</script>
    <!--Contenido-->
    <div class="content-wrapper">
      <section class="content-header">
      <h1>
      Restaurar y Respaldar Base de Datos
      </h1>
        <ol class="breadcrumb">
          <li><a href="home.php"><i class="fa fa-home"></i>Inicio</a></li>
          <li><i class="fa fa-database"></i> Respaldo</li>
        </ol>
      </section>

      <!-- Contenido principal -->

      <section class="content">
        <div id="resultados_ajax"></div>
        <div class="row">
          <div class="col-md-12">
            <div class="box">

              <!-- centro -->

              <div class="panel-body table-responsive">

                <!--- generar respaldo -->

                <div class="col-md-5">
                  <form method="post" action="../modelos/backup/crear_respaldo.php" style="text-align:center;">
                    <fieldset>

                      <legend>Crear Respaldo</legend>

                      <button type="submit" name="Descargar" onclick="Generado()" title="Descargar base de datos" class="btn btn-primary btn-info"> Crear y Descargar Respaldo <span class="glyphicon glyphicon-download-alt" download></span></button>
                      
                      <div style="text-align: left;">
                        &nbsp;<br>
                        <ul>
                          <li>Click sobre el boton "Crear y Descargar Respaldo"</li>
                          <li>Se Generara y descargara un archivo con extensión .sql
                            <ul>
                              <li>El archivo contiene todas las tablas y información generada y almacenada por el sistema.</li>
                            </ul>
                          </li>
                          <li>Guardar archivo en un lugar seguro y <b>generar un respaldo periodicamente</b></li>
                        </ul>
                      </div>

                    </fieldset>
                  </form>
                </div>

                <!---- restaurar respaldo --->

                <div class="col-md-7">
                  
                  <form style="text-align:center;" class="form-horizontal" action="../modelos/backup/importar_respaldo.php" method="POST" name="formulario" enctype="multipart/form-data">
                    <fieldset>
                      <legend>Restaurar Respaldo</legend>

                      <!-- Subir Respalo -->

                      <div class="form-group iconfix">
                        <div class="col-md-3"></div>
                        <div class="col-md-4">
                          
                          <input type="file" name="archivo" class="form-control upbd" accept=".sql" required>

                        </div>
                        <div class="col-md-3">
                          
                          <button type="submit" title="Restaurar Respaldo" id="submit" name="Import" class="btn btn-sm btn-primary button-loading" data-loading-text="Cargando...">Importar <i class="fa fa-upload" aria-hidden="true"></i></button>

                        </div>
                        <div class="col-md-3"></div>
                      </div>
                    </fieldset>
                  </form>

                  <div style="text-align: left;">
                    <ul>
                      <li>Seleccionar archivo de respaldo, realizado previamente con la opcion del lado izquierdo.</li>
                      <li>Click Sobre boton importar.</li>
                      <li>Esperar a que el archivo se cargue y procese.</li>
                      <li>Al finalizar el proceso, se restaurara la información que halla sido borrada y se encuentre almacenada en el archivo de respaldo</li>
                    </ul>
                  </div>
                </div>
              </div>

              <!--Fin centro -->

            </div>
          </div>
        </div>
      </section>
    </div>

    <!--Fin-Contenido-->
  <?php  } else {

       require("noacceso.php");
  }
   
  ?><!--CIERRE DE SESSION DE PERMISO -->
    <?php
    #incluir el footer
  require_once("footer.php");
?>
      <?php
  } else {
    #redirecciona si la session no existe
        header("Location:".Conectar::ruta()."vistas/index.php");
  }
?>
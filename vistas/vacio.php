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
             <h2></h2>
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


<!---- CONTENIDO --->

                    </div>
                    <!--Fin centro -->
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

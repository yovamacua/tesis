<?php
   require_once("../config/conexion.php");
    if(isset($_SESSION["id_usuario"])){
      //validar que no viene vacio o redirecciona
      if (isset($_GET['id'])) {
       $identificador = $_GET['id'];
     }else{
       $redireccion = Conectar::ruta()."vistas/cuenta.php";?>
      <script type="text/javascript">
       alert("Debe seleccionar una cuenta primero")
       self.location = '<?php echo $redireccion; ?>'
       </script>
       <?php
     }
?>
<?php
  require_once("header.php");
?>
  <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
             <h2>Administrar Cuenta</h2>
            <div class="row">
              <div class="col-md-12">
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive">
                      Contenido proximamente
                    </div>
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->

<?php
  require_once("footer.php");
?>

<script type="text/javascript" src="js/cuentas.js"></script>
<?php
  } else {
        header("Location:".Conectar::ruta()."vistas/index.php");
  }
?>

<!-- Script para no mostrar directorios, redirecciona automaticamente a login-->
<?php
  require_once("../../config/conexion.php");
$redireccion = Conectar::ruta()."vistas";?>
      <script type="text/javascript">
       self.location = '<?php echo $redireccion; ?>'
       </script>
?>

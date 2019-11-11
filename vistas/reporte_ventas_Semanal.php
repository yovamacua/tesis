<?php

   require_once("../config/conexion.php");

    if(isset($_SESSION["id_usuario"])){

      require_once("../modelos/Categorias.php");
         $categoria = new Categorias();

       $cat = $categoria->get_categoria();

?>


<!-- INICIO DEL HEADER - LIBRERIAS -->
<?php require_once("header.php");?>

<!-- FIN DEL HEADER - LIBRERIAS -->


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">


   <div >
   <H2 class="reporte_compras_general container-fluid bg-red text-white col-lg-12 text-center mh-50">
        
           REPORTE DE VENTAS  SEMANAL
  </div>
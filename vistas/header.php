<?php
  #incluye la conexion
   require_once("../config/conexion.php");
   #verifica que exista sessión
   if(isset($_SESSION["id_usuario"])){
   ?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title> Sistema de Campo Escuela | Universidad de Sonsonate</title>
      <!-- Tell the browser to be responsive to screen width -->
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
          <!-- favicon -->
    <link rel="shortcut icon" href="../public/images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="../public/images/favicon.ico" type="image/x-icon">
      <!-- Bootstrap 3.3.7 -->
      <link rel="stylesheet" href="../public/bower_components/bootstrap/dist/css/bootstrap.min.css">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="../public/bower_components/font-awesome/css/font-awesome.min.css">
      <!-- Ionicons -->
      <link rel="stylesheet" href="../public/bower_components/Ionicons/css/ionicons.min.css">
      <!-- Tesis style proyect -->
      <link rel="stylesheet" href="../public/css/tesis.css">
      <!-- library hint for cool tooltips -->
      <link rel="stylesheet" href="../public/css/hint.css">
      <link rel="stylesheet" href="../public/datatables/jquery.dataTables.min.css">
      <link href="../public/datatables/buttons.dataTables.min.css" rel="stylesheet"/>
      <link href="../public/datatables/responsive.dataTables.min.css" rel="stylesheet"/>
      <!-- Theme style -->
      <link rel="stylesheet" href="../public/dist/css/AdminLTE.min.css">
      <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
      <link rel="stylesheet" href="../public/dist/css/skins/_all-skins.min.css">
      <!-- Morris chart -->
      <link rel="stylesheet" href="../public/bower_components/morris.js/morris.css">
      <!-- jvectormap -->
      <link rel="stylesheet" href="../public/bower_components/jvectormap/jquery-jvectormap.css">
      <!-- Date Picker -->
      <link rel="stylesheet" href="../public/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
      <!-- Daterange picker -->
      <link rel="stylesheet" href="../public/bower_components/bootstrap-daterangepicker/daterangepicker.css">
      <!-- bootstrap wysihtml5 - text editor -->
      <link rel="stylesheet" href="../public/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
      <!-- Google Font -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
      <!-- jQuery 3 -->
      <script src="../public/bower_components/jquery/dist/jquery.min.js"></script>
      <!-- jQuery UI 1.11.4 -->
      <script src="../public/bower_components/jquery-ui/jquery-ui.min.js"></script>
   </head>
   <body class="hold-transition skin-blue sidebar-mini">
      <div class="loader"></div>
      <script type="text/javascript">
         $(document).ready(function()  {
             $(".loader").fadeOut("slow");
         });
         
         function saliendo(){
              bootbox.confirm("¿Está Seguro de salir del sistema?", function(result){
            if(result)
            {
             location = 'logout.php';
            }
           });
         }
         
      </script>

<script type="text/javascript">
         function desvanecer() {
            window.setTimeout(function () {
         $(".alert").fadeTo(2000, 0).slideUp(2000, function () {
         });
         }, 10000);
      } 
</script>
<style type="text/css">
   
</style>
      <div class="wrapper">
      <header class="main-header">
         <!-- Logo -->
         <a href="inicio.php" class="logo">
            <!-- Mini logo -->
            <span class="logo-mini"><b>C.E</b></span>

            <span class="logo-lg"><b>Campo Escuela</b></span>
         </a>

         <nav class="navbar navbar-static-top">
            <!-- botton colapsar menu-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
               <ul class="nav navbar-nav">
                  <!-- Informacion de usuario -->
                  <?php $imagen = $_SESSION["imagen"]; ?>
                  <li class="dropdown user user-menu">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                       
                        <img src="upload/<?php echo $imagen; ?>" class="img-thumbnail" width="20" style="background-color: transparent!important; padding: 0px!important; "/>&nbsp;
                        <span class="hidden-xs"><?php echo $_SESSION["usuario"]?></span>
                     </a>
                     <ul class="dropdown-menu">
                        <!-- Imagen usuario -->
                        <li class="user-header">
                           <p><i class="fa fa-user" aria-hidden="true"></i>
                              <?php echo $_SESSION["nombre"]; ?><br>
                              <img src="upload/<?php echo $imagen; ?>" class="img-thumbnail" width="80"/>
                              <!-- <small>Administrador desde Noviembre 2017</small> -->
                           </p>
                        </li>
                        <li class="user-footer">
                           <div class="pull-left">
                              <a href="mi_perfil.php" class="btn btn-default btn-flat">Perfil</a>
                           </div>
                           <div class="pull-right">
                              <a href="#" onclick="saliendo();" class="btn btn-default btn-flat">Cerrar</a>
                           </div>
                        </li>
                     </ul>
                  </li>
               </ul>
            </div>
         </nav>
      </header>
      <div id="resultados_ajax" class="text-center testp"></div>
      <?php 
      #incluyendo el sidebar
      require_once("sidebar-menu.php");?>

      <script src="../public/bower_components/jquery/dist/jquery.min.js"></script>
      <?php
         } else {
          #redireccion si la sessión no existe
            header("Location:".Conectar::ruta()."vistas/index.php");
            exit();
          }


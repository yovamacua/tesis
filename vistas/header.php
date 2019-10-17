 <?php
    require_once("../config/conexion.php");
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
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="home.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>C.E</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Campo Escuela</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">

             <!-- <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">-->
              <i class="fa fa-user" aria-hidden="true"></i>
              <span class="hidden-xs"><?php echo $_SESSION["nombre"]?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <!--<img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">-->
                 <i class="fa fa-user" aria-hidden="true"></i>

                <p>
                   <?php echo $_SESSION["nombre"]?>
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

<div id="resultados_ajax" class="text-center"></div>

  <?php require_once("sidebar-menu.php");?>


   <!--FIN FORMULARIO PERFIL USUARIO MODAL-->
  <script src="../public/bower_components/jquery/dist/jquery.min.js"></script>

  <?php
       } else {
          header("Location:".Conectar::ruta()."vistas/index.php");
          exit();
       }
    ?>

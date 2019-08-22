
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Sistema Campo Escuela | Univesidad de Sonsonate 2019</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../public/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../public/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../public/bower_components/Ionicons/css/ionicons.min.css">

  <!-- DataTables -->

  <!--<link rel="stylesheet" href="../public/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">-->

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
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Compra - Venta</b></span>
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
              <span class="hidden-xs">Eyter Higuera</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <!--<img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">-->

                 <i class="fa fa-user" aria-hidden="true"></i>

                <p>
                  Eyter Higuera - Web Developer
                  <small>Administrador desde Noviembre 2017</small>
                </p>
              </li>
              <!-- Menu Body -->
              <!--<li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>-->
                <!-- /.row -->
              <!--</li>-->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Perfil</a>
                </div>
                <div class="pull-right">
                  <a href="#" class="btn btn-default btn-flat">Cerrar</a>
                </div>
              </li>
            </ul>
          </li>

        </ul>
      </div>
    </nav>
  </header>

  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU</li>
        <li class="">
          <a href="index.php">
            <i class="fa fa-home" aria-hidden="true"></i> <span>Inicio</span>
          </a>

        </li>

         <li class="">
          <a href="categorias.php">
            <i class="fa fa-list" aria-hidden="true"></i> <span>Categoría</span>
            <span class="pull-right-container badge bg-blue">
              <i class="fa fa-bell pull-right">20</i>
            </span>
          </a>

        </li>

        <li class="">
          <a href="presentacion.php">
            <i class="fa fa-shopping-basket" aria-hidden="true"></i> <span>Presentación</span>
            <span class="pull-right-container badge bg-blue">
              <i class="fa fa-bell pull-right">20</i>
            </span>
          </a>

        </li>


         <li class="">
          <a href="productos.php">
            <i class="fa fa-tasks" aria-hidden="true"></i> <span>Productos</span>
            <span class="pull-right-container badge bg-blue">
              <i class="fa fa-bell pull-right">20</i>
            </span>
          </a>

        </li>

         <li class="">
              <a href="proveedores.php">
                <i class="fa fa-users"></i> <span>Proveedores</span>
                <span class="pull-right-container badge bg-blue">
                  <i class="fa fa-bell pull-right">5</i>
                </span>
              </a>

          </li>

           <li class="">
          <a href="compras.php">
            <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Compras</span>
            <span class="pull-right-container badge bg-blue">
              <i class="fa fa-bell pull-right">10</i>
            </span>
          </a>

        </li>

           <li class="">
          <a href="clientes.php">
            <i class="fa fa-users"></i> <span>Clientes</span>
            <span class="pull-right-container badge bg-blue">
              <i class="fa fa-bell pull-right">3</i>
            </span>
          </a>

        </li>

         <li class="">
          <a href="ventas.php">
            <i class="fa fa-suitcase" aria-hidden="true"></i> <span>Ventas</span>
            <span class="pull-right-container badge bg-blue">
              <i class="fa fa-bell pull-right">8</i>
            </span>
          </a>

        </li>

        <li class="">
          <a href="ventas.php">
            <i class="fa fa-print" aria-hidden="true"></i> <span>Reportes</span>
            <span class="pull-right-container badge bg-blue">
              <i class="fa fa-bell pull-right">8</i>
            </span>
          </a>

        </li>


        <li class="">
          <a href="usuarios.php">
            <i class="fa fa-user" aria-hidden="true"></i> <span>Usuarios</span>
            <span class="pull-right-container badge bg-blue">
              <i class="fa fa-bell pull-right">3</i>
            </span>
          </a>

        </li>

         <li class="">
          <a href="backup.php">
            <i class="fa fa-database" aria-hidden="true"></i> <span>BackUp</span>
            <span class="pull-right-container badge bg-blue">
              <i class="fa fa-bell pull-right">3</i>
            </span>
          </a>

        </li>



      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

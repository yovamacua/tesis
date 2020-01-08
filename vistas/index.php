<?php
  //conexion a la base de datos
   require_once("../config/conexion.php");
   //si se preciona el boton y el valor es "si" se busca validar los datos
   if(isset($_POST["enviar"]) and $_POST["enviar"]=="si"){
     //se instancia la clase usuario
     require_once("../modelos/Usuarios.php");
     //nuevo objeto de tipo usuarios
     $usuario = new Usuarios();
     //se invoca la function 
     $usuario->login();
 }

if(isset($_SESSION["id_usuario"]))
{
   header("Location:".Conectar::ruta()."vistas/home.php");
}
else{
// muestra si la session no existe
 ?>
  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Acceso</title>
    <!-- Indicar al navegador que responda al ancho de la pantalla -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- favicon -->
    <link rel="shortcut icon" href="../public/images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="../public/images/favicon.ico" type="image/x-icon">
    <!-- Libreria Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="../public/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Libreria Font Awesome -->
    <link rel="stylesheet" href="../public/bower_components/font-awesome/css/font-awesome.min.css">
    
    <!-- Theme style -->
    <link rel="stylesheet" href="../public/dist/css/AdminLTE.min.css">

    <!-- estilos adicionales para el formulario -->
    <style>
      .login-logo{
               margin-bottom: 0px!important;
               margin-top: -20px!important;
         }
         .login-box-body{
               background: -moz-linear-gradient(top, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.4) 100%);
               background: -webkit-linear-gradient(top, rgba(255,255,255,1) 0%,rgba(255,255,255,0.4) 100%);
               background: linear-gradient(to bottom, rgba(255,255,255,1) 0%,rgba(255,255,255,0.4) 100%);
               filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#00ffffff',GradientType=0 );
               -webkit-box-shadow: 0px 0px 34px -4px rgba(0,0,0,0.75);
      -moz-box-shadow: 0px 0px 34px -4px rgba(0,0,0,0.75);
      box-shadow: 0px 0px 34px -4px rgba(0,0,0,0.75);
         }
          .login-box{margin: auto!important;
          padding-top: 12rem!important;}
      
    </style>

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  </head>
  <body class="login-page bg-login">
    <div class="login-box">
      <!-- /.login-logo -->
      <div class="login-box-body">
        <!--INICIO MENSAJES DE ALERTA-->
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <div class="box-body">
                <?php
             if(isset($_GET["m"])) {
            switch($_GET["m"]){
                case "1";
                ?>
                <!-- Mensaje de aletar datos incorrectos -->
                  <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> El correo y/o password es incorrecto o no tienes permiso!</h4>
                  </div>
                  <?php
                 break;
                 case "2";
                 ?>
                <!-- Mensaje de alerta datos campos vacios -->
                    <div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <h4><i class="icon fa fa-ban"></i> Los campos estan vacios</h4>
                    </div>
                    <?php
                 break;
              }
          }
        ?>
                      <div class="login-logo">
                        <b style="color:black;">Campo Escuela</b>
                      </div>
              </div>
            </div>
          </div>
        </div>
        <!--/container-fluid-->
        <!-- FIN MENSAJES DE ALERTA-->
        <!--Formulario login-->

        <p class="text-center pad text-bold bg-primary margin-bottom"><i class="fa fa-user-circle-o icon-title"></i> Ingrese sus datos</p>

        <form action="" method="post" autocomplete="off">
          <div class="input-group">
               
                <input type="text" name="correo" id="correo" class="form-control" placeholder="Usuario ó Email" required="required" autofocus="auto" autocomplete="off">
                 <span class="input-group-addon"><i class="fa fa-user"></i></span>
              </div>
          <br>

        <div class="input-group">
          
          
   <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña" required="required" autocomplete="off">
   <span class="input-group-addon element1" id="try"><i class="fa fa-lock" id="show"></i></span>
              </div>

          <div class="form-group">
            <input type="hidden" name="enviar" class="form-control" value="si">
          </div>

          <div class="row">
            <div class="col-xs-7 col-xs-offset-3 col-sm-8 col-sm-offset-2 col-lg-8 col-lg-offset-2">
              <button type="submit" class="btn btn-primary bg-primary btn-block btn-flat"><i class="fa fa-sign-in" aria-hidden="true"></i>  Iniciar Sesión</button>
            </div>
            <div class="form-group" style="float: right; margin: 13px 15px 0px 0px;">
              <a data-toggle="modal" data-target="#modal-default" href="#" style="color:#5e99bb; font-size: 1.5rem;">No tengo acceso.</a>
          <!-- /.modal-content -->
              <div class="modal fade" id="modal-default" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Información</h4>
              </div>
              <div class="modal-body">
                <p>Para recuperar el acceso o solicitar una cuenta, por favor contacte al administrador.</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Aceptar</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
            </div>
          </div>
        </form>

      </div>
      <!-- Fin Formulario login -->
    </div>
    <!-- jQuery 3 -->
    <script src="../public/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="../public/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../vistas/js/login.js"></script>
  </body>
  </html>
  <?php
}
?>
<?php
  //conexion a la base de datos
   require_once("../config/conexion.php");
   //si se preciona el boton y el valor es si
   if(isset($_POST["enviar"]) and $_POST["enviar"]=="si"){
     //se instancia la clase
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
   <!-- Tell the browser to be responsive to screen width -->
   <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
   <!-- Bootstrap 3.3.7 -->
   <link rel="stylesheet" href="../public/bower_components/bootstrap/dist/css/bootstrap.min.css">
   <!-- Font Awesome -->
   <link rel="stylesheet" href="../public/bower_components/font-awesome/css/font-awesome.min.css">
 <!-- Theme style -->
   <link rel="stylesheet" href="../public/dist/css/AdminLTE.min.css">
   <!-- iCheck -->


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
   <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
   <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
   <!--[if lt IE 9]>
   <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
   <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
   <![endif]-->

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

                <div class="alert alert-danger alert-dismissible">
                       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                       <h4><i class="icon fa fa-ban"></i> El correo y/o password es incorrecto o no tienes permiso!</h4>

                 </div>

                 <?php
                 break;


                 case "2";
                 ?>
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
               <b style="color:black;">Acceso</b>
             </div>
         </div>


         </div>
       </div>
   </div>
   <!-- Javascript -->
   <script src="../assets/js/jquery-1.8.2.min.js"></script>
   <script src="../assets/js/scripts.js"></script>
   <!--/container-fluid-->
 <!-- FIN MENSAJES DE ALERTA-->

 <!--login-box-msg-->

     <p class="text-center pad text-bold bg-primary margin-bottom"><i class="fa fa-user icon-title"></i> Ingrese sus datos</p>

     <form action="" method="post" autocomplete="off">
       <div class="form-group has-feedback">
         <input type="text" name="correo" id="correo" class="form-control" placeholder="Usuario ó Email" required="required" autofocus="auto" autocomplete="off">
         <span class="glyphicon glyphicon-user form-control-feedback"></span>
         <span class="error_form" id="error_correo"></span>
       </div>
       <div class="form-group has-feedback">
         <input type="password" name="password" id="password" class="form-control" placeholder="Password" required="required" autocomplete="off">
         <span class="glyphicon glyphicon-lock form-control-feedback"></span>
         <span class="error_form" id="error_password"></span>
       </div>

        <div class="form-group">
         <input type="hidden" name="enviar" class="form-control" value="si">
       </div>

       <div class="row">

         <div class="col-xs-7 col-xs-offset-3 col-sm-8 col-sm-offset-2 col-lg-8 col-lg-offset-2">
           <button type="submit" class="btn btn-primary bg-primary btn-block btn-flat"><i class="fa fa-power-off" aria-hidden="true"></i>  Iniciar Sesión</button>
         </div>
         <!-- /.col --> 
         <div class="form-group" style="float: right; margin: 13px 15px 0px 0px;">
         <a href="#" style="color:#5e99bb; font-size: 1.5rem;">¿No puede acceder?</a>
       </div>
       </div>
     </form>

<script type="text/javascript">
  
$(function() {
   //creando variables y ocultando campos de error
         $("#error_correo").hide();
         $("#error_password").hide();
                
   // se ejecuta funcion en el id del control cuando se pierde el foco
         $("#correo").focusout(function(){
            campo_correo();
         });

         $("#password").focusout(function(){
            campo_password();
         });
       
       function campo_correo() {
            var correo = $("#correo").val().length;
            if (correo <= 0) {
               $("#error_correo").html("Debe completar este campo");
               $("#error_correo").show();
               $("#correo").css("border-bottom","2px solid #F90A0A");
               $("#error_correo").css("color","red");
            } else {
               $("#error_correo").hide();
               $("#correo").css("border-bottom","1px solid #d2d6de");
            }
         }

       function campo_password() {
            var password = $("#password").val().length;
            if (password <= 0) {
               $("#error_password").html("Debe completar este campo");
               $("#error_password").show();
               $("#password").css("border-bottom","2px solid #F90A0A");
               $("#error_password").css("color","red");
            } else {
               $("#error_password").hide();
               $("#password").css("border-bottom","1px solid #d2d6de");
            }
         }        
 });



</script>

   </div>
   <!-- /.login-box-body -->

 </div>
 <!-- /.login-box -->
 <!-- jQuery 3 -->
 <script src="../public/bower_components/jquery/dist/jquery.min.js"></script>
 <!-- Bootstrap 3.3.7 -->
 <script src="../public/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
 </body>
 </html>
<?php
}
?>
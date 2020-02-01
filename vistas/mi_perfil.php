<?php
  #incluyendo conexion
  require_once("../config/conexion.php");
  #verificando que sessión exista
   if(isset($_SESSION["id_usuario"])){
  #incluyendo modelo de perfil
   require_once("../modelos/Perfil.php");
   #creando nuevo objeto
   $Perfil=new Perfil();
   #incluyendo header
   require_once("header.php");
  ?>

<!-- Scripts -->

<script type="text/javascript" src="js/perfil.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
  setTimeout(function() { $(".alert-success").fadeOut(2000); },10000);
  });
</script>

<!--Contenido-->

<?php
  # mensajes lanzados segun acción
  if(isset($_GET["m"])) {
            switch($_GET["m"]){
                case "1";
                ?>
  <div id="resultados_ajax" class="text-center testp">
    <div class="alert alert-success" role="alert">
      <button type="button" class="close" data-dismiss="alert">×</button>
      Se ha actualizado la información
    </div>
  </div>
<?php
  break;
  case "2";
  ?>
  <div id="resultados_ajax" class="text-center testp">
    <div class="alert alert-success" role="alert">
      <button type="button" class="close" data-dismiss="alert">×</button>
      Se ha eliminado la imagen de usuario
    </div>
</div>
<?php
  break;
    }
  }
  ?>
<div class="content-wrapper">
<section class="content-header">
  
  <h1>Mi Perfil</h1>

  <!-- migas de pan  -->
  <ol class="breadcrumb">
    <li><a href="home.php"><i class="fa fa-home"></i>Inicio</a></li>
    <li><i class="fa fa-user"></i> Mi Perfil</li>
  </ol>

</section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
          <i class="fa fa-user"></i>

          <h3 class="box-title">Administrar Perfil</h3>
        <!-- <?php //var_dump($_SESSION["ultimoAcceso"]); ?> -->
        </div>
        <div class="panel-body table-responsive">
         
          <?php 
            //si existe el envia del post entonces se llama al metodo
            $datos= $Perfil->get_usuario_por_id($_SESSION['id_usuario']);
              for($i=0;$i<count($datos);$i++){
                #impresion de las información de los usuarios
               ?>   

          <div class="form-group col-md-6">
            <dl class="dl-horizontal">
              <dt>Nombre(s):</dt>
              <dd><?php echo $datos[$i]["nombres"]?></dd>
              <dt>Apellido(s):</dt>
              <dd><?php echo $datos[$i]["apellidos"]?></dd>
              <dt>Usuario:</dt>
              <dd><?php echo $datos[$i]["usuario"]?></dd>
              <dt>Correo:</dt>
              <dd><?php echo $datos[$i]["correo"]?></dd>
              <dt>Cargo:</dt>
              <dd><?php echo $datos[$i]["nombre"]?></dd>
              <dt>Fecha de registro:</dt>
              <dd><?php echo $datos[$i]["fecha_ingreso"]?></dd>
            </dl>
             
            <?php
              }//cierre del for                                              
              ?>
            <div style="text-align: center;">

              <a href="#" class="btn btn-primary btn-flat" onclick="mostrar_perfil('<?php echo $_SESSION["id_usuario"]?>')"  data-toggle="modal" data-target="#perfilModal">Editar Perfil</a>&nbsp;

              <a href="#" class="btn btn-primary btn-flat" onclick="editar_pass('<?php echo $_SESSION["id_usuario"]?>')"  data-toggle="modal" data-target="#perfilModal">Cambiar Contraseña</a>

            </div>
          </div>
          <div class="form-group col-md-6" style="text-align: center;">
            <?php $imagen = $_SESSION["imagen"]; ?>
            
        <img src="upload/<?php echo $imagen; ?>" class="img-thumbnail" width="200"/>
            <br><br>
            
            <?php 
              if ($imagen == "imagen_usuario_general.png") {              
              }else{ ?>
            
            <a href="#" class="btn btn-danger btn-flat" onclick="quitar_imagen('<?php echo $_SESSION["id_usuario"]?>')" >Eliminar Imagen</a>
            <?php }?>

          </div>
        </div>
      </div>
    </div>
</section>
</div>
<!--Fin-Contenido-->
<!--- ventana modal --->
<div id="perfilModal" class="modal fade">
  <div class="modal-dialog">
<!--- Formulario modal --->
    <form action="mi_perfil.php" autocomplete="off" method="post" id="perfil_form">
      
      <div class="modal-content">
        <div class="modal-header">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Editar Perfil</h4>
        </div>
        <div class="form-row ofield2" style="margin-top: 1.2rem!important;">
          <div class="form-group col-md-6">
            
            <label clas>Nombres*</label>
            <input type="text" class="form-control" id="nombre_perfil" name="nombre_perfil" maxlength="50" placeholder="Nombres" required>
            <span class="error_form" id="error_nombre_perfil"></span>

          </div>
          <div class="form-group col-md-6">
            
            <label>Apellidos*</label>
            <input type="text" class="form-control" id="apellido_perfil" name="apellido_perfil" placeholder="Apellidos" maxlength="50" required >
            <span class="error_form" id="error_apellido_perfil"></span>

          </div>
        </div>
        <div class="form-row ofield2">
          <div class="form-group col-md-6">
            
            <label clas>Usuario*</label>
            <input type="text" class="form-control" maxlength="50" id="usuario_perfil" name="usuario_perfil" placeholder="Nombres" required >
            <span class="error_form" id="error_usuario_perfil"></span>

          </div>
          <div class="form-group col-md-6">
            
            <label>Correo*</label>
            <input type="email" class="form-control" id="email_perfil" name="email_perfil" maxlength="100" placeholder="Correo" required="required">
            <span class="error_form" id="error_email_perfil"></span>

          </div>
        </div>
        <div class="form-row ofield">
          <div class="form-group col-md-6">
           
            <label clas>Password*</label>
            <input type="password" class="form-control" id="password1_perfil" name="password1_perfil" maxlength="20" placeholder="Password" required>
            <span class="error_form" id="error_password1_perfil"></span>

          </div>
          <div class="form-group col-md-6">
            
            <label>Repita Password*</label>
            <input type="password" class="form-control" id="password2_perfil" maxlength="20" name="password2_perfil" placeholder="Repita Password" required>
            <span class="error_form" id="error_password2_perfil"></span>

          </div>
        </div>
        <div class="form-row ofield2 iconfix" style="text-align: center;">
          <div class="form-group col-md-6"><label>Imagen de perfil</label>
            
            <input type="file" accept="image/*" id="usuario_imagen" onchange="validarImagen(this);"  name="usuario_imagen"><br>

          </div>
          <div class="form-group col-md-6">
            <span id="upload_usuario_imagen"></span>
          </div>
        </div>
        <div class="col-lg-12">
          
          <div><span class="ofield2">- Los campos con * (asterisco) son obligatorios<br>-Formatos de imagen validos: jpg y png menor a 1 MB</span>
            <span class="ofield">- La contraseña debe tener entre 6 caracteres y maximo 15 entre letras y números<br><br></span>
          </div>

        </div>
        <div style="clear: both;"></div>
        
        <div class="modal-footer" style="border-top: none!important;">
         
          <input type="hidden" name="id_usuario_perfil" id="id_usuario_perfil"/>
          
          <button type="submit" name="action" id="" class="btn btn-success pull-left" value="Add"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar </button>

          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button>

        </div>
      </div>
    </form>
  </div>
</div>
<?php
  # incluyendo footer
  require_once("footer.php");
  ?>
<script type="text/javascript" src="js/perfil.js"></script>
<?php
  } else {
    #redirrecion si sessión no existe
        header("Location:".Conectar::ruta()."vistas/index.php");
  }
  ?>
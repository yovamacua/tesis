<?php
   require_once("../config/conexion.php");
      if(isset($_SESSION["id_usuario"])){
?>

<?php
//crear esta variable para indicar si esta activo o no el item
$activar = 'item_usuarios';
require_once("header.php");
?>

  <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <section class="content-header">
      <h1>
        Administración de Usuarios
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i>Inicio</a></li>
        <li><i class="fa fa-users"></i>Usuarios</li>
      </ol>
    </section>
        <!-- Main content -->
        <section class="content">
             <div id="resultados_ajax"></div>
                  <div class="box">
                    <div class="box-header boton-top">
                          <h1 class="box-title">
                            <button class="btn btn-primary btn-lg" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#usuarioModal"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo Usuario</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive tabla-top">
                          <table id="usuario_data" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                  <th>Nombres</th>
                                  <th>Apellidos</th>
                                  <th>Usuario</th>
                                  <th>Correo</th>
                                  <th>Cargo</th>

                                  <th>Fecha Registro</th>
                                  <th>Acciones</th>
                                  </tr>
                              </thead>
                            <tbody>
                            </tbody>
                          </table>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
      </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
  <!--FORMULARIO VENTANA MODAL-->
  <div id="usuarioModal" class="modal fade">
      <div class="modal-dialog">
         <form method="post" id="usuario_form" autocomplete="off">
            <div class="modal-content">
               <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                 <h4 class="modal-title">Agregar Usuario</h4>
               </div>
           <div class="form-row ofield" style="margin-top: 1.2rem!important;">
             <div class="form-group col-md-6">
<label>Nombres*</label>
<input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombres" maxlength="50" required="" autofocus="autofocus" />
<span class="error_form" id="error_nombre"></span>
              </div>

              <div class="form-group col-md-6">
<label>Apellidos*</label>
<input type="text" name="apellido" id="apellido" class="form-control" placeholder="Apellidos" maxlength="50"  required=""/>
<span class="error_form" id="error_apellido"></span>
               </div>
             </div>

             <div class="form-row  ofield">
               <div class="form-group col-md-6">
<label>Usuario*</label>
<input type="text"  name="usuario" id="usuario" class="form-control" placeholder="Usuario" maxlength="50" required=""/>
<span class="error_form" id="error_usuario"></span>
                  </div>


                <div class="form-group col-md-6">
<label>Cargo*</label>
   <select class="form-control" id="cargo" name="cargo">
      <option value="">-- Selecciona cargo --</option>
      <option value="1">Administrador</option>
      <option value="0">Empleado</option>
      </select>
      <span class="error_form" id="error_cargo"></span>
                </div>
               </div>

               <div class="form-row  ofield">
                 <div class="form-group col-md-6">
<label>Correo*</label>
<input type="email" name="email" id="email" class="form-control" placeholder="Correo" maxlength="100" required=""/>
<span class="error_form" id="error_email"></span>
                  </div>

                                   <div class="form-group col-md-6">
                      <label>Estado*</label>
<select class="form-control" id="estado" name="estado" required="">
    <option value="">-- Selecciona estado --</option>
    <option value="1" selected>Activo</option>
    <option value="0">Inactivo</option>
</select>
<span class="error_form" id="error_estado"></span>
                  </div>
                 </div>

               <div class="form-row ofield2">
                 <div class="form-group col-md-6">
<label>Password*</label>
<input  type="password" name="password1" id="password1" class="form-control" placeholder="Password" required="" maxlength="20"/>
<span class="error_form" id="error_password1" ></span>
                  </div>
                  
                  <div class="form-group col-md-6">
<label>Repita Password* </label>
<input type="password" name="password2" id="password2" class="form-control" placeholder="Repita Password" required="" maxlength="20"/>
<span class="error_form" id="error_password2"></span>
                   </div>
                 </div>

                 <div class="form-row">
                    <div class="form-group col-md-12">
 
<div><span class="ofield">- Los campos con * (asterisco) son obligatorios<br></span>
<span class="ofield2">- La contraseña debe tener entre 6 caracteres y maximo 15 entre letras, números y al menos un carácter especial <strong>!@#$%</strong></span></div>
                     </div>
                    </div>

               <div class="modal-footer" style="border: none!important;">
                 <input type="hidden" name="id_usuario" id="id_usuario"/>
                 <button type="submit" name="action" id="btnGuardar" class="btn btn-success pull-left" value="Add"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
          <button type="button" onclick="limpiar()" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button>
               </div>
            </div>
         </form>
      </div>
    </div>


<?php
  require_once("footer.php");
?>
<script type="text/javascript" src="js/usuarios.js"></script>
<?php
  } else {
  header("Location:".Conectar::ruta()."vistas/index.php");
  }
?>

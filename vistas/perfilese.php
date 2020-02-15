<?php
   require_once("../config/conexion.php");
   require_once("../modelos/Roles.php");
    if(isset($_SESSION["id_usuario"])){
    	require_once("../modelos/Perfiles.php");
         $perfiL = new Perfiles();
          $usuario = new Roles();

?>

<?php
  #variable item activo
  $activar1 = 'item_permiso1';
  require_once("header.php");
?>
<?php if($_SESSION["PERMISO"]==1)
     {

     ?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <section class="content-header">

          <h1>Administración de perfiles</h1>

          <!-- migas de pan-->
          <ol class="breadcrumb">
             <li><a href="home.php"><i class="fa fa-home"></i>Inicio</a></li>
             <li><i class="fa fa-users"></i>Perfil</li>
          </ol>
   
        </section>
        <!-- Main content -->
        <section class="content">
             <div id="resultados_ajax"></div>
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header boton-top">
                          <h1 class="box-title">
                             <?php 
                             $rol=$usuario->listar_roles_por_usuario($_SESSION['id_usuario']);
                            $valores=array();
                            //Almacenamos los permisos marcados en el array
                             foreach($rol as $rows){

                             $valores[]= $rows["codigo"];
                                }   
                                if(in_array("REPERM",$valores)){
                                  echo '<button class="btn btn-primary btn-lg" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#perfilModal"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo Perfil</button>';
              }
                            ?>
                            </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive tabla-top">
                          <table id="perfil_data" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                <th width="5%">Codigo</th>
                                <th width="5%">Nombre</th>
                                <th width="5%">Estado</th>
                                <th width="5%">Acciones</th>
                              
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                          </table>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
    <!--FORMULARIO VENTANA MODAL-->
  <div id="perfilModal" class="modal fade">
  <div class="modal-dialog">
    <form method="post" id="perfiles_form" autocomplete="off">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar perfil</h4>
        </div>
        <div class="modal-body">

          <label>Nombre</label>
                   <input type="text" id="nombre" name="nombre"   class="form-control" placeholder="Nombre del Perfil" maxlength="60" autocomplete="off" required/>
                   <span class="error_form" id="error_nombre"></span>
                   <label>Codigo</label>
                    <?php 

                         $perfiL->codigo();


                     ?>
                  
     <label>Estado</label>
       <select class="form-control" id="estado" name="estado" >
        <option value="">selecione el estado</option>
                            <option value="1">Habilitado</option>
                            <option value="0">Dehabilitado</option>
                        
                        </select>
                        <span class="error_form" id="error_estado"></span>
                   
           </br>
        </div>
        <div class="modal-footer">
           <input type="hidden" name="idperfil" id="idperfil"/>
          <button type="submit" name="action" id="btnGuardar" class="btn btn-success pull-left" value="Add"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
          <button type="button" onclick="limpiar()" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="t rue"></i> Cerrar</button>
        </div>
      </div>
    </form>
  </div>
</div>


 <?php  } else {

       require("noacceso.php");
  }
   
  ?><!--
 <!--FIN FORMULARIO VENTANA MODAL-->
<!--CIERRE DE SESSION DE PERMISO -->
<?php
  require_once("footer.php");
?>
<script type="text/javascript" src="js/perfiles.js"></script>
<?php
  } else {
        header("Location:".Conectar::ruta()."vistas/index.php");
  }
?>

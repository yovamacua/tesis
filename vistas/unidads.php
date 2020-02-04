<?php
   require_once("../config/conexion.php");
   require_once("../modelos/Roles.php");
    if(isset($_SESSION["id_usuario"])){
      $usuario = new Roles();
?>
<?php
  #variable item activo
  $activar2 = 'item_unidad';
  require_once("header.php");
?>
<?php if($_SESSION["PERMISO"]==1)
     {

     ?>

  <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <section class="content-header">

          <h1>Administración de Unidades</h1>

          <!-- migas de pan-->
          <ol class="breadcrumb">
             <li><a href="home.php"><i class="fa fa-home"></i>Inicio</a></li>
             <li><i class="fa fa-users"></i> Unidad</li>
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
                                if(in_array("REVENT",$valores)){
                                  echo '<button class="btn btn-primary btn-lg" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#unidadModal"><i class="fa fa-plus" aria-hidden="true"></i> Registrar Unidad</button></h1>';
              }
                            ?>
                            
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive tabla-top">
                          <table id="unidad_data" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                <th width="5%">Unidad</th>
                                 <th width="5%">Descripción</th>
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
  <div id="unidadModal" class="modal fade">
  <div class="modal-dialog">
    <form method="post" id="unidad_form">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Unidad</h4>
        </div>
        <div class="modal-body">

          <label>Unidad</label>
          <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Titulo" maxlength="45" required="" autofocus="autofocus"/>
          <span class="error_form" id="error_unidad"></span>
          <br />


          <label>Descripción</label>
          <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Descripcion" maxlength="50" required=""/>
          <span class="error_form" id="error_descripcion"></span>
          <br />

        </div>
        <div class="modal-footer">
          <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_usuario"];?>" />
           <input type="hidden" name="id_unidad" id="id_unidad"/>
          <button type="submit" name="action" id="btnGuardar" class="btn btn-success pull-left" value="Add"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
          <button type="button" onclick="limpiar()" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="t rue"></i> Cerrar</button>
        </div>
      </div>
    </form>
  </div>
</div>
 <!--FIN FORMULARIO VENTANA MODAL-->
<?php  } else {

       require("noacceso.php");
  }
   
  ?><!--CIERRE DE SESSION DE PERMISO -->
<?php
  require_once("footer.php");
?>
<script type="text/javascript" src="js/unidads.js"></script>
<?php
  } else {
        header("Location:".Conectar::ruta()."vistas/index.php");
  }
?>

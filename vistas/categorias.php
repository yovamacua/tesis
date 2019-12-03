<?php
   require_once("../config/conexion.php");
    if(isset($_SESSION["id_usuario"])){
?>
<?php
  #variable item activo
  $activar = 'item_categorias';
  require_once("header.php");
?>
<?php if($_SESSION["Categoria"]==1)
     {

     ?>

  <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <section class="content-header">

          <h1>Listado de Categorias</h1>

          <!-- migas de pan-->
          <ol class="breadcrumb">
             <li><a href="home.php"><i class="fa fa-home"></i>Inicio</a></li>
             <li><i class="fa fa-users"></i> Categoria</li>
          </ol>
   
        </section>
        <!-- Main content -->
        <section class="content">
             <div id="resultados_ajax"></div>
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">
                            <button class="btn btn-primary btn-lg" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#categoriaModal"><i class="fa fa-plus" aria-hidden="true"></i> Registrar Categoría</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive tabla-top">
                          <table id="categoria_data" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                <th width="5%">Categoría</th>
                                <th width="5%">Descripcion</th>
                                <th width="5%">Editar</th>
                                 <?php  if($_SESSION["Eliminar"]==1)
                                 {
                             echo '<th width="5%">Eliminar</th>';
                                   }   
                                 ?>
                              
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
  <div id="categoriaModal" class="modal fade">
  <div class="modal-dialog">
    <form method="post" id="categoria_form">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Categoría</h4>
        </div>
        <div class="modal-body">

          <label>Categoría</label>
          <input type="text" name="categoria" id="categoria" class="form-control" placeholder="Titulo" maxlength="50" required="" autofocus="autofocus"/>
          <span class="error_form" id="error_categoria"></span>
          <br />


          <label>Descripcion</label>
          <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Descripcion" maxlength="70" required=""/>
          <span class="error_form" id="error_descripcion"></span>
          <br />

        </div>
        <div class="modal-footer">
          <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_usuario"];?>" />
           <input type="hidden" name="id_categoria" id="id_categoria"/>
          <button type="submit" name="action" id="btnGuardar" class="btn btn-success pull-left" value="Add"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
          <button type="button" onclick="limpiar()" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button>
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
<script type="text/javascript" src="js/categorias.js"></script>
<?php
  } else {
        header("Location:".Conectar::ruta()."vistas/index.php");
  }
?>

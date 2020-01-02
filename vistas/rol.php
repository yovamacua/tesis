<?php
   require_once("../config/conexion.php");
    if(isset($_SESSION["id_usuario"])){
    	 require_once("../modelos/Categorias.php");
         require_once("../modelos/Modulos.php");
         $categoria = new Categorias();
          $cat = $categoria->get_categoria();
         $modulo= new Modulos();
        $mod= $modulo->mostrar_modulo();
?>

<?php
  #variable item activo
  $activar = 'item_categorias';
  require_once("header.php");
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <section class="content-header">

          <h1>Listado de roles</h1>

          <!-- migas de pan-->
          <ol class="breadcrumb">
             <li><a href="home.php"><i class="fa fa-home"></i>Inicio</a></li>
             <li><i class="fa fa-users"></i> roles</li>
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
                            <button class="btn btn-primary btn-lg" id="add_button"  data-toggle="modal" onclick="limpiar()" data-target="#rolModal"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo Rol</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive tabla-top">
                          <table id="roles_data" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                <th width="5%">Rol</th>
                                <th width="5%">Modulo</th>
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
  <div id="rolModal" class="modal fade">
  <div class="modal-dialog">
    <form method="post" id="rol_form">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar rol</h4>
        </div>
        <div class="modal-body">

          <label>Nombre</label>
                   <input type="text" id="nombre" name="nombre"   class="form-control" placeholder="nombre" maxlength="60" autocomplete="off" required/>
                    <label>Codigo</label>
                   <input type="text" id="codigo" name="codigo"   class="form-control" placeholder="codigo" maxlength="60" autocomplete="off" required/>
                   <label>Modulo</label>
                   

                    <select class="form-control" id="modulo" name="modulo" >

                      <option  value="0">Seleccione</option>

                        <?php

                           for($i=0; $i<sizeof($mod);$i++){
                             
                             ?>
                              <option value="<?php echo $mod[$i]["idmodulo"]?>"><?php echo $mod[$i]["nombre"];?></option>
                             <?php
                           }
                        ?>
                      
                    </select>
                  </br>
     <label>descripcion</label>
      <textarea rows="4" maxlength="70" style=" word-break: break-all;    max-width: 100% !important;" cols="250" name="descripcion" id="descripcion" class="form-control" placeholder="Descripción" required/></textarea>
                   
           </br>
        </div>
        <div class="modal-footer">
           <input type="hidden" name="idroles" id="idroles"/>
          <button type="submit" name="action" id="btnGuardar" class="btn btn-success pull-left" value="Add"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
          <button type="button" onclick="limpiar()" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="t rue"></i> Cerrar</button>
        </div>
      </div>
    </form>
  </div>
</div>


 
 <!--FIN FORMULARIO VENTANA MODAL-->
<!--CIERRE DE SESSION DE PERMISO -->
<?php
  require_once("footer.php");
?>
<script type="text/javascript" src="js/roles.js"></script>
<?php
  } else {
        header("Location:".Conectar::ruta()."vistas/index.php");
  }
?>

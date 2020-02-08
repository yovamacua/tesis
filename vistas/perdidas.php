<?php
  require_once("../config/conexion.php");
  require_once("../modelos/Roles.php");
  if(isset($_SESSION["id_usuario"])){ 
 $usuario = new Roles();
  require_once("../modelos/Productos.php");
     $producto = new Producto();
     $p = $producto->getproductos();

  require_once("../modelos/Unidad.php");
     $unidad = new Unidad();
     $uni = $unidad->get_unidad();
?>

<?php
  #variable item activo
  $activar = 'item_perdidas';
  require_once("header.php");
  
?>
<?php if($_SESSION["PERDIDAS"]==1)
     {

     ?>
  <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <section class="content-header">

          <h1>Administración de Pérdidas</h1>

          <!-- migas de pan-->
          <ol class="breadcrumb">
             <li><a href="home.php"><i class="fa fa-home"></i>Inicio</a></li>
             <li><i class="fa fa-minus-square"></i> Pérdidas</li>
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
                                if(in_array("REPERD",$valores)){
                                  echo '<button class="btn btn-primary btn-lg" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#perdidaModal"><i class="fa fa-plus" aria-hidden="true"></i> Nueva Pérdida</button>';
              }
                            ?>
                           </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive tabla-top">
                          <table id="perdida_data" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                  <th width="15%">Autor</th>
                                  <th width="12%">Nombre Producto</th>
                                  <th width="10%">Cantidad</th>
                                  <th width="10%">Unidad de Medida</th>
                                  <th>Descripción</th>
                                  <th width="10%">Precio Unitario</th>
                                  <th width="10%">Fecha</th>
                                  <th>Acciones</th>
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
  <div id="perdidaModal" class="modal fade">
    <div class="modal-dialog">
      <form method="post" id="perdida_form" autocomplete="off" >
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Agregar Pérdida</h4>
          </div>
    <div class="modal-body">  
          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Nombre del Producto</label>
              <select class="form-control" id="idproducto" name="idproducto" onchange="precioProd(id)" required>
                <option  value="">Seleccione el Producto</option>
                  <?php
                     for($i=0; $i<sizeof($p);$i++){
                       ?>
                        <option value="<?php echo $p[$i]["id_producto"]?>"><?php echo $p[$i]["producto"];?></option>
                       <?php
                     }
                  ?>   
              </select>
              <span class="error_form" id="error_idproducto"></span>
            </div>

            <div class="form-group col-md-6">
              <label>Unidad de Medida</label>
              <select class="form-control" id="unidadDelProduc" name="unidadDelProduc" required>
                <option  value="">Seleccione la Unidad</option>
                  <?php
                     for($i=0; $i<sizeof($uni);$i++){
                       ?>
                        <option value="<?php echo $uni[$i]["idunidad"]?>"><?php echo $uni[$i]["nombre"];?></option>
                       <?php
                     }
                  ?>   
              </select>
              <span class="error_form" id="error_unidadDelProduc"></span>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-4">
              <label>Fecha</label>
              <input type="text" name="fecha" id="fecha1" class="form-control" autocomplete="off" placeholder="Fecha" required />
              <span class="error_form" id="error_fecha1"></span>
            </div>

            <div class="form-group col-md-4">
              <label>Cantidad</label>
              <input type="text" name="cantidad" id="cantidad" class="form-control" autocomplete="off" placeholder="Cantidad en número" required/>
              <span class="error_form" id="error_cantidad"></span>
            </div>

            <div class="form-group col-md-4">
              <label>Precio Unitario</label>
              <input type="text" name="precioProduc" id="precioProduc" class="form-control" readonly/>
              <span class="error_form" id="error_precioProduc"></span>
            </div>
          </div>


          <div class="form-row">
            <div class="form-group col-md-12">
              <label>Descripción</label>
              <textarea rows="4" maxlength="250" style=" word-break: break-all;    max-width: 100% !important;" cols="250" name="descripcion" id="descripcion" class="form-control" placeholder="Descripción" required/></textarea>
              <span class="error_form" id="error_descripcion"></span>
            </div>
          </div>
       <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    </div><!-- body -->

              <div class="modal-footer">
                 <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_usuario"];?>" />
                 <input type="hidden" name="id_perdida" id="id_perdida"/>
                 <button type="submit" name="action" id="btnGuardar" class="btn btn-success pull-left" value="Add" onclick="desvanecer()"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
              <button type="button" onclick="limpiar()" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button>
              </div>
            </div>
         </form>
      </div>
    </div>
    <?php  } else {

       require("noacceso.php");
  }
   
  ?><!--CIERRE DE SESSION DE PERMISO -->
<?php
  require_once("footer.php");
?>
<script type="text/javascript" src="js/perdidas.js"></script>
<?php
  } else {
    header("Location:".Conectar::ruta()."vistas/index.php");
  }
?>
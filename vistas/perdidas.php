<?php
  require_once("../config/conexion.php");
  if(isset($_SESSION["id_usuario"])){ 

  require_once("../modelos/Productos.php");
     $producto = new Producto();
     $p = $producto->getproductos();
?>

<?php
  #variable item activo
  $activar = 'item_perdidas';
  require_once("header.php");
  
?>
<?php if($_SESSION["Perdidas"]==1)
     {

     ?>
  <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <section class="content-header">

          <h1>Listado de Pérdidas</h1>

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
                            <button class="btn btn-primary btn-lg" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#perdidaModal"><i class="fa fa-plus" aria-hidden="true"></i> Nueva Pérdida</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive tabla-top">
                          <table id="perdida_data" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                  <th width="12%">Nombre Producto</th>
                                  <th width="10%">Cantidad</th>
                                  <th width="10%">Unidad de Medida</th>
                                  <th>Descripción</th>
                                  <th width="10%">Precio Unitario</th>
                                  <th>Mes</th>
                                  <th>Año</th>
                                  <th width="15%">Autor</th>
                                <?php  if($_SESSION["Eliminar"]==0 and $_SESSION["Editar"]==0){
                              
                              }else{
                                  echo '<th>Acciones</th>';
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
  <div id="perdidaModal" class="modal fade">
    <div class="modal-dialog">
      <form method="post" id="perdida_form" autocomplete="off" >
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Agregar Pérdida</h4>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Nombre del Producto</label>
              <select class="form-control" id="idproducto" name="idproducto" required>
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
              <label>Cantidad</label>
              <input type="text" name="cantidad" id="cantidad" class="form-control" autocomplete="off" placeholder="Cantidad en número" required/>
              <span class="error_form" id="error_cantidad"></span>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Precio del Producto</label>
              <input type="text" step="any" name="precioProduc" id="precioProduc" class="form-control" autocomplete="off" placeholder="0.00" required/>
              <span class="error_form" id="error_precioProduc"></span>
            </div>

            <div class="form-group col-md-6">
              <label>Unidad de Medida</label>
                <select class="selectpicker form-control" id="unidadDelProduc" name="unidadDelProduc" required>
                  <option value="">-- Seleccione la Unidad --</option>
                  <option value="kilo">kilo</option>
                  <option value="gramo">gramo</option>
                  <option value="libra">libra</option>
                  <option value="unidad">unidad</option>
                </select>
                <span class="error_form" id="error_unidadDelProduc"></span>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-12">
              <label>Descripción</label>
              <input type="text" name="descripcion" id="descripcion" class="form-control" autocomplete="off" placeholder="Breve descripción" required/>
              <span class="error_form" id="error_descripcion"></span>
            </div>
          </div>
          
          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Mes</label>
              <input type="text" name="mes" id="mes" class="form-control" autocomplete="off" placeholder="mm" required/>
              <span class="error_form" id="error_mes"></span>
            </div>

            <div class="form-group col-md-6">
              <label>Año</label>
              <input type="text" name="anio" id="anio" class="form-control" autocomplete="off" placeholder="AAAA" required />
              <span class="error_form" id="error_anio"></span>
            </div>
          </div>
 

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
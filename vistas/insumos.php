<?php
  require_once("../config/conexion.php");

  if(isset($_SESSION["id_usuario"])){ 

    require_once("../modelos/Categorias.php");
       $categoria = new Categorias();
       $cat = $categoria->get_categoria();

    require_once("../modelos/Pedidos.php");
       $pedido = new Pedidos();
       $p = $pedido->get_pedido();
?>

<?php
  #variable para mostrar como item activo
  $activar = 'item_pedidos';
  $activar2 = 'item_pedidos2';
  require_once("header.php");
?>

  <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
             <div id="resultados_ajax"></div>
             <h2>Listado de Insumos</h2>
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">
                            <button class="btn btn-primary btn-lg" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#insumoModal"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo Insumo</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive">
                          <table id="insumo_data" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                  <th>Cantidad</th>
                                  <th>Precio</th>
                                  <th>Unidad de Medida</th>
                                  <th>Descripcion</th>
                                  <th>No. Pedido</th>
                                  <th>Categoria</th>
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
  <div id="insumoModal" class="modal fade">
    <div class="modal-dialog">
      <form method="post" id="insumo_form">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Agregar Insumo</h4>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Cantidad</label>
              <input type="number" name="cantidad" id="cantidad" autocomplete="off" class="form-control" placeholder="cantidad" required/>
            </div>

            <div class="form-group col-md-6">
              <label>Precio</label>
              <input type="number" name="precio" id="precio" autocomplete="off" class="form-control" placeholder="0.00" required/>
            </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-12">
            <label>Descripción</label>
            <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Breve descripción" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$"/>
          </div>  
        </div> 

        <div class="form-row">
          <div class="form-group col-md-4">
            <label>Unidad de Medida</label>
            <select class="selectpicker form-control" id="unidadMedida" name="unidadMedida" required>
                  <option value="">-- Seleccione unidad --</option>
                  <option value="kilo">kilo</option>
                  <option value="gramo">gramo</option>
                  <option value="libra">libra</option>
                  <option value="unidad">unidad</option>
                </select>
          </div>

          <div class="form-group col-md-4">
             <label>No. de Pedido</label>
              <select class="form-control" id="idpedido" name="idpedido" >
                <option  value="0">Seleccione el No. de Pedido</option>
                  <?php
                     for($i=0; $i<sizeof($p);$i++){
                       ?>
                        <option value="<?php echo $p[$i]["id_pedido"]?>"><?php echo $p[$i]["id_pedido"];?></option>
                       <?php
                     }
                  ?>   
              </select>
          </div>

          <div class="form-group col-md-4">
            <label>Categoría</label>
              <select class="form-control" id="idcategoria" name="idcategoria" >
                <option  value="0">Seleccione la Categoría</option>
                  <?php
                     for($i=0; $i<sizeof($cat);$i++){
                       ?>
                        <option value="<?php echo $cat[$i]["id_categoria"]?>"><?php echo $cat[$i]["categoria"];?></option>
                       <?php
                     }
                  ?>   
              </select>
          </div> 
        </div> 

               <div class="modal-footer">
                  <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_usuario"];?>" />
                  <input type="hidden" name="id_insumo" id="id_insumo"/>
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
<script type="text/javascript" src="js/insumos.js"></script>
<?php
  } else {
    header("Location:".Conectar::ruta()."vistas/index.php");
  }
?>
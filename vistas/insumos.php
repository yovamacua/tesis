<?php
  require_once("../config/conexion.php");

  if(isset($_SESSION["id_usuario"])){ 

    require_once("../modelos/Categorias.php");
       $categoria = new Categorias();
       $cat = $categoria->get_categoria();

    require_once("../modelos/Pedidos.php");
       $pedido = new Pedidos();
       $p = $pedido->get_pedido();

    require_once("../modelos/Insumos.php");
       $insumo = new Insumos();
       $in = $insumo->get_insumos();

    require_once("../modelos/Unidad.php");
     $unidad = new Unidad();
     $uni = $unidad->get_unidad();
?>

<?php
  #variable para mostrar como item activo
  $activar = 'item_pedidos';
  $activar2 = 'item_pedidos2';
  require_once("header.php");
?>
 <?php if($_SESSION["Pedidos"]==1)
     {

     ?>
  <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <section class="content-header">

          <h1>Listado de Insumos</h1>

          <!-- migas de pan-->
          <ol class="breadcrumb">
             <li><a href="home.php"><i class="fa fa-home"></i>Inicio</a></li>
             <li><i class="fa fa-shopping-basket"></i> Insumos</li>
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
                            <button class="btn btn-primary btn-lg" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#insumoModal"><i class="fa fa-plus" aria-hidden="true"></i> Entrada de Insumo</button></h1>

                            <h1 class="box-title">
                            <button class="btn btn-primary btn-lg" id="minus_button" onclick="limpiar2()" data-toggle="modal" data-target="#kardexinsumoModal"><i class="fa fa-minus" aria-hidden="true"></i> Salida de Insumo</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive tabla-top">
                          <table id="insumo_data" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                  <th width="15%">Autor</th>
                                  <th width="10%">Fecha</th>
                                  <th width="10%">Categoria</th>
                                  <th>Descripcion</th>
                                  <th width="10%">Cantidad</th>
                                  <th width="10%">Unidad de Medida</th>
                                  <th width="10%">Precio</th>                                  
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
  <div id="insumoModal" class="modal fade">
    <div class="modal-dialog">
      <form method="post" id="insumo_form" autocomplete="off">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Agregar Insumo</h4>
          </div>

          <!--- codigo para mostrar calendario jquery IU -->
          <script>
            $(function () {
                $("#fecha1").datepicker({
                    format: "dd/mm/yyyy",
                    firstDay: 1
                }).datepicker("setDate", new Date());
             });          
           </script>
          <!--- fin codigo para mostrar calendario jquery IU -->

          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Cantidad</label>
              <input type="text" name="cantidad" id="cantidad" autocomplete="off" class="form-control" placeholder="Cantidad" required/>
              <span class="error_form" id="error_cantidad"></span>
            </div>

            <div class="form-group col-md-6">
              <label>Precio unitario</label>
              <input type="text" name="precio" id="precio" autocomplete="off" class="form-control" placeholder="0.00" required/>
              <span class="error_form" id="error_precio"></span>
            </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-12">
            <label>Nombre o Descripción</label>
            <textarea rows="4" maxlength="250" style=" word-break: break-all;    max-width: 100% !important;" cols="250" name="descripcion" id="descripcion" class="form-control" placeholder="Descripción" required/></textarea>
            <span class="error_form" id="error_descripcion"></span>
          </div>  
        </div> 

        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Unidad de Medida</label>
            <select class="form-control" id="iduni" name="iduni" required>
                <option  value="">Seleccione la Unidad</option>
                  <?php
                     for($i=0; $i<sizeof($uni);$i++){
                       ?>
                        <option value="<?php echo $uni[$i]["idunidad"]?>"><?php echo $uni[$i]["nombre"];?></option>
                       <?php
                     }
                  ?>   
              </select>
              <span class="error_form" id="error_iduni"></span>
          </div>

          <div class="form-group col-md-6">
            <label>Fecha</label>
            <input type="text" name="fecha" id="fecha1" class="form-control" placeholder="Fecha"/>
             <span class="error_form" id="error_fecha1"></span>
          </div>  
        </div> 

        <div class="form-row">
          <div class="form-group col-md-6">
             <label>No. de Pedido</label>
              <select class="form-control" id="idpe" name="idpedido" required>
                <option  value="">Seleccione el No. de Pedido</option>
                  <?php
                     for($i=0; $i<sizeof($p);$i++){
                       ?>
                        <option value="<?php echo $p[$i]["id_pedido"]?>"><?php echo $p[$i]["id_pedido"];?></option>
                       <?php
                     }
                  ?>   
              </select>
              <span class="error_form" id="error_idpe"></span>
          </div>

          <div class="form-group col-md-6">
            <label>Categoría</label>
              <select class="form-control" id="idcategoria" name="idcategoria" required>
                <option  value="">Seleccione la Categoría</option>
                  <?php
                     for($i=0; $i<sizeof($cat);$i++){
                       ?>
                        <option value="<?php echo $cat[$i]["id_categoria"]?>"><?php echo $cat[$i]["categoria"];?></option>
                       <?php
                     }
                  ?>   
              </select>
              <span class="error_form" id="error_idcategoria"></span>
          </div> 
        </div> 

               <div class="modal-footer">
                  <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_usuario"];?>" />
                  <input type="hidden" name="id_insumo" id="id_insumo"/>
                  <button type="submit" name="action" id="btnGuardar" class="btn btn-success pull-left" value="Add" onclick="desvanecer()"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                  <button type="button" onclick="limpiar()" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button>
              </div>
            </div>
         </form>
      </div>
    </div>

   <!--FORMULARIO VENTANA MODAL-->
   <div id="kardexinsumoModal" class="modal fade">
    <div class="modal-dialog">
      <form method="post" id="kardexinsumo_form">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title2">Descontar Insumo</h4>
          </div>

          <!--- codigo para mostrar calendario jquery IU -->
          <script>
            $(function () {
                $("#Fecha").datepicker({
                    format: "dd/mm/yyyy",
                    firstDay: 1
                }).datepicker("setDate", new Date());
             });          
           </script>
          <!--- fin codigo para mostrar calendario jquery IU -->

           <div class="form-row">
            <div class="form-group col-md-12">
              <label>Insumo</label>
                <select class="form-control" name="idinsumo" id="Id_insumo" placeholder="Seleccione el insumo" required>
                  <option  value="">Seleccione el Insumo</option>
                    <?php
                       for($i=0; $i<sizeof($in);$i++){
                         ?>
                          <option value="<?php echo $in[$i]["id_insumo"]?>"><?php echo $in[$i]["descripcion"];?></option>
                         <?php
                       }
                    ?>   
                </select>
                <span class="error_form" id="error_Id_insumo"></span>
            </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Cantidad</label>
            <input type="text" name="salida" id="Cantidad" autocomplete="off" class="form-control" placeholder="cantidad" required/>
            <span class="error_form" id="error_Cantidad"></span>
          </div>

          <div class="form-group col-md-6">
            <label>fecha</label>
            <input type="text" name="fechaS" id="Fecha" class="form-control" placeholder="Fecha" required/>
            <span class="error_form" id="error_Fecha"></span>
          </div>  
        </div> 

               <div class="modal-footer">
                  <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_usuario"];?>" />
                  <input type="hidden" name="id_kardexinsumo" id="id_kardexinsumo"/>
                  <button type="submit" name="action" id="btnGuardar" class="btn btn-success pull-left" value="Add" onclick="desvanecer()"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                  <button type="button" onclick="limpiar2()" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button>
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
<script type="text/javascript" src="js/insumos.js"></script>
<?php
  } else {
    header("Location:".Conectar::ruta()."vistas/index.php");
  }
?>
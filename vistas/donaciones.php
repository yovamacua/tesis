<?php
  require_once("../config/conexion.php");
  if(isset($_SESSION["id_usuario"])){ 
?>

<?php
  #variable item activo
  $activar = 'item_donaciones';
  require_once("header.php");
  
?>
<?php if($_SESSION["Donaciones"]==1)
     {

     ?>
  <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <section class="content-header">

          <h1>Listado de Donaciones</h1>

          <!-- migas de pan-->
          <ol class="breadcrumb">
             <li><a href="home.php"><i class="fa fa-home"></i>Inicio</a></li>
             <li><i class="fa fa-gift"></i> Donaciones</li>
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
                            <button class="btn btn-primary btn-lg" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#donacionModal"><i class="fa fa-plus" aria-hidden="true"></i> Nueva Donación</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive tabla-top">
                          <table id="donacion_data" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                  <th>Fecha</th>
                                  <th>Donante</th>
                                  <th>Descripción</th>
                                  <th>Cantidad</th>
                                  <th>Precio</th>
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
  <div id="donacionModal" class="modal fade">
      <div class="modal-dialog">
         <form method="post" id="donacion_form">
            <div class="modal-content">
               <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                 <h4 class="modal-title">Agregar Donación</h4>
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
              <label>Fecha</label>
              <input type="text" name="fecha" id="fecha1" autocomplete="off" class="form-control" placeholder="Fecha" required/>
            </div>
            <div class="form-group col-md-6">
              <label>Donante</label>
              <input type="text" name="donante" id="donante" class="form-control" placeholder="nombre del donante" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$"/>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-12">
            <label>Descripción</label>
            <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Breve descripción" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$"/>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Cantidad</label>
            <input type="number" step="any" name="cantidad" id="cantidad" class="form-control" autocomplete="off" placeholder="cantidad" required/>
          </div>
           <div class="form-group col-md-6">
            <label>Precio</label>
            <input type="number" name="precio" id="precio" class="form-control" autocomplete="off" placeholder="0.00" step="any" required/>
          </div>
        </div>
 
                <div class="modal-footer">
                 <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_usuario"];?>" />
                 <input type="hidden" name="id_donacion" id="id_donacion"/>
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
<script type="text/javascript" src="js/donaciones.js"></script>
<?php
  } else {
    header("Location:".Conectar::ruta()."vistas/index.php");
  }
?>
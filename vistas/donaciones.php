<?php
  require_once("../config/conexion.php");
  require_once("../modelos/Roles.php");
  if(isset($_SESSION["id_usuario"])){ 
    require_once("../modelos/Donaciones.php");

    //SI EXISTE EL POST ENTONCES SE LLAMA AL METODO PARA SELECCIONAR LA FECHA
    $donacion = new Donaciones();
     $usuario = new Roles();

    if(isset($_POST["year"])){
      $datos = $donacion->get_donacion_mensual($_POST["year"]);  
    }else{
      $fecha_inicial = date("Y");
      $datos = $donacion->get_donacion_mensual($fecha_inicial);  
    }
     $fecha_donaciones = $donacion->get_year_donaciones();

?>

<?php
  #variable item activo
  $activar = 'item_donaciones';
  require_once("header.php");
  
?>
<?php if($_SESSION["DONACIONES"]==1)
     {

     ?>
  <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <section class="content-header">

          <h1>Administración de Donaciones</h1>

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
                            <?php 
                             $rol=$usuario->listar_roles_por_usuario($_SESSION['id_usuario']);
                            $valores=array();
                            //Almacenamos los permisos marcados en el array
                             foreach($rol as $rows){

                             $valores[]= $rows["codigo"];
                                }   
                                if(in_array("REDONA",$valores)){
                                  echo '<button class="btn btn-primary btn-lg" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#donacionModal"><i class="fa fa-plus" aria-hidden="true"></i> Nueva Donación</button>';
              }
                            ?>
                            </h1>
                        <div class="box-tools pull-right">
                        </div>
                        <button class="btn btn-primary btn-lg" style="background:#00c0ef" id="add_reporte"  data-toggle="modal" data-target="#reporteModal"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Generar Reporte</button>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive tabla-top">
                          <table id="donacion_data" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                  <th width="15%">Autor</th>
                                  <th width="10%">Fecha</th>
                                  <th width="15%">Donante</th>
                                  <th>Descripción</th>
                                  <th width="8%">Cantidad</th>
                                  <th width="10%">Valorado c/u en</th> 
                                    <th >Acciones</th>
                                  
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
         <form method="post" id="donacion_form" autocomplete="off">
            <div class="modal-content">
               <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                 <h4 class="modal-title">Agregar Donación</h4>
               </div>
      <div class="modal-body">

          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Fecha</label>
              <input type="text" name="fecha" id="fecha1" autocomplete="off" class="form-control" placeholder="Fecha" required/>
              <span class="error_form" id="error_fecha1"></span>
            </div>

            <div class="form-group col-md-6">
              <label>Donante</label>
              <input type="text" name="donante" id="donante" class="form-control"  autocomplete="off" placeholder="Nombre del donante" required/>
              <span class="error_form" id="error_donante"></span>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-12">
            <label>Descripción</label>
            <textarea rows="4" maxlength="250" style=" word-break: break-all;    max-width: 100% !important;" cols="250" name="descripcion" id="descripcion" class="form-control" placeholder="Descripción" required/></textarea>
            <span class="error_form" id="error_descripcion"></span>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Cantidad</label>
            <input type="text" name="cantidad" id="cantidad" class="form-control" autocomplete="off" placeholder="Cantidad" required/>
            <span class="error_form" id="error_cantidad"></span>
          </div>

           <div class="form-group col-md-6">
            <label>Valorado c/u en</label>
            <input type="text" name="precio" id="precio" class="form-control" autocomplete="off" placeholder="0.00" required/>
            <span class="error_form" id="error_precio"></span>
          </div>
        </div>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
      </div><!-- body -->
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

    <!--FORMULARIO VENTANA MODAL REPORTE-->
  <div id="reporteModal" class="modal fade">
      <div class="modal-dialog">
         <form method="post" action="reportes/reporte_donaciones.php">
            <div class="modal-content">
<div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">×</button>
               <h4 class="modal-title">Generar Reporte</h4>
            </div>
      <div class="modal-body">  
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label>Seleccione el año para el reporte a generar</label>
                  </div>
                </div>
               <div class="form-group col-md-2">
                     &nbsp;
                    </div>

                <div style="text-align: center" class="form-row">
                    <div class="form-group col-md-4">
                      <select class="form-control" name="year" id="year">
                        <option value="0">Seleccione...</option>
                          <?php 
                           //si se envia el POST
                            if(isset($_POST["year"])){
                              for($i=0; $i<count($fecha_donaciones); $i++){

                                if($fecha_donaciones[$i]["fecha"]==$_POST["year"]){
                                  echo '<option value="'.$fecha_donaciones[$i]["fecha"].'" selected=selected>'.$fecha_donaciones[$i]["fecha"].'</option>';
                                }else{ 
                                  echo '<option value="'.$fecha_donaciones[$i]["fecha"].'">'.$fecha_donaciones[$i]["fecha"].'</option>';
                                } 
                              }//cierre del ciclo for
                            //SI NO SE ENVIA EL POST
                            } else {
                              for ($i=0; $i<count($fecha_donaciones); $i++){
                                echo '<option value="'. $fecha_donaciones[$i]["fecha"].'" selected=selected>'. $fecha_donaciones[$i]["fecha"].'</option>';        

                              }//cierre del ciclo for
                            }//cierre del ese
                          ?>
                      </select>
                    </div> 
                    
                    <div class="form-group col-md-4">
                      <button id="btnArchivo" type="submit" class="btn btn-primary" ><i class="fa fa-file-excel-o" aria-hidden="true"></i> Generar Archivo</button> 
                    </div>
                    <div class="form-group col-md-2">
                      &nbsp;
                    </div>
                </div>
                </div><!-- body -->
                <div style="clear: both;"></div>
                <div class="modal-footer">
                  <input type="hidden" name="fecha" id="fechaA"/>
                 <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button>     
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
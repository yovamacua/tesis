<?php
  require_once("../config/conexion.php");
  if(isset($_SESSION["id_usuario"])){ 
    require_once("../modelos/Gastos.php");

    //SI EXISTE EL POST ENTONCES SE LLAMA AL METODO PARA SELECCIONAR LA FECHA
    $gastos = new Gastos();

    if(isset($_POST["year"])){
      $datos = $gastos->get_gasto_mensual($_POST["year"]);  
    }else{
      $fecha_inicial = date("Y");
      $datos = $gastos->get_gasto_mensual($fecha_inicial);  
    }
     $fecha_gastos = $gastos->get_year_gastos();

?>

<?php
  #variable item activo
  $activar = 'item_gastos';
  require_once("header.php");
?>
<?php if($_SESSION["Gastos"]==1)

     {

     ?>
  <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <section class="content-header">

          <h1>Listado de Gastos</h1>

          <!-- migas de pan-->
          <ol class="breadcrumb">
             <li><a href="home.php"><i class="fa fa-home"></i>Inicio</a></li>
             <li><i class="fa fa-money"></i> Gastos</li>
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
                            <button class="btn btn-primary btn-lg" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#gastoModal"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo Gasto</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive tabla-top">
                          <table id="gasto_data" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                  <th width="15%">Autor</th>
                                  <th width="10%">Fecha</th>
                                  <th>Descripción</th>
                                  <th width="10%">Gasto</th>
                                 
                                  <th>Acciones</th>
                                    
                                  </tr>
                              </thead>
                            <tbody>
                            </tbody>
                          </table>

                          <!-- inicio del div del boton generar reporte donaciones -->
                      <div class="form-row" style="width:300px;">
                        <!--form para generar el archivo excel-->
                        <label>Seleccione el año para el reporte a generar</label>
                        <form action="reportes/reporte_gastos.php" method="post">
                          <div class="form-group col-md-6">
                            <select class="form-control" name="year" id="year">
                              <option value="0">Seleccione...</option>
                                <?php 
                                 //si se envia el POST
                                  if(isset($_POST["year"])){
                                    for($i=0; $i<count($fecha_gastos); $i++){

                                      if($fecha_gastos[$i]["fecha"]==$_POST["year"]){
                                        echo '<option value="'.$fecha_gastos[$i]["fecha"].'" selected=selected>'.$fecha_gastos[$i]["fecha"].'</option>';
                                      }else{ 
                                        echo '<option value="'.$fecha_gastos[$i]["fecha"].'">'.$fecha_gastos[$i]["fecha"].'</option>';
                                      } 
                                    }//cierre del ciclo for
                                  //SI NO SE ENVIA EL POST
                                  } else {
                                    for ($i=0; $i<count($fecha_gastos); $i++){
                                      echo '<option value="'. $fecha_gastos[$i]["fecha"].'" selected=selected>'. $fecha_gastos[$i]["fecha"].'</option>';        

                                    }//cierre del ciclo for
                                  }//cierre del ese
                                ?>
                            </select>
                          </div> 
                         
                          <div class="form-group col-md-6">
                            <input type="hidden" name="fecha" id="fechaA"/>                            
                            <button  id="btnArchivo" type="submit" class="btn btn-primary" ><i class="fa fa-file-excel-o" aria-hidden="true"></i> Generar Reporte</button> 
                          </div>   
                        </form>
                      </div> 
                    <!-- fin del div del boton generar reporte donaciones -->

                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
  <!--FORMULARIO VENTANA MODAL-->
  <div id="gastoModal" class="modal fade">
    <div class="modal-dialog">
      <form method="post" id="gasto_form" autocomplete="off">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Agregar Gasto</h4>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Fecha</label>
              <input type="text" name="fecha" id="fecha1" autocomplete="off" class="form-control" placeholder="Fecha" required/>
              <span class="error_form" id="error_fecha1"></span>
            </div>

            <div class="form-group col-md-6">
            <label>Gasto</label>
            <input type="text" name="precio" id="precio" class="form-control" autocomplete="off" placeholder="0.00" step="any" required/>
            <span class="error_form" id="error_precio"></span>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-12">
            <label>Descripción</label>
            <textarea rows="4" maxlength="250" style=" word-break: break-all;    max-width: 100% !important;" cols="250" name="descripcion" id="descripcion" class="form-control" placeholder="Descripción" required/></textarea>
            <span class="error_form" id="error_descripcion"></span>
          </div>  
        </div> 

               <div class="modal-footer">
                  <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_usuario"];?>" />
                  <input type="hidden" name="id_gasto" id="id_gasto"/>
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
<script type="text/javascript" src="js/gastos.js"></script>
<?php
  } else {
    header("Location:".Conectar::ruta()."vistas/index.php");
  }
?>
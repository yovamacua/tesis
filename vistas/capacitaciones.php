<?php  
   require_once("../config/conexion.php");
   require_once("../modelos/Roles.php");

    if(isset($_SESSION["id_usuario"])){

      require_once("../modelos/Capacitaciones.php");
      require_once("../modelos/DetalleCapacitados.php");
      $capacitaciones = new Capacitaciones();
      $detalleCapacitados = new DetalleCapacitados();
      $usuario = new Roles();

      require_once("../modelos/Capacitaciones.php");
      $cap = new Capacitaciones();
      $c = $cap->get_capacitacion();
?>

<?php
  #variable item activo
  $activar = 'item_capacitaciones';
  require_once("header.php");
?>
<?php if($_SESSION["CAPACITACIONES"]==1)
     {

     ?>
  <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <section class="content-header">

          <h1>Administración de Capacitaciones</h1>

          <!-- migas de pan-->
          <ol class="breadcrumb">
             <li><a href="home.php"><i class="fa fa-home"></i>Inicio</a></li>
             <li><i class="fa fa-book"></i> Capacitaciones</li>
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
                                if(in_array("RECAPA",$valores)){
                                  echo '<button class="btn btn-primary btn-lg" id="add_button"  onclick="limpiar()" data-toggle="modal" data-target="#capacitacionModal"><i class="fa fa-plus" aria-hidden="true"></i> Registrar Capacitación</button>';
                                }

                             ?>
                            </h1>
                        <div class="box-tools pull-right"></div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive tabla-top" id="listadoregistros">
                          <table id="capacitacion_data" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                  <th width="12%">No. de Capacitación</th>
                                  <th>Fecha</th>
                                  <th>Nombre del Grupo</th>
                                  <th>Encargado</th>
                                  <th>Cargo</th>
                                  <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                          </table>
                    </div>

                    <!--Fin centro -->
          <div class="box-header" style="margin-top: -2.6%; padding: 0px!important;    z-index: 9999999!important;">
              <!--Formulario para agregar capacitados -->
<div id="distancia"><br><br></div>
            <button id="btnAgregarCap" class="collapsible btn btn-primary btn-lg" onclick="limpiardetalle();" data-target="#detallecapacitadosModal"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Capacitado</button>

            <div class="panel-body table-responsive contenedor" id="detallecapacitadosModal" >
              <form method="post" id="detallecapacitados_form" autocomplete="off">

                <div class="form-group col-md-12">

                  <div class="form-group col-md-3">
                    <label>Nombres</label>
                    <input type="text" name="nombres" id="nombres" class="form-control" placeholder="Nombres" autocomplete="off" required/>
                    <span class="error_form" id="error_nombres"></span>
                  </div>

                  <div class="form-group col-md-3">
                    <label>Apellidos</label>
                    <input type="text" name="apellidos" id="apellidos" class="form-control" placeholder="Apellidos" autocomplete="off" required/>
                    <span class="error_form" id="error_apellidos"></span>
                  </div>

                  <div class="form-group col-md-3">
                    <label>DUI</label>
                    <input type="text" name="dui" id="dui" class="form-control" placeholder="00000000-0" autocomplete="off" required/>
                    <span class="error_form" id="error_dui"></span>
                  </div>

                  <div class="form-group col-md-3" style="margin-top: 5px">
                    <br>
                    <button type="submit" class="btn btn-success pull-left" value="Add" onclick="desvanecer()"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                  </div>

                </div>
             
                    <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_usuario"];?>" />
                    <input type="hidden" name="id_detallecapacitados" id="id_detallecapacitados"/>
                    <input type="hidden" name="id_capacitacion" id="id_capa"/>  
                  
                </form>
              </div>

         
            <!--Fin formulario para agregar capacitados -->

                    <!--Tabla de capacitados -->
                      <div class="panel-body table-responsive tabla-cap" id="capacitadosModal" style="margin-top: -2.5rem!important;">
                        
                        <table id="detallecapacitados_data" class="table table-bordered table-striped">
                          <thead>
                              <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>DUI</th>
                                <th>Acciones</th>
                              </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                        
                        <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_usuario"];?>" />

                         <!-- div para el boton generar reporte asistencia de capacitacion -->
                        <div style="width:200px;">
                         
                          <div style="width:100px; float:left;">
  <button id="btnCancelar" class="btn btn-danger" type="button" 
  onclick="cancelarform(); document.getElementById('distancia').style.display='block'"><i class="fa fa-arrow-circle-left"></i><font color=white> Regresar</font></a></button>
                          </div> 
                         
                          <div style="width:100px; float:right;">
                            <!--form para generar el archivo excel-->
                            <form action="reportes/reporte_capacitacion.php" method="post">
                              <input type="hidden" name="id_capacitacion" id="id_cap"/>                
                              <button  id="btnArchivo" type="submit" class="btn btn-primary" ><i class="fa fa-file-excel-o" aria-hidden="true"></i> Generar Reporte</button>   
                            </form>
                        </div> 

                      </div> 
                    <!-- fin del div del boton generar reporte asistencia de capacitacion -->
                      </div>
                    <!--Fin tabla de capacitados -->

                </div>
              </div>
            </div>
          </section><!-- /.content -->
        </div>

 <!--FORMULARIO VENTANA MODAL CAPACITACION-->
  <div id="capacitacionModal"class="modal fade">
  <div class="modal-dialog">
    <form method="post" id="capacitacion_form" autocomplete="off">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Capacitación</h4>
        </div>
      <div class="modal-body">
        
         <div class="form-row">
          <div class="form-group col-md-6">
            <label>Fecha</label>
            <input type="text" name="fecha" id="fecha1" class="form-control" placeholder="Fecha" autocomplete="off" required/>
            <span class="error_form" id="error_fecha1"></span>
          </div>
          <div class="form-group col-md-6">
            <label>Nombre de Grupo</label>
            <input type="text" name="nombreGrupo" id="nombreGrupo" class="form-control" placeholder="Nombre de Grupo" required/>
            <span class="error_form" id="error_nombreGrupo"></span>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Encargado</label>
            <input type="text" name="encargado" id="encargado" class="form-control" placeholder="Nombre del Encargado" autocomplete="off" required/>
            <span class="error_form" id="error_encargado"></span>
          </div>
          <div class="form-group col-md-6">
            <label>Cargo</label>
            <input type="text" name="cargo" id="cargo" class="form-control" placeholder="Cargo del Encargado" autocomplete="off" required/>
            <span class="error_form" id="error_cargo"></span>
          </div>
        </div>
        <br><br><br><br><br><br><br>
      </div><!-- body -->
    
        <div class="modal-footer">
          <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_usuario"];?>" />
          <input type="hidden" name="id_capacitacion" id="id_capacitacion" value="<?php echo $_GET["id_capacitacion"];?>"/>
          <button type="submit" class="btn btn-success pull-left" value="Add" onclick="desvanecer()"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
          <button type="button" onclick="limpiar()" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button>
        </div>
      </div>
    </form>
  </div>
</div>
 <!--FIN FORMULARIO VENTANA MODAL-->
         

<!--Fin-Contenido-->

<?php  } else {

       require("noacceso.php");
  }
   
  ?><!--CIERRE DE SESSION DE PERMISO -->
<?php
  require_once("footer.php");
?>
<script type="text/javascript" src="js/capacitaciones.js"></script>

<?php
  } else {
        header("Location:".Conectar::ruta()."vistas/index.php");
  }
?>

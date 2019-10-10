<?php 
   require_once("../config/conexion.php");
    if(isset($_SESSION["id_usuario"])){
      isset($_GET["id_capacitacion"]);

      require_once("../modelos/Capacitaciones.php");
      require_once("../modelos/DetalleCapacitados.php");
      $capacitaciones = new Capacitaciones();
      $detalleCapacitados = new DetalleCapacitados();
?>

<?php
  require_once("header.php");
?>
  <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
             <div id="resultados_ajax"></div>
             <h2>Registro de Capacitaciones</h2>
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                      <h1 class="box-title" ><label id="letra">Capacitacion</label></h1>
                      <h1 class="box-title" ><label id="letra1">Listado de Capacitados</label></h1>
                          <h1 class="box-title">
                            <button class="btn btn-primary btn-lg" id="add_button" onclick="mostrarformulario(true)"   data-target="#capacitacionModal"><i class="fa fa-plus" aria-hidden="true"></i> Registrar Capacitacion</button></h1>
                        <div class="box-tools pull-right"></div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                          <table id="capacitacion_data" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                <th width="12%">No Capacitacion</th>
                                <th>Fecha</th>
                                <th>Nombre del Grupo</th>
                                <th>Cargo</th>
                                <th>Encargado</th>
                                <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                          </table>
                    </div>
                    <!--Fin centro -->
          
                    <div class="panel-body table-responsive" id="capacitacionModal" >
                      <form name="formulario" id="capacitacion_form"style="width: 70%;" method="POST">

                        <div class="form-group table-responsive">
                          <label for="" class="col-lg-3 control-label">Fecha:</label>
                          <div class="col-lg-9">
                            <input type="text" name="fecha" id="fecha" class="form-control" placeholder="Fecha" required style="width:50%;"/>
                          </div>
                        </div> 

                        <div class="form-group table-responsive">
                          <label for="" class="col-lg-3 control-label">Nombre de Grupo:</label>
                          <div class="col-lg-9">
                            <input type="text" name="nombreGrupo" id="nombreGrupo" class="form-control" placeholder="Nombre de Grupo" required style="width:50%;"/>
                          </div>
                        </div>

                        <div class="form-group table-responsive">
                          <label for="" class="col-lg-3 control-label">Encargado:</label>
                          <div class="col-lg-9">
                            <input type="text" name="encargado" id="encargado" class="form-control" placeholder="Nombre del Encargado" required style="width:50%;"/>
                          </div>  
                        </div> 

                        <div class="form-group table-responsive">
                          <label for="" class="col-lg-3 control-label">Cargo:</label>
                          <div class="col-lg-9">
                            <input type="text" name="cargo" id="cargo" class="form-control" placeholder="Cargo del Encargado" required style="width:50%;"/>
                          </div> 
                        </div> 

                        <div class="form-group table-responsive">

                          <div class="form-group table-responsive" id="numcapacitacion">
                            <label for="" class="col-lg-3 control-label">No Capacitacion:</label>
                            <div class="col-lg-9">
                              <input type="show" name="id_capacitacion" id="id_capacitacion" value="<?php echo $_GET["id_capacitacion"];?>" equired style="width:10%;" readonly="readonly"/>
                            </div> 
                          </div> 
                          
                          <button class="btn btn-primary" name ="Guardar" type="submit" id="btnGuardarCap"><i class="fa fa-save"></i> Registrar Capacitacion</button>

                          <button id="btnCancelar" class="btn btn-danger" type="button"><i class="fa fa-arrow-circle-left"></i> <a href="capacitaciones.php"><font color=white>Cancelar</font></a></button>
                          
                          <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_usuario"];?>" />
                          
                        </div>

                      </form> 

                    </div> <!-- /.col -->

                          <div class="panel-body table-responsive" id="capacitadosModal">
            
                            <!-- <h4 class="box-title" ><label>Listado de Capacitados</label></h4> -->

                              <button  id="btnAgregarCap" type="button" class="btn btn-primary" data-toggle="modal"data-target="#detallecapacitadosModal"><span class="fa fa-plus"></span> Agregar Capacitado</button>

                            <table id="detallecapacitados_data" class="table table-bordered table-striped">
                              <thead>
                                  <tr>
                                  <th width="12%">No Capacitacion</th>
                                  <th>Nombre</th>
                                  <th>Apellido</th>
                                  <th>Contacto</th>
                                  <th>Procedencia</th>
                                  <th>Acciones</th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>

                            <button id="btnCancelar" class="btn btn-danger" type="button"><i class="fa fa-arrow-circle-left"></i> <a href="capacitaciones.php"><font color=white>Cancelar</font></a></button>
                            <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_usuario"];?>" />
                          </div>
                    <!--Fin centro -->

                         
                    <!-- </div>  --> <!-- /.panel-body -->
                 <!--  </div> --> <!-- /.row -->
                </div>
              </div>
            </div>
          </section><!-- /.content -->
        </div>

  <!--Fin-Contenido-->
    <!--FORMULARIO VENTANA MODAL-->
  <div id="detallecapacitadosModal" class="modal fade">
  <div class="modal-dialog">
    <form method="post" id="detallecapacitados_form">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Capacitado</h4>
        </div>

          <!--- codigo para mostrar calendario jquery IU -->
          <script>
          $( function() {
            $( "#fecha" ).datepicker();
          } );
          </script>
          <!--- fin codigo para mostrar calendario jquery IU -->
        
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Nombres</label>
            <input type="text" name="nombres" id="nombres" class="form-control" placeholder="Nombres" required/>
          </div>
          <div class="form-group col-md-6">
            <label>Apellidos</label>
            <input type="text" name="apellidos" id="apellidos" class="form-control" placeholder="Apellidos" required/>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Contacto</label>
            <input type="text" name="contacto" id="contacto" class="form-control" placeholder="contacto" required/>
          </div>
          <div class="form-group col-md-6">
            <label>Procedencia</label>
            <input type="text" name="procedencia" id="procedencia" class="form-control" placeholder="Procedencia" required/>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-12">
              <label>No Capacitacion:</label> 
                <input type="show" name="id_capacitacion" id="id_capacitacion" value="<?php echo $_GET["id_capacitacion"];?>" equired style="width:10%;"/>
          </div> 
        </div>

        <div class="modal-footer">
          <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_usuario"];?>" />
          <input type="hidden" name="id_detallecapacitados" id="id_detallecapacitados"/>
          <button type="submit" name="action" id="btnGuardarDet" class="btn btn-success pull-left" value="Add"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
          <button type="button" onclick="limpiar()" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button>
        </div>
      </div>
    </form>
  </div>
</div>
 <!--FIN FORMULARIO VENTANA MODAL-->

<?php
  require_once("footer.php");
?>
<script type="text/javascript" src="js/capacitaciones.js"></script>

<?php
  } else {
        header("Location:".Conectar::ruta()."vistas/index.php");
  }
?>

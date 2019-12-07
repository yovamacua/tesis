<?php
  #incluyendo conexion
   require_once("../config/conexion.php");
   #verficando si existe sessión
    if(isset($_SESSION["id_usuario"])){
    #variable de item activo
   $activar = 'item_partidas';
    #incluyendo header
     require_once("header.php");
   ?>
      <?php if($_SESSION["Partidas"]==1)
     {

     ?>
<!--Contenido-->

<!-- funcion para cargar la sumatoria al cargar la pagina -->
<script type="text/javascript">
$(document).ready(function() {  
function recargar(){   
    $.post("../modelos/actions_table/sumatoria-total-partida.php", function(data){
        //// Verificamos la rpta entregada por miscript.php
            $("#recargado").html(data); 
    });        
}
    setTimeout(recargar, 1000);
}); 
</script>

<!-- funcion que actualiza la sumatoria al activar o desactivar año -->
<script type="text/javascript">
function recargar(){   
    $.post("../modelos/actions_table/sumatoria-total-partida.php", function(data){
        //// Verificamos la rpta entregada por miscript.php
            $("#recargado").html(data); 
    });   
    setTimeout(recargar, 1000);  
    //setInterval(recargar, 1000);   
}
</script>

<div class="content-wrapper">
   <section class="content-header">

      <h1>Administración de Partidas</h1>

    <!-- migas de pan-->
      <ol class="breadcrumb">
         <li><a href="home.php"><i class="fa fa-home"></i>Inicio</a></li>
         <li><i class="fa fa-file-text-o"></i> Partidas</li>
      </ol>
   
   </section>

   <section class="content">
    <!-- mostrando resultados -->
      <div id="resultados_ajax"></div>

      <div class="row">
         <div class="col-md-12">
            <div class="box">
               <div class="box-header boton-top">
                  <h1 class="box-title">

                     <button class="btn btn-primary btn-lg" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#partidaModal"><i class="fa fa-plus" aria-hidden="true"></i> Registrar partida</button>
                     <div id="sumtop" style="display: inherit;"><b>Total($): </b> 
<span id="recargado" style="background: #dd4b39;color: white;padding: 0.5rem 1rem;"></span>&nbsp;
<!--<span><a href="#" onclick="javascript:recargar();">Actualizar</a></span> -->
</div>
                  </h1>
                  <div class="box-tools pull-right">
                </div>
               </div>

               <!-- centro -->
               <div class="panel-body table-responsive tabla-top">

                <!-- tabla con información --->
                  <table id="partida_data" class="table table-bordered table-striped ">
                     <thead>
                        <tr>
                           <th width="25%">Nombre Partida</th>
                           <th width="15%">Responsable</th>
                           <th width="5%">Año</th>
                            <th width="5%">Total ($)</th>
                           <th width="25%" style="background: white!important; pointer-events: none;">Administrar Cuentas</th>
                             <?php  if($_SESSION["Eliminar"]==0 and $_SESSION["Editar"]==0){
                              
                              }else{
                                  echo '<th width="10%">Acciones</th>';
                              }
                                ?>
                        </tr>
                     </thead>
                     <tbody>
                     </tbody>
                  </table>
               </div>
               <!--Fin centro -->
            </div>
         </div>
      </div>
   </section>
</div>
<!--Fin-Contenido-->

<!--FORMULARIO VENTANA MODAL-->
<div id="partidaModal" class="modal fade">
   <div class="modal-dialog">
  <!--- formulario --->
      <form method="post" id="partida_form" autocomplete="off">
         <div class="modal-content">
            <div class="modal-header">

               <button type="button" class="close" data-dismiss="modal">&times;</button>

               <h4 class="modal-title">Agregar Partida</h4>

            </div>
            <div class="modal-body">

               <div class="form-group col-md-12">
                  
                 
               <label>Nombre Partida*</label>
               <input type="text" maxlength="50" name="nombrepartida" id="nombrepartida" class="form-control" placeholder="Nombre Partida" required/>
               <span class="error_form" id="error_nombrepartida"></span>

               </div>

               <div class="form-group col-md-12">

                   <label>Responsable*</label>
               <input type="text" name="responsable" id="responsable" class="form-control" maxlength="50" placeholder="Responsable" required/>
               <span class="error_form" id="error_responsable"></span>
               </div>


              <div class="form-group col-md-12">
              <label>Año</label>
              <select name="anio" id="anio" class="form-control" required="required">';<?php
              for($year=date('Y')-5; $year<=date('Y')+5; $year++){
                if($year == date('Y')){
                  echo '<option value="'.$year.'" selected>'.$year.'</option>';
                    }else{
                  echo '<option value="'.$year.'">'.$year.'</option>';
                  }
              }
              ?></select>
               </div>

                - Los campos con * (asterisco) son obligatorios
               <br/>

            </div>
            <div class="modal-footer">

               <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_usuario"];?>" />

               <input type="hidden" name="id_partida" id="id_partida"/>

               <button type="submit" name="action" id="btnGuardar" class="btn btn-success pull-left" onclick="desvanecer(); recargar()" value="Add"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>

               <button type="button" onclick="limpiar()" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button>

            </div>
         </div>
      </form>
   </div>
</div>
<!--FIN FORMULARIO VENTANA MODAL-->
 <?php  } else {

       require("noacceso.php");
  }
   
  ?><!--CIERRE DE SESSION DE PERMISO -->
<?php
#incluye footer
   require_once("footer.php");
   ?>
<script type="text/javascript" src="js/partidas.js"></script>
<?php
} else {
  #redirecciona si sessión no existe
header("Location:".Conectar::ruta()."vistas/index.php");
}
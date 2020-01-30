<?php
  #incluyendo conexion
   require_once("../config/conexion.php");
   require_once("../modelos/Roles.php");
   #validando que exista la session
    if(isset($_SESSION["id_usuario"])){
  #variable para mostrar como item activo
       $usuario = new Roles();
   $activar = 'item_incidentes';
   $activar1 = 'item_incidentes1';
   #incluyendo header
     require_once("header.php");
   ?>
 <?php if($_SESSION["INCIDENTES"]==1)
     {

     ?>
<!-- estilo sencillo -->
<style type="text/css">
.showbreak tbody tr td:nth-child(2){white-space: pre!important;}
</style>

<!--Contenido-->
<div class="content-wrapper">

   <section class="content-header">

      <h1>Administración de Incidentes</h1>
    
    <!-- migas de pan -->
      <ol class="breadcrumb">
         <li><a href="home.php"><i class="fa fa-home"></i>Inicio</a></li>
         <li><i class="fa fa-book"></i> Incidentes</li>
      </ol>

   </section>

   <!-- contenido principal -->
   <section class="content">

       <!-- vista de mensaje  -->
      <div id="resultados_ajax"></div>
      <div class="row">
         <div class="col-md-12">
            <div class="box">
               <div class="box-header boton-top">
                  <h1 class="box-title">
                      <!--- boton nuevo registro -->
                      <?php  

$rol=$usuario->listar_roles_por_usuario($_SESSION['id_usuario']);
                            $valores=array();
                            //Almacenamos los permisos marcados en el array
                             foreach($rol as $rows){

                             $valores[]= $rows["codigo"];
                                }   
                                if(in_array("REINCI",$valores)){
                                  echo '<button class="btn btn-primary btn-lg" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#incidenteModal"><i class="fa fa-plus" aria-hidden="true"></i> Registrar Incidente</button>';
              }

                      ?>
                     

                  </h1>
                  <div class="box-tools pull-right">
                  </div>
               </div>

               <!-- centro -->
               <div class="panel-body table-responsive tabla-top">

                <!--- tabla con la informacion -->
                  <table id="incidente_data" class="table table-bordered table-striped showbreak">
                     <thead>
                        <tr>
                           <th width="20%">Titulo</th>
                           <th width="30%">Descripción</th>
                           <th width="10%">Autor</th>
                           <th width="15%">Fecha Incidente</th>
                           <th width="15%">Acciones</th>
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
<div id="incidenteModal" class="modal fade">
   <div class="modal-dialog">

      <!-- formulario -->
      <form method="post" id="incidente_form" autocomplete="off">
        
         <div class="modal-content">
            <div class="modal-header">
               
               <button type="button" class="close" data-dismiss="modal">&times;</button>

               <h4 class="modal-title">Agregar Incidente</h4>
            </div>

            <div class="modal-body">
               
               <label>Titulo*</label>
               <input type="text" maxlength="50" name="titulo" id="titulo" class="form-control" placeholder="Titulo" required/>
               <span class="error_form" id="error_titulo"></span>
               <br />

               <label>Descripción*</label>
               <textarea rows="4" maxlength="250" style=" word-break: break-all;    max-width: 100% !important;" cols="250" name="descripcion" id="descripcion" class="form-control" placeholder="Descripción" required/></textarea>
               <span class="error_form" id="error_descripcion"></span>
               <br />

               <label>Fecha*</label>
               <input type="text" name="fecha" id="fecha" autocomplete="off" class="form-control" placeholder="Fecha" required/>
               <span class="error_form" id="error_fecha"></span>
               <br />

               - Los campos con * (asterisco) son obligatorios
               <br/>
               
            </div>

            <div class="modal-footer">
               
               <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_usuario"];?>" />

               <input type="hidden" name="id_incidente" id="id_incidente"/>
               
               <button type="submit" name="action" id="btnGuardar" class="btn btn-success pull-left" onclick="desvanecer()" value="Add"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>

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
  #incluyendo footer
   require_once("footer.php");
   ?>
<script type="text/javascript" src="js/incidentes.js"></script>
<?php
   } else {
    #redireccion si no existe sessión
         header("Location:".Conectar::ruta()."vistas/index.php");
   }
   ?>
<?php
  #incluyendo conexion
   require_once("../config/conexion.php");
   require_once("../modelos/Roles.php");
    if(isset($_SESSION["id_usuario"])){
 $usuario = new Roles();
      //validar que no viene vacio o redirecciona
      if (isset($_GET['id']) and isset($_GET['partida'])) {
      $identificador = $_GET['id'];
      $partida = $_GET['partida'];

      #vacia la sessiones
      unset( $_SESSION["seleccion_partida"] ); 
      unset( $_SESSION["nombre_partida"] ); 

      #asigna valor a las sessiones
      $_SESSION["seleccion_partida"] = $identificador;
      $_SESSION["nombre_partida"] = $partida;
     }else{
      #redirecciona a partidas si no recibe toda la informacion
       $redireccion = Conectar::ruta()."vistas/partidas.php"; ?>

<script type="text/javascript">
  bootbox.alert("Información insuficiente");
   self.location = '<?php echo $redireccion; ?>'
</script>

<?php
  }
  #variable item activo
    $activar = 'item_partidas';
  #incluye header
   require_once("header.php");
    ?>
<?php if($_SESSION["PARTIDAS"]==1)

     {

     ?>
<!--Contenido-->


<!-- funcion para cargar la sumatoria al cargar la pagina -->
<script type="text/javascript">
$(document).ready(function() {  
function recargar2(){   
    $.post("../modelos/actions_table/sumatoria-total-cuenta-entrada.php", function(data){
        //// Verificamos la rpta entregada por miscript.php
            $("#recargado2").html(data); 
    });        
}
    setTimeout(recargar2, 1000);
}); 
</script>

<!-- funcion que actualiza la sumatoria al activar o desactivar año -->
<script type="text/javascript">
function recargar2(){   
    $.post("../modelos/actions_table/sumatoria-total-cuenta-entrada.php", function(data){
        //// Verificamos la rpta entregada por miscript.php
            $("#recargado2").html(data); 
    });   
    setTimeout(recargar2, 1000);  
    //setInterval(recargar, 1000);   
}
</script>

<div class="content-wrapper">
   <section class="content-header">
      
      <h1>Cuentas asociadas a la partida: <b><?php echo $partida;?></b></h1>

      <!--- migas de pan -->
      <ol class="breadcrumb">
         <li><a href="home.php"><i class="fa fa-home"></i>Inicio</a></li>
         <li><a href="partidas.php"><i class="fa fa-file-text-o"></i> Partidas</a></li>
         <li><i class="fa fa-clipboard"></i> Cuentas</li>
      </ol>

   </section>
   <!-- Contenido -->
   <section class="content">
    <!--- ventana de mensajes -->
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
                                if(in_array("REPART",$valores)){
                                  echo '<button class="btn btn-primary btn-lg" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#cuentaModal"><i class="fa fa-plus" aria-hidden="true"></i> Agregar una cuenta</button>';
              }
                            ?>
                     
                     <div id="sumtop" style="display: inherit;"><b>Total($): </b> 
<span id="recargado2" style="font-weight: bold"></span>&nbsp;
<!--<span><a href="#" onclick="javascript:recargar2();">Actualizar</a></span> -->
</div>
                  </h1>

                  <div class="box-tools pull-right">
                  </div>
               </div>

               <!-- centro -->
               <div class="panel-body table-responsive tabla-top">

                <!-- tabla con la informacion -->
                
                  <table id="cuenta_data" class="table table-bordered table-striped noarrows2">
                     <thead>
                        <tr>
                           <th width="15%">Nombre cuenta</th>
                           <th width="20%">Objetivo</th>
                           <th width="20%">Estrategia</th>
                           <th width="10%">Total ($)</th>
                           <th width="10%" style="background: white!important; pointer-events: none;">Cuenta</th>
                           <th width="20%">Acciones</th>
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
<div id="cuentaModal" class="modal fade">
   <div class="modal-dialog">

    <!-- formulario -->
      <form method="post" id="cuenta_form" autocomplete="off">
         <div class="modal-content">
            <div class="modal-header">

               <button type="button" class="close" data-dismiss="modal">&times;</button>

               <h4 class="modal-title">Agregar cuenta</h4>

            </div>
            <div class="modal-body">

               <label>Nombre de la cuenta*</label>
               <input type="text" name="nombrecuenta" id="nombrecuenta" class="form-control" maxlength="50" placeholder="Titulo" required/>
               <span class="error_form" id="error_nombrecuenta"></span>
               <br />

               <label>Objetivo*</label>
               <input type="text" maxlength="150" name="objetivo" id="objetivo" class="form-control" placeholder="Objetivo" required/>
               <span class="error_form" id="error_objetivo"></span>
               <br />

               <label>Estrategia*</label>
               <input type="text" maxlength="150" name="estrategia" id="estrategia" class="form-control" placeholder="Estrategia" required/>
               <span class="error_form" id="error_estrategia"></span>
               <br />

               - Los campos con * (asterisco) son obligatorios
               <br/>

            </div>
            <div class="modal-footer">

               <input type="hidden" name="id_partida" id="id_partida" value="<?php echo $identificador; ?>" />

               <input type="hidden" name="id_cuenta" id="id_cuenta"/>

               <button type="submit" name="action" id="btnGuardar" class="btn btn-success pull-left" value="Add"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>

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
#incluendo archivo del footer
   require_once("footer.php");
   ?>
<script type="text/javascript" src="js/cuentas.js"></script>
<?php
   } else {
    #redirecciona si la session no existe
         header("Location:".Conectar::ruta()."vistas/index.php");
   }
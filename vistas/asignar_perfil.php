<?php
   require_once("../config/conexion.php");
    require_once("../modelos/Perfiles.php");
    require_once("../modelos/Modulos.php");
    if(isset($_SESSION["id_usuario"])){
    //validar que no viene vacio o redirecciona
    $perfil= new Perfiles();
    $objmodul= new Modulos();
      if (isset($_GET['id'])) {
      $identificador = $_GET['id'];


      #vacia la sessiones
      unset( $_SESSION["idperfil"] ); 

      #asigna valor a las sessiones
      $_SESSION["idperfil"] = $identificador;
     }else{
      #redirecciona a partidas si no recibe toda la informacion
       $redireccion = Conectar::ruta()."vistas/perfilese.php"; ?>

?>
<?php
  }
  #variable item activo
  $activar = 'item_categorias';
  require_once("header.php");
?>
<?php if($_SESSION["PERMISO"]==1)
     {

     ?>

  <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <section class="content-header">
 
          <h1>Listado de Modulo</h1>

          <!-- migas de pan-->
          <ol class="breadcrumb">
             <li><a href="home.php"><i class="fa fa-home"></i>Inicio</a></li>
             <li><i class="fa fa-users"></i> Perfiles</li>
          </ol>
   
        </section>
        <!-- Main content -->
        <section class="content">
             <div id="resultados_ajax"></div>
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <!-- /.box-header -->
                    <!-- centro -->
  
              
 <form method="post" id="asignar_form">
       <div class="form-group table-responsive">
        <div class="modal-body">
   <?php		
$datos=$perfil-> get_perfil_por_id( $identificador);
   $modulo=$objmodul->mostrar_modulo();
          // si existe el id del incidnete entonces recorre el array

        if(is_array($datos)==true and count($datos)>0){
        
            foreach($datos as $row)
            {

       
        echo'<h3>Asignacion de modulos de perfil:'.$row["nombre"].'</h3>';
      }
    }
    ?>
    <table class="table table-striped table-bordered table-condensed table-hover">
    	<thead>
         <tr>
            <th>Modulo</th>
         </tr>
      </thead> 
        	<tbody>
   
   <?php
   $valores=array();
  

      foreach ($modulo as $rows) {
  //echo '<ul><li>'.$rows["idmodulo"].'></li></ul>';
  $output["idmodulo"]=$rows["idmodulo"];
                $output["nombre"]=$row["nombre"];
                 $ver=$perfil->ver_asignacion($rows["idmodulo"], $identificador); 
                  foreach ($ver as $mod) {
       $valores[]=$mod["id_modulo"];
      } 
      $sw = in_array($rows['idmodulo'],$valores) ? 'checked':'';

                 echo '
              <tr>
              <td>'.$rows["nombre"].'</td>
           <td>
            <ul>   
     <input type="checkbox" '.$sw.' name="modulo[]"  value="'.$rows["idmodulo"].' required=""">
    

 </td>
 <tr>';
  } 
  ?>
        </div>
       </tbody>
       </table> 
       
           <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
           <input type="hidden" name="idperfil" id="idperfil" value="<?php echo  $identificador;?>" />
                            <button class="btn btn-primary" name ="Guardar" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button id="btnCancelar" class="btn btn-danger"  type="button" onclick="cancelar()"><i class="fa fa-arrow-circle-left"></i> Cerrar</button>
    
      </div>
    </form>
<!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
    <!--FORMULARIO VENTANA MODAL-->

  </div>
</div>
 <!--FIN FORMULARIO VENTANA MODAL-->
<?php  } else {

       require("noacceso.php");
  }
   
  ?><!--CIERRE DE SESSION DE PERMISO -->
<?php
  require_once("footer.php");
?>
<script type="text/javascript" src="js/asignar_perfil.js"></script>
<?php
  } else {
        header("Location:".Conectar::ruta()."vistas/index.php");
  }
?>

<?php

   require_once("../config/conexion.php");
   require_once("../modelos/Roles.php");

    if(isset($_SESSION["id_usuario"])){

      require_once("../modelos/Categorias.php");
         $categoria = new Categorias();
           $usuario = new Roles();

       $cat = $categoria->get_categoria();

?>


<!-- INICIO DEL HEADER - LIBRERIAS -->
<?php 
#variable para mostrar como item activo
$activar = 'item_reporteVenta';
$activar3 = 'item_reporteVenta3';
require_once("header.php");?>

<!-- FIN DEL HEADER - LIBRERIAS -->
<?php if($_SESSION["VENTA"]==1)
     {

     ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">


   <div >
   <H2 class="reporte_compras_general container-fluid bg-red text-white col-lg-12 text-center mh-50">
        
           Reporte de ventas semanal
  </div>
   

  
 <div class="panel panel-default">
        
        <div class="panel-body">

   <div class="row  col-sm-5 col-sm-offset-3">
        
        <div class="">

            <form action="reportes/reporte_ventas_Semanal_excel.php" method="post">

                   <div class="form-group">
                <label for="inputPassword">Fecha Inicial</label>
               
                  <input type="text" class="form-control" id="fecha" name="fecha" autocomplete="off" placeholder="Fecha Inicial" style="width:50%"/>
              
              </div>


              <div class="form-group">
                <label for="inputPassword">Fecha Final</label>
               
                  <input type="text" class="form-control" id="fecha2" name="fecha2" autocomplete="off" placeholder="Fecha Inicial" style="width:50%"/>
              
              </div>


            <div class="form-group">

               <label for="inputPassword" >Categoria</label>
                 
                 <select name="categoria" id="categoria" class="form-control" style="width:50%">
                          
                <option value="0">SELECCIONE</option>

                  
                 <?php

                           for($i=0; $i<sizeof($cat);$i++){
                             
                             ?>
                              <option value="<?php echo $cat[$i]["id_categoria"]?>"><?php echo $cat[$i]["categoria"];?></option>
                             <?php
                           }
                        ?>

                 
                                 
                 </select>
            </div>
  <?php 
                             $rol=$usuario->listar_roles_por_usuario($_SESSION['id_usuario']);
                            $valores=array();
                            //Almacenamos los permisos marcados en el array
                             foreach($rol as $rows){

                             $valores[]= $rows["codigo"];
                                }   
                                if(in_array("COREPO",$valores)){
                                  echo '<button type="submit" class="btn btn-primary">CONSULTAR</button>';
              }
                            ?>
             
            
            
           </form>

       </div>
      </div>

    </div>
</div>

  


</div>
  <!-- /.content-wrapper -->

 <?php  } else {

       require("noacceso.php");
  }
   
  ?><!--CIERRE DE SESSION DE PERMISO -->  
   <?php require_once("footer.php");?>

  
<?php
   }

?>
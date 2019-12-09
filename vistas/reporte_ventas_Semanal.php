<?php

   require_once("../config/conexion.php");

    if(isset($_SESSION["id_usuario"])){

      require_once("../modelos/Categorias.php");
         $categoria = new Categorias();

       $cat = $categoria->get_categoria();

?>


<!-- INICIO DEL HEADER - LIBRERIAS -->
<?php 
#variable para mostrar como item activo
$activar = 'item_reporteVenta';
$activar3 = 'item_reporteVenta3';
require_once("header.php");?>

<!-- FIN DEL HEADER - LIBRERIAS -->
<?php if($_SESSION["Venta"]==1)
     {

     ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">


   <div >
   <H2 class="reporte_compras_general container-fluid bg-red text-white col-lg-12 text-center mh-50">
        
           REPORTE DE VENTAS  SEMANAL
  </div>
   

  
 <div class="panel panel-default">
        
        <div class="panel-body">

   <div class="row  col-sm-5 col-sm-offset-3">
        
        <div class="">

            <form action="reportes/reporte_ventas_Semanal_excel.php" method="post">

                   <div class="form-group">
                <label for="inputPassword">Fecha Inicial</label>
               
                  <input type="date" class="form-control" id="fecha" name="fecha" placeholder="Fecha Inicial" style="width:50%"/>
              
              </div>


              <div class="form-group">
                <label for="inputPassword">Fecha Final</label>
               
                  <input type="date" class="form-control" id="fecha2" name="fecha2" placeholder="Fecha Inicial" style="width:50%"/>
              
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

             <button type="submit" class="btn btn-primary">CONSULTAR</button>
            
            
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
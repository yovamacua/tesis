<?php

   require_once("../config/conexion.php");

    if(isset($_SESSION["id_usuario"])){

    

?>


<!-- INICIO DEL HEADER - LIBRERIAS -->
<?php require_once("header.php");?>

<!-- FIN DEL HEADER - LIBRERIAS -->

<?php if($_SESSION["Reporte Financiero"]==1)

     {

     ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">


   <div >
   <H2 class="reporte_compras_general container-fluid bg-red text-white col-lg-12 text-center mh-50">
        
           REPORTE FINANCIEROS
  </div>
   

  
 <div class="panel panel-default">
        
        <div class="panel-body">

   <div class="row  col-sm-5 col-sm-offset-3">
        
        <div class="">

            <form action="reportes/reporte_financiero_excel.php" method="post">

                   <div class="form-group">
                <label for="inputPassword">Fecha Inicial</label>
               
                  <input type="text" class="form-control" id="fecha" name="fecha" placeholder="Fecha Inicial" style="width:50%"/>
              
              </div>


              <div class="form-group">
                <label for="inputPassword">Fecha Final</label>
               
                  <input type="text" class="form-control" id="fecha2" name="fecha2" placeholder="Fecha Final" style="width:50%"/>
              
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
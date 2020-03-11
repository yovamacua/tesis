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

  <div class="content-wrapper">
        <section class="content-header">

          <h1>Reporte</h1>

          <!-- migas de pan-->
          <ol class="breadcrumb">
             <li><a href="inicio.php"><i class="fa fa-home"></i>Inicio</a></li>
             <li><i class="fa fa-file-text"></i> Venta Semanal</li>
          </ol>
   
        </section>
        <!-- Main content -->
        <section class="content">
             <div id="resultados_ajax"></div>
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                   
                       <div >
   <H2 class="reporte_compras_general container-fluid bg-red text-white col-lg-12 text-center mh-50">
        
           Reporte de ventas semanal
  </div>
            
                   
          <div class="panel-body table-responsive tabla-top">
            

             <div class="form-row">       
       <div class="row  col-sm-5 col-sm-offset-3">

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
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->
  </div><!-- /.content-wrapp

 <?php  } else {

       require("noacceso.php");
  }
   
  ?><!--CIERRE DE SESSION DE PERMISO -->  
   <?php require_once("footer.php");?>

  
<?php
   }

?>
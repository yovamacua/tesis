<?php

   require_once("../config/conexion.php");


    if(isset($_SESSION["id_usuario"])){

      require_once("../modelos/Categorias.php");
         require_once("../modelos/Unidad.php");
         require_once("../modelos/Roles.php");

      $categoria = new Categorias();
        $unidad = new Unidad();
         $usuario = new Roles();

      $cat = $categoria->get_categoria();  
      $unid= $unidad->get_unidad()   
       
?>

<?php
  #variable item activo
  $activar = 'item_productos';
  require_once("header.php");

?>
<?php if($_SESSION["PRODUCTO"]==1)
     {

     ?>
  <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content-header">

          <h1>Administración de Productos</h1>

          <!-- migas de pan-->
          <ol class="breadcrumb">
             <li><a href="home.php"><i class="fa fa-home"></i>Inicio</a></li>
             <li><i class="fa fa-lemon-o"></i> Producto</li>
          </ol>
   
        </section>
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
                                if(in_array("REPROD",$valores)){
                                  echo '<button class="btn btn-primary btn-lg" id="add_button" onclick="limpiar()" data-toggle="modal" data-target="#productoModal"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo Producto</button>';
              }
                            ?>
                            </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive tabla-top">
                          
                          <table id="producto_data" class="table table-bordered table-striped">

                            <thead>
                              
                                <tr>
                                <th width="5%">Producto</th>
                                <th width="5%">Unid. Medida</th>
                                <th width="5%">Precio Venta</th>
                                <th width="5%">Categoría</th>
                                <th width="5%">Stock</th>
                               <th width="5%">Acciones</th>
                              
                                </tr>
                            </thead>

                            <tbody>
                              
                            </tbody>

                          </table>
                     
                    </div>
                  
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
    
 <!--FORMULARIO VENTANA MODAL-->
  
<div id="productoModal" class="modal fade">
  <div class="modal-dialog">
    <form method="post" id="producto_form">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Producto</h4>
        </div>
         <div class="modal-body">

                  <label>Categoría</label>
                    <!--<input type="text" class="form-control" id="categoria" name="categoria" placeholder="Categoria">-->

                    <select class="form-control" id="categoria" name="categoria" >

                      <option  value="0">Seleccione</option>

                        <?php

                           for($i=0; $i<sizeof($cat);$i++){
                             
                             ?>
                              <option value="<?php echo $cat[$i]["id_categoria"]?>"><?php echo $cat[$i]["categoria"];?></option>
                             <?php
                           }
                        ?>
                      
                    </select>
                  <span class="error_form" id="error_categoria"></span>
                  </br>
                  <label>Producto</label>
                   <input type="text" id="producto" name="producto"   class="form-control" placeholder="Descripción Producto" maxlength="60" autocomplete="off" required/>
                   <span class="error_form" id="error_producto"></span>
                   </br>
                   <label>Unidad</label>
                   <select class="form-control" id="id_unidad" name="id_unidad" >

                      <option  value="0">Seleccione</option>

                        <?php

                           for($i=0; $i<sizeof($unid);$i++){
                             
                             ?>
                              <option value="<?php echo $unid[$i]["idunidad"]?>"><?php echo $unid[$i]["nombre"];?></option>
                             <?php
                           }
                        ?>
                      
                    </select>
                     <span class="error_form" id="error_unidad"></span>
                  </br>

                  <label>Precio Venta</label>
                  <input type="text" class="form-control" id="precio_venta" name="precio_venta"  placeholder="Precio Venta" maxlength="4" autocomplete="off" required />
                   <span class="error_form" id="error_precio"></span>
                </br>
                  <label>Stock</label>
                    <input type="text" class="form-control" id="stock" name="stock" maxlength="4" autocomplete="off" required/>
                     <span class="error_form" id="error_stock"></span>
               </br>
             
          <div class="modal-footer">
          <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["id_usuario"];?>"/>
          <input type="hidden" name="id_producto" id="id_producto"/>

          
          <button type="submit" name="action" id="btnGuardar" class="btn btn-success pull-left" value="Add"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar </button>

          <button type="button" onclick="limpiar()" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button>
           </div><!--modal-footer-->
      </div>
     </div>
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

<script type="text/javascript" src="js/productos.js"></script>

<?php
   
  } else {

        header("Location:".Conectar::ruta()."vistas/index.php");

  }

?>


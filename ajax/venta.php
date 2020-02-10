<?php 
//llamo a la conexion de la base de datos 
  require_once("../config/conexion.php");
  //llamo al modelo Producto
  require_once("../modelos/Venta.php");
  require_once("mensajes.php");
  require_once("../modelos/Productos.php");
   require_once("../modelos/Roles.php");
 if (!isset($_SESSION['id_usuario'])) {?>
        <script type="text/javascript">
        window.location="../vistas/home.php";
        </script>
    <?php
}
 
  $productos = new Producto();
  $venta = new Ventas();
   $usuario = new Roles();

 $id_usuario = isset($_POST["id_usuario"]);
 $estado=isset($_POST["estado"]);
 $idventas=isset($_POST["idventas"]);
$numero_venta=isset($_POST["numero_venta"]);
$total_pagar=isset($_POST["total_pagar"]);
$id_producto=isset( $_POST["id_producto"]);
$precio_venta=isset( $_POST["precio_venta"]);
$fechaventa=isset($_POST["fecha"]);
$cantidad=isset( $_POST["cantidad"]);

   switch($_GET["op"]){
   case "guardaryeditar":
 if ($_POST["fecha"] == '') {
            $errors[] = "Formatos de Información no validos";
            echo error($errors);
        } else {
      /*verificamos si existe el producto en la base de datos, si ya existe un registro con la categoria entonces no se registra la categoria*/
      
      //importante: se debe poner el $_POST sino no funciona
       $datos = $venta->get_venta_por_id($_POST["idventas"]);

    
             /*si el id no existe entonces lo registra
             importante: se debe poner el $_POST sino no funciona*/
            if(empty($_POST["idventas"])){

            /*verificamos si existe el producto en la base de datos, si ya existe un registro con la categoria entonces no se registra*/

                 if(is_array($datos)==true and count($datos)==0){

                    //no existe el producto por lo tanto hacemos el registros

      $venta->registro_ventas($total_pagar,$numero_venta,$id_usuario,$_POST["id_producto"], $_POST["cantidad"],$_POST["precio_venta"],$_POST["fecha"]);



                    $messages[]="La venta se realizo existosamente";

                 } //cierre de validacion de $datos 


                    /*si ya existe el producto entonces aparece el mensaje*/
                      else {

                          $errors[]="la venta no se realizo";
                      }

          }//cierre de empty

}
     //mensaje success
     if (isset($messages)){
        echo exito($messages);
      }
   //fin success

   //mensaje error
         if (isset($errors)){
      
      echo error($messages);
      }

   //fin mensaje error


     break;
   	case "listar":

     $datos=$venta->getventas();
     $rol=$usuario->listar_roles_por_usuario($_SESSION['id_usuario']);
      $valores=array();

      //Almacenamos los permisos marcados en el array
foreach($rol as $rows){

              $valores[]= $rows["codigo"];
          }
 	 $data= Array();

    	foreach ($datos as $row) {
 			$sub_array = array();
       if($row["estado"] == 1){
            $est = 'ACEPTADO';
            $atrib = '<span class="label bg-green">Aceptado</span>';
             ?>
         <?php  
         $button_mostrar='<button class="btn btn-warning" onclick="mostrar('.$row["idventas"].')"><i class="fa fa-eye"></i></button>&nbsp;';
          $button_eliminar='<button class="btn btn-danger" onClick="anularventa('.$row["idventas"].','.$row["estado"].');" name="estado" id="'.$row["idventas"].'" class="btn btn-danger btn-md fa fa-close">Anular</button>';
          if(in_array("ELVENT",$valores)){
                 $sub_array[]='<div class="cbtns">'.$button_mostrar.''.$button_eliminar.'</div>';
              } else {
                 $sub_array[]='<div class="cbtns">'.$button_mostrar.'</div>';
              }

              
      ?>
          <?php 
             
          }else{
                $est = 'ANULADO';
                $atrib='<span class="label bg-red">Anulado</span>';
                 $sub_array[] = '<button class="btn btn-warning" onclick="mostrar('.$row["idventas"].')"><i class="fa fa-eye"></i></button>';

            }
     
         
                 $sub_array[] = $row["usuario"];
                   $sub_array[] = $row["fechaventa"];
                 $sub_array[] = $row["numero_venta"];
                 $sub_array[] = $row["total_pagar"];
              
	       
             $sub_array[] =$atrib;
       
          /*$sub_array[]='<button class="btn btn-warning btn-md mostrar" onclick="mostrar('.$row["idventas"].')"><i class="fa fa-eye">Mostrar</i></button>';*/
         

           $data[]=$sub_array;
 		}

 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
      
     break;
     case "anular":
      //los parametros idventas y estado vienen por via ajax
              $datos = $venta->get_venta_por_id($_POST["idventas"]);
                //valida el id del usuario
                 if(is_array($datos)==true and count($datos)>0){
                  //anula  la venta
                    $venta->anularventa($_POST["idventas"],$_POST["estado"]);
                      $messages[]=" La venta se anulo";
     }else {
       $errors[]="No  se puede anular la venta";
     }

if (isset($messages)){
        echo exito($messages);
      }
   //fin success

   //mensaje error
         if (isset($errors)){
      
      echo error($errors);
      }
                 break;
      case  'listarProductoVenta':
   $datos=$productos->get_productos();
   $data= Array();

     foreach($datos as $row){
 $sub_array = array();
      if($row["stock"]<=1){
                      
                     $stock = $row["stock"];
                     $atributo = "badge bg-red-active";
                     $sub_array[] = ' <button type="button" class="btn btn-danger btn-md fa fa-close"></button>';
                            
         
          } else {

             $stock = $row["stock"];
                     $atributo = "badge bg-green";
                      $sub_array[] = ' <button class="btn btn-warning" onclick="agregarDetalle('.$row["id_producto"].',\''.$row["producto"].'\','.$row["precio_venta"]. ','.$row["stock"].')" <span class="fa fa-plus">+</span></button>';
                   }
    
    
         
                 $sub_array[] = $row["producto"];
                   $sub_array[] = $row["categoria"];
               $sub_array[] = '<span class="'.$atributo.'">'.$row["stock"].'
                  </span>';
                 $sub_array[] = $row["precio_venta"];
                  /* $sub_array[] = ' <button type="button" onClick="gregarDetalle('.$row["id_producto"].','.$row["producto"].');" name="estado" id="'.$row["id_producto"].'" class="btn btn-danger btn-md fa fa-close">Agregar</button>';*/

           $data[]=$sub_array;
    }
    $results = array(
      "sEcho"=>1, //Información para el datatables
      "iTotalRecords"=>count($data), //enviamos el total registros al datatable
      "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
      "aaData"=>$data);
    echo json_encode($results);
  break;

  case "buscar_ventas_fecha":
          
     $datos=$venta->lista_busca_registros_fecha($_POST["fecha_inicial"], $_POST["fecha_final"]);

     //Vamos a declarar un array
   $data= Array();

    foreach($datos as $row)
      {
        $sub_array = array();

        $est = '';
        
         $atrib = "btn btn-danger btn-md estado";
        if($row["estado"] == 1){
          $est = 'ACEPTADO';
          $atrib = "btn btn-success btn-md estado";
        }
        else{
          if($row["estado"] == 0){
            $est = 'ANULADO';
           
          } 
        }

        
         $sub_array[] = '<button class="btn btn-warning" onclick="mostrar('.$row["idventas"].')"><i class="fa fa-eye"></i></button>';
         
         $sub_array[] = $row["vendedor"];
         $sub_array[] = $row["total_pagar"];
         $sub_array[] = $row["numero_venta"];
         $sub_array[] = date("d-m-Y",strtotime($row["fechaventa"]));

           /*IMPORTANTE: poner \' cuando no sea numero, sino no imprime*/
                 $sub_array[] = '<button type="button" onClick="cambiarEstado('.$row["idventas"].',\''.$row["numero_venta"].'\','.$row["estado"].');" name="estado" id="'.$row["idventas"].'" class="'.$atrib.'">'.$est.'</button>';
                
        $data[] = $sub_array;
      }




      $results = array(
      "sEcho"=>1, //Información para el datatables
      "iTotalRecords"=>count($data), //enviamos el total registros al datatable
      "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
      "aaData"=>$data);
    echo json_encode($results);


     break;
     case "buscar_ventas_fecha_mes":

      
      $datos= $venta->lista_busca_registros_fecha_mes($_POST["mes"],$_POST["ano"]);


        //Vamos a declarar un array
      $data= Array();

        foreach($datos as $row)
        {
            $sub_array = array();

            $est = '';
            
             $atrib = "btn btn-danger btn-md estado";
            if($row["estado"] == 1){
              $est = 'ACEPTADO';
              $atrib = "btn btn-success btn-md estado";
            }
            else{
              if($row["estado"] == 0){
                $est = 'ANULADO';
               
              } 
          }

        
       
      $sub_array[] = '<button class="btn btn-warning" onclick="mostrar('.$row["idventas"].')"><i class="fa fa-eye"></i></button>';
        
         $sub_array[] = $row["vendedor"];
         $sub_array[] = $row["total_pagar"];
         $sub_array[] = $row["numero_venta"];
         $sub_array[] = date("d-m-Y", strtotime($row["fechaventa"]));
           /*IMPORTANTE: poner \' cuando no sea numero, sino no imprime*/
                 $sub_array[] = '<button type="button" onClick="cambiarEstado('.$row["idventas"].',\''.$row["numero_venta"].'\','.$row["estado"].');" name="estado" id="'.$row["idventas"].'" class="'.$atrib.'">'.$est.'</button>';
                
        $data[] = $sub_array;
        
        }


      $results = array(
      "sEcho"=>1, //Información para el datatables
      "iTotalRecords"=>count($data), //enviamos el total registros al datatable
      "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
      "aaData"=>$data);
    echo json_encode($results);


     break;
     case "mostrar":
     //selecciona del incidente
  //el parametro id_incidente se envia por AJAX cuando se edita la categoria
  $datos=$venta->Mostrar($_POST["idventas"]);
          // si existe el id del incidnete entonces recorre el array
        if(is_array($datos)==true and count($datos)>0){
            foreach($datos as $row)
            {
              $output["idventas"] = $row["idventas"];
              $output["usuario"] = $row["vendedor"];
              $output["fecha"] =date("d-m-Y", strtotime($row["fecha"]));
              $output["numero_venta"] = $row["numero_venta"];
        
            }
              echo json_encode($output);
          } else {
                 //si no existe la categoria entonces no recorre el array
                $errors[]="la categoria  no existe";
          }

         //inicio de mensaje de error
        if(isset($errors)){
          ?>
          <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Error!</strong>
              <?php
                foreach ($errors as $error) {
                    echo $error;
                  }
                ?>
          </div>
          <?php
            }
          //fin de mensaje de error
   break;
   case "listarDetalle":
     //selecciona del incidente
     $id=$_GET['id'];
     $total=0;
  //el parametro id_incidente se envia por AJAX cuando se edita la categoria
  $datos=$venta->listardetalle($id);
          // si existe el id del incidnete entonces recorre el array

        if(is_array($datos)==true and count($datos)>0){
    
   $html= " <thead style='background-color:#A9D0F5'>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Venta</th>
                                    <th style='background-color: #A9D0F5 !important'>Subtotal</th>
                                </thead>";
            foreach($datos as $row)
            {

        $subtotal=round($row['subtotal'] * 100) / 100;
       //
        $html.="'<tr>
      '<td>".$row['producto']."</td>'+
      '<td>".$row['cantidad']."</td>'+
      '<td>".$row['precio_venta']."</td>'+
      '<td>".$subtotal."</td>'
      '</tr>'";
        $total= $total+$subtotal;
            }

            $html .= '<tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    
                                    <th>$/'.$total.'</th> 
                                </tfoot';
                                    echo $html;
                               
          } else {
                 //si no existe la categoria entonces no recorre el array
                $errors[]="los detalle  no existe";
          }

         //inicio de mensaje de error
        if(isset($errors)){
          ?>
          <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Error!</strong>
              <?php
                foreach ($errors as $error) {
                    echo $error;
                  }
                ?>
          </div>
          <?php
            }
          //fin de mensaje de error
   break;
 

 }

 ?>
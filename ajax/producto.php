<?php 
//llamo a la conexion de la base de datos 
  require_once("../config/conexion.php");
  //llamo al modelo Producto
  require_once("../modelos/Productos.php");
  require_once("mensajes.php");
  $productos = new Producto();
 if (!isset($_SESSION['id_usuario'])) {?>
        <script type="text/javascript">
        window.location="../vistas/home.php";
        </script>
    <?php
}

   //declaramos las variables de los valores que se envian por el formulario y que recibimos por ajax y decimos que si existe el parametro que estamos recibiendo
   
   //los valores vienen del atributo name de los campos del formulario
   /*el valor id_producto, id_categoria y id_usuario se carga en el campo hidden cuando se edita un registro*/
   $id_producto=isset($_POST["id_producto"]);
   $producto=isset($_POST["producto"]);
   $precio_venta=isset($_POST["precio_venta"]);
   $unidad=isset($_POST["unidad"]);
   $id_usuario=isset($_POST["id_usuario"]);
   $id_categoria=isset($_POST["categoria"]);
   $stock = isset($_POST["stock"]);


   switch($_GET["op"]){

              case "guardaryeditar":
 if (!preg_match('/^[a-záéíóúñA-ZÁÉÍÓÚÑ\s]*$/', $_POST["producto"]) or
            !preg_match('/^[0-9.\s]*$/', $_POST["precio_venta"]) or !preg_match('/^[0-9.\s]*$/', $_POST["stock"])) 
        {
            $errors[] = "Formatos de Información no validos";
            echo error($errors);
        } else {
      /*verificamos si existe el producto en la base de datos, si ya existe un registro con la categoria entonces no se registra la categoria*/
      
      //importante: se debe poner el $_POST sino no funciona
      $datos = $productos->get_producto_nombre($_POST["producto"]);

    
	       	   /*si el id no existe entonces lo registra
	           importante: se debe poner el $_POST sino no funciona*/
	          if(empty($_POST["id_producto"])){

	       	  /*verificamos si existe el producto en la base de datos, si ya existe un registro con la categoria entonces no se registra*/

			       	   if(is_array($datos)==true and count($datos)==0){

			       	   	  //no existe el producto por lo tanto hacemos el registros

			$productos->registrar_producto($producto,$precio_venta,$unidad,$id_categoria,$stock,$id_usuario);



			       	   	  $messages[]="El producto se registró correctamente";

			       	   } //cierre de validacion de $datos 


			       	      /*si ya existe el producto entonces aparece el mensaje*/
				              else {

				              	  $errors[]="El producto ya existe";
				              }

			    }//cierre de empty

	            else {


	            	/*si ya existe entonces editamos el producto*/


	            $productos->editar_producto($producto,$precio_venta,$unidad,$id_usuario,$id_categoria,$id_producto,$stock);


	            	  $messages[]="El producto se editó correctamente";

	            	 
	            }
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


     case 'mostrar':

	//selecciona el id del producto
    //$id_producto=9;
    //el parametro id_producto se envia por AJAX cuando se edita el producto
	$datos = $productos->get_producto_por_id($_POST["id_producto"]);


          // si existe el id del producto entonces recorre el array
	      if(is_array($datos)==true and count($datos)>0){


			foreach($datos as $row)
			{
				$output["id_producto"] = $row["id_producto"];
				$output["categoria"] = $row["categoria"];
				$output["producto"] = $row["producto"];
				$output["unidad"] = $row["unidad"];
				$output["precio_venta"] = $row["precio_venta"];
				$output["stock"] = $row["stock"];

              echo json_encode($output);

             }
	        } else {
                 
                 //si no existe el producto entonces no recorre el array
                $errors[]="El producto no existe";

	        }


	         //inicio de mensaje de error

				 if (isset($errors)){
			
			echo error($errors);
			}
			      

	        //fin de mensaje de error


	 break;

        case "listar":

     $datos=$productos->get_productos();
 	 $data= Array();

     foreach($datos as $row)
      {
        $sub_array = array();
         //STOCK, si es mejor de 10 se pone rojo sino se pone verde
				  $stock=""; 

				  if($row["stock"]<=10){
                      
                     $stock = $row["stock"];
                     $atributo = "badge bg-red-active";
                            
				 
				  } else {

				     $stock = $row["stock"];
                     $atributo = "badge bg-green";
                 
                 }
                 $sub_array[] = $row["producto"];
                 $sub_array[] = $row["unidad"];
                 $sub_array[] = $row["precio_venta"];
                 $sub_array[] = $row["categoria"];
      
       
       
       $sub_array[] = '<span class="'.$atributo.'">'.$row["stock"].'
                  </span>';
                  ?>
                  <?php  if($_SESSION["Eliminar"]==1 and $_SESSION["Editar"]==1)
                                 {
                          $sub_array[]=   '<button type="button" onClick="eliminar('.$row["id_producto"].');"  id="'.$row["id_producto"].'" class="btn btn-danger btn-md hint--top" aria-label="Eliminar Producto "><i class="fa fa-trash"></i></button></div>
                            <button type="button" onClick="mostrar('.$row["id_producto"].');"  id="'.$row["id_producto"].'" class="btn btn-primary btn-md update hint--top" aria-label="Editar Producto" ><i class="fa fa-pencil-square-o"></i></button>';
                    }?>
            <?php  if($_SESSION["Eliminar"]==1){
             $sub_array[]=   '<button type="button" onClick="eliminar('.$row["id_producto"].');"  id="'.$row["id_producto"].'" class="btn btn-danger btn-md hint--top" aria-label="Eliminar Producto "><i class="fa fa-trash"></i></button></div>';

            }
            ?>          
            <?php if($_SESSION["Editar"]==1){
            $sub_array[] = '<div class="cbtns">
          <button type="button" onClick="mostrar('.$row["id_producto"].');"  id="'.$row["id_producto"].'" class="btn btn-primary btn-md update hint--top" aria-label="Editar Producto" ><i class="fa fa-pencil-square-o"></i></button>';
        }?>
        <?php
        
      $data[] = $sub_array;
      }
    
      $results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

      
     break;
     case "eliminar_producto":

  $datos= $productos->get_producto_por_id($_POST["id_producto"]);
  
     if(is_array($datos)==true and count($datos)>0){
          $productos->eliminar_producto($_POST["id_producto"]);
          $messages[]=" el producto se eliminó exitosamente";
     }else {
       $errors[]="No hay producto que borrar";
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
}

 ?>
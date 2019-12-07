<?php
	//llamar a la conexion de la base de datos
	require_once("../config/conexion.php");
 
	//llamar al modelo Insumos
	require_once("../modelos/Insumos.php"); 
	require_once "mensajes.php";

	//Declaramos las variables de los valores que se envian por el formulario y que recibimos por ajax y decimos  que si existe el parametro que estamos recibiendo

	$insumos = new Insumos();
 
	$id_insumo = isset($_POST["id_insumo"]);
	$cantidad = isset($_POST["cantidad"]);
	$precio = isset($_POST["precio"]);
	$unidadMedida = isset($_POST["unidadMedida"]);
	$descripcion = isset($_POST["descripcion"]);
	$fecha = isset($_POST["fecha"]);
	$idpedido = isset($_POST["idpedido"]);
	$idcategoria = isset($_POST["idcategoria"]);

	$salida = isset($_POST["salida"]);
	$fechaS = isset($_POST["fechaS"]);
	$idinsumo = isset($_POST["idinsumo"]);

	#valida que exista la sessión
	if (!isset($_SESSION['id_usuario'])) {?>
	        <script type="text/javascript">
	        window.location="../vistas/home.php";
	        </script>
	    <?php
	}
 
switch ($_GET["op"]) { 

	case 'guardaryeditar':
		// se reciben las variables y se valida si el formato es correcto
        if (!preg_match('/^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9\s]*$/', $_POST["descripcion"])) 
        {
            $errors[] = "Formatos de Información no validos";
            echo error($errors);
        } else {
			$datos = $insumos->get_insumos_por_id($_POST["id_insumo"]);
	       	/*si el titulo no existe entonces lo registra
	        importante: se debe poner el $_POST sino no funciona*/
	        if(empty($_POST["id_insumo"])){
	       	  /*verificamos si el insumo existe en la base de datos, si ya existe un registro con el insumo entonces no se registra*/
			    if(is_array($datos)==true and count($datos)==0){
			       	   	  //no existe el insumo por lo tanto hacemos el registros
		 			$insumos->registrar_insumo($cantidad, $precio, $unidadMedida, $descripcion, $fecha, $idpedido, $idcategoria);
			       	   	  
			       	   	  $messages[]= "El insumo se registró correctamente";
			    }else {
				    
				    $errors[]="Existe un insumo con el mismo id";
				}

			    }else {
	            	/*si ya existe entonces editamos el insumo*/
	             $insumos->editar_insumo($id_insumo, $cantidad, $precio, $unidadMedida, $descripcion, $fecha, $idpedido, $idcategoria);

	            	  $messages[]="El insumo se editó correctamente";
	            }
	    }
	     	//mensaje success
	        if (isset($messages)) {
	            echo exito($messages);
	        }
	        //fin success
	        //mensaje error
	        if (isset($errors)) {
	            echo error($errors);
	        }
	        //fin mensaje error
		break; 

		case 'editarcantidad':
			$insumos->editar_cantidad($idinsumo, $salida, $fechaS);
			$messages[]="El insumo se retiro correctamente";
			//mensaje success
	        if (isset($messages)) {
	            echo exito($messages);
	        }
		break;
		
		case 'mostrar':
			# selecciona el id de el insumo
			//el parametro id_insumo se envia por AJAX cuando se edita el insumo
			$datos = $insumos->get_insumos_por_id($_POST["id_insumo"]);
			if(is_array($datos)==true and count($datos)>0){

				foreach ($datos as $row) {
				
					$output["cantidad"] = $row["cantidad"];
					$output["precio"] = $row["precio"];
					$output["unidadMedida"] = $row["unidadMedida"];
					$output["descripcion"] = $row["descripcion"];
					$output["fecha"] = date("d/m/Y", strtotime($row["fecha"]));
					$output["idcategoria"] = $row["idcategoria"];
					
				}
					echo json_encode($output);

			}else{
				//si no existe el registro no se recorre el array
				$errors[] = "No existe un insumo con ese id";

			}
			//mensaje error
	        if (isset($errors)) {
	            echo error($errors);
	        }
	        //fin mensaje error
		break;
 
		case 'listar':
			$datos = $insumos->get_insumos();
 	 		$data = Array();

		    foreach($datos as $row){
		        $sub_array = array();
		      
		      	$sub_array[] = $row["cantidad"];
		      	$sub_array[] = $row["precio"];
		      	$sub_array[] = $row["unidadMedida"];
		     	$sub_array[] = $row["descripcion"];
		     	$sub_array[] = date("d/m/Y",strtotime($row["fecha"]));
		     	$sub_array[] = $row["categoria"];
		     	$sub_array[] = '<div class="cbtns">
		     	<button type="button" onClick="mostrar('.$row["id_insumo"].');"  id="'.$row["id_insumo"].'" class="btn btn-primary btn-md update hint--top" aria-label="Editar Insumo" ><i class="fa fa-pencil-square-o"></i></button>
      			<button type="button" onClick="eliminar('.$row["id_insumo"].'); desvanecer()"  id="'.$row["id_insumo"].'" class="btn btn-danger btn-md hint--top" aria-label="Eliminar Insumo "><i class="fa fa-trash"></i></button></div>';
		      	$data[] = $sub_array;
		      }

		      $results = array(
		 			"sEcho"=>1, //Información para el datatables
		 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
		 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
		 			"aaData"=>$data);

		 			echo json_encode($results);
		break;

		case "eliminar_insumo":

		  	$datos = $insumos->get_insumos_por_id($_POST["id_insumo"]);

		    if(is_array($datos)==true and count($datos)>0){
		          $insumos->eliminar_insumo($_POST["id_insumo"]);
		          $messages[]="El registro se eliminó exitosamente";
		     }else {
		       $errors[]="No hay registro que borrar";
		     }

		   	//mensaje success
	        if (isset($messages)) {
	            echo exito($messages);
	        }
	        //fin success
	        //mensaje error
	        if (isset($errors)) {
	            echo error($errors);
	        }
	        //fin mensaje error
		break;
	}
?>	
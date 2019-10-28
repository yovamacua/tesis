<?php 
	//llamar a la conexion de la base de datos
	require_once("../config/conexion.php");
 
	//llamar al modelo Insumos
	require_once("../modelos/Insumos.php"); 

	//Declaramos las variables de los valores que se envian por el formulario y que recibimos por ajax y decimos  que si existe el parametro que estamos recibiendo

	$insumos = new Insumos();
 
	$id_insumo = isset($_POST["id_insumo"]);
	$cantidad = isset($_POST["cantidad"]);
	$unidadMedida = isset($_POST["unidadMedida"]);
	$descripcion = isset($_POST["descripcion"]);
	$idpedido = isset($_POST["idpedido"]);
	$idcategoria = isset($_POST["categoria"]);
 
switch ($_GET["op"]) { 

	case 'guardaryeditar':
		$datos = $insumos->get_insumos_por_id($_POST["id_insumo"]);
	       	/*si el titulo no existe entonces lo registra
	        importante: se debe poner el $_POST sino no funciona*/
	        if(empty($_POST["id_insumo"])){
	       	  /*verificamos si el insumo existe en la base de datos, si ya existe un registro con el insumo entonces no se registra*/
			    if(is_array($datos)==true and count($datos)==0){
			       	   	  //no existe el insumo por lo tanto hacemos el registros
		 			$insumos->registrar_insumo($cantidad, $unidadMedida, $descripcion, $idpedido, $idcategoria);
			       	   	  
			       	   	  $messages[]= "El insumo se registró correctamente";
			    }else {
				    
				    $errors[]="Existe un insumo con el mismo id";
				}

			    }else {
	            	/*si ya existe entonces editamos el insumo*/
	             $insumos->editar_insumo($id_insumo, $cantidad, $unidadMedida, $descripcion, $idpedido, $idcategoria);

	            	  $messages[]="El insumo se editó correctamente";
	            }
     	//mensaje success
     	if (isset($messages)){
			?>
				<div class="alert alert-success" role="alert">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>¡Bien hecho!</strong>
					<?php
						foreach ($messages as $message) {
							echo $message;
						}
					?>
				</div>
			<?php
		}
	 //fin success
	 //mensaje error
        if (isset($errors)){
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
		break; 
		
		case 'mostrar':
			# selecciona el id de el insumo
			//el parametro id_insumo se envia por AJAX cuando se edita el insumo
			$datos = $insumos->get_insumos_por_id($_POST["id_insumo"]);
			if(is_array($datos)==true and count($datos)>0){

				foreach ($datos as $row) {
				
					$output["cantidad"] = $row["cantidad"];
					$output["unidadMedida"] = $row["unidadMedida"];
					$output["descripcion"] = $row["descripcion"];
					$output["idpedido"] = $row["idpedido"];
					$output["categoria"] = $row["categoria"];
					
				}
					echo json_encode($output);

			}else{
				//si no existe el registro no se recorre el array
				$errors[] = "No existe un insumo con ese id";

			}
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
 
		case 'listar':
			$datos = $insumos->get_insumos();
 	 		$data = Array();

		    foreach($datos as $row){
		        $sub_array = array();
		      
		      	$sub_array[] = $row["cantidad"];
		      	$sub_array[] = $row["unidadMedida"];
		     	$sub_array[] = $row["descripcion"];
		     	$sub_array[] = $row["idpedido"];
		     	$sub_array[] = $row["categoria"];
		     	$sub_array[] = '<div class="cbtns">
		     	<button type="button" onClick="mostrar('.$row["id_insumo"].');"  id="'.$row["id_insumo"].'" class="btn btn-primary btn-md update hint--top" aria-label="Editar Insumo" ><i class="fa fa-pencil-square-o"></i></button>
      			<button type="button" onClick="eliminar('.$row["id_insumo"].');"  id="'.$row["id_insumo"].'" class="btn btn-danger btn-md hint--top" aria-label="Eliminar Insumo "><i class="glyphicon glyphicon-edit"></i></button></div>';
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

		   	if(isset($messages)){
				?>
				  	<div class="alert alert-success" role="alert">
				    	<button type="button" class="close" data-dismiss="alert">&times;</button>
				     	<strong>¡Bien hecho!</strong>
				      	<?php
					        foreach($messages as $message) {
					            echo $message;
					        }
				        ?>
				  	</div>
				<?php
			}

  			if(isset($errors)){
				?>
					<div class="alert alert-danger" role="alert">
				  		<button type="button" class="close" data-dismiss="alert">&times;</button>
				    	<strong>Error!</strong>
				    	<?php
					      	foreach($errors as $error) {
					        	echo $error;
					        }
				      	?>
					</div>
				<?php
			}
		break;
	}
?>	
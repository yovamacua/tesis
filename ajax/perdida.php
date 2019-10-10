<?php 
	//llamar a la conexion de la base de datos
	require_once("../config/conexion.php");
 
	//llamar al modelo perdidas
	require_once("../modelos/Perdidas.php");

	//Declaramos las variables de los valores que se envian por el formulario y que recibimos por ajax y decimos  que si existe el parametro que estamos recibiendo

	$perdidas = new Perdidas();
	
	$id_perdida = isset($_POST["id_perdida"]);
	$nombreProduc = isset($_POST["nombreProduc"]);
	$cantidad = isset($_POST["cantidad"]);
	$descripcion = isset($_POST["descripcion"]);
	$precioProduc = isset($_POST["precioProduc"]);
	$mes = isset($_POST["mes"]);
	$anio = isset($_POST["anio"]);
	$unidadDelProduc = isset($_POST["unidadDelProduc"]);
	$id_usuario=isset($_POST["id_usuario"]);
 
switch ($_GET["op"]) { 

	case 'guardaryeditar':
		$datos = $perdidas->get_perdidas_por_id($_POST["id_perdida"]);
	       	/*si el titulo no existe entonces lo registra
	        importante: se debe poner el $_POST sino no funciona*/
	        if(empty($_POST["id_perdida"])){
	       	  /*verificamos si el incidente existe en la base de datos, si ya existe un registro con la categoria entonces no se registra*/
			    if(is_array($datos)==true and count($datos)==0){
			       	   	  //no existe la categoria por lo tanto hacemos el registros
		 			$perdidas->registrar_perdidas($nombreProduc, $cantidad, $descripcion, $precioProduc, $mes, $anio, $unidadDelProduc, $id_usuario);
			       	   	  
			       	   	  $messages[]="La perdida se registró correctamente";
			    }else {
				    
				    $errors[]="Existe una perdida con el mismo id";
				}

			    }else {
	            	/*si ya existe entonces editamos la perdida*/
	             $perdidas-> editar_perdida($id_perdida, $nombreProduc, $cantidad, $descripcion, $precioProduc, $mes, $anio, $unidadDelProduc, $id_usuario);

	            	  $messages[]="La perdida se editó correctamente";
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
			# selecciona el id de la perdida
			//el parametro id_perdida se envia por AJAX cuando se edita la perdida
			$datos = $perdidas->get_perdidas_por_id($_POST["id_perdida"]);
			if(is_array($datos)==true and count($datos)>0){

				foreach ($datos as $row) {
				
					$output["nombreProduc"] = $row["nombreProduc"];
					$output["cantidad"] = $row["cantidad"];
					$output["descripcion"] = $row["descripcion"];
					$output["precioProduc"] = $row["precioProduc"];
					$output["mes"] = $row["mes"];
					$output["anio"] = $row["anio"];
					$output["unidadDelProduc"] = $row["unidadDelProduc"];
					
				}
					echo json_encode($output);

			}else{
				//si no existe el registro no se recorre el array
				$errors[] = "No existe una perdida con ese id";

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
			$datos=$perdidas->get_perdidas();
 	 		$data= Array();

		    foreach($datos as $row){
		        $sub_array = array();
		      	$sub_array[] = $row["nombreProduc"];
		     	$sub_array[] = $row["cantidad"];
		     	$sub_array[] = $row["descripcion"];
		     	$sub_array[] = $row["precioProduc"];
		     	$sub_array[] = $row["mes"];
		     	$sub_array[] = $row["anio"];
		     	$sub_array[] = $row["unidadDelProduc"];
		     	$sub_array[] = '<div class="cbtns">
		     	<button type="button" onClick="mostrar('.$row["id_perdida"].');"  id="'.$row["id_perdida"].'" class="btn btn-primary btn-md update hint--top" aria-label="Editar Perdida" ><i class="fa fa-pencil-square-o"></i></button>
      			<button type="button" onClick="eliminar('.$row["id_perdida"].');"  id="'.$row["id_perdida"].'" class="btn btn-danger btn-md hint--top" aria-label="Eliminar Perdida "><i class="glyphicon glyphicon-edit"></i></button></div>';
		      	$data[] = $sub_array;
		      }

		      $results = array(
		 			"sEcho"=>1, //Información para el datatables
		 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
		 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
		 			"aaData"=>$data);

		 			echo json_encode($results);
		break;

		case "eliminar_perdida":

		  	$datos = $perdidas->get_perdidas_por_id($_POST["id_perdida"]);

		    if(is_array($datos)==true and count($datos)>0){
		          $perdidas->eliminar_perdida($_POST["id_perdida"]);
		          $messages[]="El registro de la perdida se eliminó exitosamente";
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


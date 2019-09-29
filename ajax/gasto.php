<?php 
	//llamar a la conexion de la base de datos
	require_once("../config/conexion.php");
 
	//llamar al modelo Gastos
	require_once("../modelos/Gastos.php"); 

	//Declaramos las variables de los valores que se envian por el formulario y que recibimos por ajax y decimos  que si existe el parametro que estamos recibiendo

	$gastos = new Gastos();
 
	$id_gasto = isset($_POST["id_gasto"]);
	$fecha = isset($_POST["fecha"]);
	$descripcion = isset($_POST["descripcion"]);
	$precio = isset($_POST["precio"]);
	$id_usuario=isset($_POST["id_usuario"]);
 
switch ($_GET["op"]) { 

	case 'guardaryeditar':
		$datos = $gastos->get_gastos_por_id($_POST["id_gasto"]);
	       	/*si el titulo no existe entonces lo registra
	        importante: se debe poner el $_POST sino no funciona*/
	        if(empty($_POST["id_gasto"])){
	       	  /*verificamos si el gasto existe en la base de datos, si ya existe un registro con el gasto entonces no se registra*/
			    if(is_array($datos)==true and count($datos)==0){
			       	   	  //no existe el gasto por lo tanto hacemos el registros
		 			$gastos->registrar_gastos($fecha, $descripcion, $precio, $id_usuario);
			       	   	  
			       	   	  $messages[]="El gasto se registró correctamente";
			    }else {
				    
				    $errors[]="Existe un gasto con el mismo id";
				}

			    }else {
	            	/*si ya existe entonces editamos el gasto*/
	             $gastos->editar_gasto($id_gasto, $fecha, $descripcion, $precio, $id_usuario);

	            	  $messages[]="El gasto se editó correctamente";
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
			# selecciona el id de el gasto
			//el parametro id_gasto se envia por AJAX cuando se edita el gasto
			$datos = $gastos->get_gastos_por_id($_POST["id_gasto"]);
			if(is_array($datos)==true and count($datos)>0){

				foreach ($datos as $row) {
				
					$output["fecha"] = $row["fecha"];
					$output["descripcion"] = $row["descripcion"];
					$output["precio"] = $row["precio"];

					echo json_encode($output);
				}

			}else{
				//si no existe el registro no se recorre el array
				$errors[] = "No existe un gasto con ese id";

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
			$datos=$gastos->get_gastos();
 	 		$data= Array();

		    foreach($datos as $row){
		        $sub_array = array();
		      
		      	$sub_array[] = $row["fecha"];
		     	$sub_array[] = $row["descripcion"];
		     	$sub_array[] = $row["precio"];
		     	$sub_array[] = '<div class="cbtns">
		     	<button type="button" onClick="mostrar('.$row["id_gasto"].');"  id="'.$row["id_gasto"].'" class="btn btn-primary btn-md update hint--top" aria-label="Editar Gasto" ><i class="fa fa-pencil-square-o"></i></button>
      			<button type="button" onClick="eliminar('.$row["id_gasto"].');"  id="'.$row["id_gasto"].'" class="btn btn-danger btn-md hint--top" aria-label="Eliminar Gasto "><i class="glyphicon glyphicon-edit"></i></button></div>';
		      	$data[] = $sub_array;
		      }

		      $results = array(
		 			"sEcho"=>1, //Información para el datatables
		 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
		 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
		 			"aaData"=>$data);

		 			echo json_encode($results);
		break;

		case "eliminar_gasto":

		  	$datos = $gastos->get_gastos_por_id($_POST["id_gasto"]);

		    if(is_array($datos)==true and count($datos)>0){
		          $gastos->eliminar_gasto($_POST["id_gasto"]);
		          $messages[]="El registro del gasto se eliminó exitosamente";
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
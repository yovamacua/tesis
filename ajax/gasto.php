<?php 
	//llamar a la conexion de la base de datos
	require_once("../config/conexion.php");
 
	//llamar al modelo Gastos
	require_once("../modelos/Gastos.php");
	require_once("../modelos/Roles.php"); 
	require_once "mensajes.php";

	//Declaramos las variables de los valores que se envian por el formulario y que recibimos por ajax y decimos  que si existe el parametro que estamos recibiendo

	$gastos = new Gastos();
	$usuario = new Roles();
 
	$id_gasto = isset($_POST["id_gasto"]);
	$fecha = isset($_POST["fecha"]);
	$descripcion = isset($_POST["descripcion"]);
	$precio = isset($_POST["precio"]);
	$id_usuario = isset($_POST["id_usuario"]);

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
			$datos = $gastos->get_gastos_por_id($_POST["id_gasto"]);
	       	/*si el titulo no existe entonces lo registra
	        importante: se debe poner el $_POST sino no funciona*/
	        if(empty($_POST["id_gasto"])){
	       	  /*verificamos si el gasto existe en la base de datos, si ya existe un registro con el gasto entonces no se registra*/
			    if(is_array($datos)==true and count($datos)==0){
			       	   	  //no existe el gasto por lo tanto hacemos el registros
		 			$gastos->registrar_gastos($fecha, $descripcion, $precio, $id_usuario);
			       	   	  
			       	   	  $messages[]= "El gasto se registró correctamente";
			    }else {
				    
				    $errors[]="Existe un gasto con el mismo id";
				}

			    }else {
	            	/*si ya existe entonces editamos el gasto*/
	             $gastos->editar_gasto($id_gasto, $fecha, $descripcion, $precio, $id_usuario);

	            	  $messages[]="El gasto se editó correctamente";
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
		
		case 'mostrar':
			# selecciona el id de el gasto
			//el parametro id_gasto se envia por AJAX cuando se edita el gasto
			$datos = $gastos->get_gastos_por_id($_POST["id_gasto"]);
			if(is_array($datos)==true and count($datos)>0){

				foreach ($datos as $row) {
				
					$output["fecha"] = date("d/m/Y", strtotime($row["fecha"]));
					$output["descripcion"] = $row["descripcion"];
					$output["precio"] = $row["precio"];
					
				}
					echo json_encode($output);

			}else{
				//si no existe el registro no se recorre el array
				$errors[] = "No existe un gasto con ese id";

			}
			//mensaje error
	        if (isset($errors)) {
	            echo error($errors);
	        }
	        //fin mensaje error
		break;
 
		case 'listar':
			$datos=$gastos->get_gastos();
			$rol=$usuario->listar_roles_por_usuario($_SESSION['id_usuario']);
      $valores=array();

      //Almacenamos los permisos marcados en el array
foreach($rol as $rows){

              $valores[]= $rows["codigo"];
          }
 	 		$data= Array();

 	 		$dolar = '$ ';

		    foreach($datos as $row){
		        $sub_array = array();
		      
		      	$sub_array[] = $row["usuario"];
		      	$sub_array[] = date("d/m/Y",strtotime($row["fecha"]));
		     	$sub_array[] = $row["descripcion"];
		     	$sub_array[] = $dolar.$row["precio"];

              		
              	$boton_editar='<button type="button" onClick="mostrar('.$row["id_gasto"].');"  id="'.$row["id_gasto"].'" class="btn btn-primary btn-md update hint--top" aria-label="Editar Gasto" ><i class="fa fa-pencil-square-o"></i></button>&nbsp;';

      			$boton_eliminar='<button type="button" onClick="eliminar('.$row["id_gasto"].');"  id="'.$row["id_gasto"].'" class="btn btn-danger btn-md hint--top" aria-label="Eliminar Gasto "><i class="fa fa-trash"></i></button></div>';
              	
       ?>
          <?php  
          if(in_array("EDGAST",$valores) and in_array("ELGAST",$valores)){
                 $sub_array[]='<div class="cbtns">'.$boton_editar.''.$boton_eliminar.'</div>';
               }
            elseif (in_array("EDGAST",$valores)) {
                 $sub_array[]='<div class="cbtns">'.$boton_editar.'</div>';
              }elseif(in_array("ELGAST",$valores)){
                  $sub_array[]='<div class="cbtns">'.$boton_eliminar.'</div>';

              }else{
                $sub_array[]='<div class="cbtns badge bg-red-active"> No Acciones</div>';

              }
            
              
      ?>
         
          
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

		case "eliminar_gasto":

		  	$datos = $gastos->get_gastos_por_id($_POST["id_gasto"]);

		    if(is_array($datos)==true and count($datos)>0){
		          $gastos->eliminar_gasto($_POST["id_gasto"]);
		          $messages[]="El registro del gasto se eliminó exitosamente";
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
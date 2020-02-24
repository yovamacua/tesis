<?php
 //llamo a la conexion de la base de datos
  require_once("../config/conexion.php");
  require_once("../modelos/Roles.php");
  require_once("mensajes.php");


//objeto de tipo Incidentes
  $rol = new Roles();
   $nombre=isset($_POST["nombre"]);
    $roles=isset($_POST["roles"]);
   $descripcion=isset($_POST["descripcion"]);
   $modulo=isset($_POST["modulo"]);
     $codigo=isset($_POST["codigo"]);
   $idroles=isset($_POST["idroles"]);
     $idusuario=isset($_POST["id_usuario"]);

      switch($_GET["op"]){
          case "guardaryeditar":

      $datos = $rol->modulo_rol($_POST["nombre"],$_POST["modulo"]);
	       	   /*si el titulo no existe entonces lo registra
	           importante: se debe poner el $_POST sino no funciona*/
	          if(empty($_POST["idroles"])){
	       	  /*verificamos si el rol existe en la base de datos, si ya existe un registro con el  rol entonces no se registra*/
			       	   if(is_array($datos)==true and count($datos)==0){
			       	   	  //no existe la categoria por lo tanto hacemos el registros
		 $rol->registar_roles($nombre,$codigo,$descripcion,$modulo);
			       	   	  $messages[]="El rol se registró correctamente";
			       	   } //cierre de validacion de $datos
			       	      /*si ya existes el titulo del incidente entonces aparece el mensaje*/
				              else {
				              	  $errors[]="Existe un rol asignado al modulo";
				              }

			    }//cierre de empty

	            else {
	            	/*si ya existe entonces editamos el incidente*/
	             $rol->editar_roles($nombre,$codigo,$descripcion,$modulo,$idroles);
	            	  $messages[]="El rol se editó correctamente";
	            }
         
     //mensaje success
     
if (isset($messages)){
        echo exito($messages);
      }
   //fin success

   //mensaje error
         if (isset($errors)){
      
      echo error($errors);
      }
	 //fin mensaje error
     break;

      case 'mostrar':
	//selecciona del incidente
  //el parametro id_incidente se envia por AJAX cuando se edita la categoria
	$datos=$rol->get_roles_por_id($_POST["idroles"]);
          // si existe el id del incidnete entonces recorre el array
	      if(is_array($datos)==true and count($datos)>0){
    				foreach($datos as $row)
    				{
              $output["idrol"] = $row["idrol"];
             $output["codigo"] = $row["codigo"];
              $output["descripcion"] = $row["descripcion"];
             $output["nombre"] = $row["rol"];
              $output["idmodulo"] = $row["idmodulos"];
             
    
    		
    				}
              echo json_encode($output);
	        } else {
                 //si no existe la categoria entonces no recorre el array
                $errors[]="el rol  no existe";
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
  case 'asignar':
      $rol->asignar_roles($roles,$idusuario);
      $messages[]="Se edito  correctamente";
      //mensaje success
          if (isset($messages)) {
              echo exito($messages);
          }
          //fin de mensaje de error
   break;

        case "listar":
     $datos=$rol->mostrar_roles();
     $roles=$rol->listar_roles_por_usuario($_SESSION['id_usuario']);
      $valores=array();

      //Almacenamos los permisos marcados en el array
foreach($roles as $rows){

              $valores[]= $rows["codigo"];
          }
 	 $data= Array();

     foreach($datos as $row)
      {
      	$sub_array = array();

      $sub_array[] = $row["rol"];
     $sub_array[] = $row["nombre"];
    $button_editar='<button type="button" onClick="mostrar('.$row["idrol"].');"  id="'.$row["idrol"].'" class="btn btn-primary btn-md update hint--top" aria-label="Editar Perfil" ><i class="fa fa-pencil-square-o"></i></button>';

     $button_eliminar='<button type="button" onClick="eliminar('.$row["idrol"].');"  id="'.$row["idrol"].'" class="btn btn-danger btn-md hint--top" aria-label="Eliminar Roles "><i class="fa fa-trash"></i></button></div>';
     ?>
         <?php  
          if(in_array("EDPERM",$valores) and in_array("ELPERM",$valores)){
                 $sub_array[]='<div class="cbtns">'.$button_editar.''.$button_eliminar.'</div>';
              } elseif (in_array("EDPERM",$valores)) {
                 $sub_array[]='<div class="cbtns">'.$button_editar.'</div>';
              }elseif(in_array("ELPERM",$valores)){
                  $sub_array[]='<div class="cbtns">'.$button_eliminar.'</div>';

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

     case "eliminar_perfil":

  $datos= $rol->get_roles_por_id($_POST["idroles"]);
  
     if(is_array($datos)==true and count($datos)>0){
          $rol->deletes($_POST["idroles"]);
          $messages[]=" El rol se eliminó exitosamente";
     }else {
       $errors[]="No hay registro que borrar";
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

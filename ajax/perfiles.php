<?php
 //llamo a la conexion de la base de datos
  require_once("../config/conexion.php");
  require_once("../modelos/Perfiles.php");
    require_once("../modelos/Modulos.php");
     require_once("../modelos/Roles.php");
  require_once("mensajes.php");

//objeto de tipo Incidentes
  $perfil = new Perfiles();
  $usuario = new Roles();
   $idperfil=isset($_POST["idperfil"]);
   $nombre=isset($_POST["nombre"]);
   $codigo=isset($_POST["codigo"]);
   $estado=isset($_POST["estado"]);
   $modulo=isset($_POST["modulo"]);

      switch($_GET["op"]){
          case "guardaryeditar":

      $datos = $perfil->get_perfil_por_codigo($_POST["nombre"],$_POST["idperfil"]);
	       	   /*si el titulo no existe entonces lo registra
	           importante: se debe poner el $_POST sino no funciona*/
	          if(empty($_POST["idperfil"])){
	       	  /*verificamos si el incidente existe en la base de datos, si ya existe un registro con la categoria entonces no se registra*/
			       	   if(is_array($datos)==true and count($datos)==0){
			       	   	  //no existe la categoria por lo tanto hacemos el registros
		 $perfil->registar_perfiles($nombre,$codigo,$estado);
			       	   	  $messages[]="El perfil se registró correctamente";
			       	   } //cierre de validacion de $datos
			       	      /*si ya existes el titulo del incidente entonces aparece el mensaje*/
				              else {
				              	  $errors[]="Existe un perfil con el mismo nombre";
				              }

			    }//cierre de empty

	            else {
	            	/*si ya existe entonces editamos el rol*/
	             $perfil->editar_perfiles($idperfil,$nombre,$codigo,$estado);
	            	  $messages[]="El perfil se editó correctamente";
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
	 //fin mensaje error
     break;

      case 'mostrar':
	//selecciona del incidente
  //el parametro id_incidente se envia por AJAX cuando se edita la categoria
	$datos=$perfil->get_perfil_por_id($_POST["idperfil"]);
          // si existe el id del incidnete entonces recorre el array
	      if(is_array($datos)==true and count($datos)>0){
    				foreach($datos as $row)
    				{
              $output["idperfil"] = $row["idperfil"];
              $output["nombre"] = $row["nombre"];
              $output["codigo"] = $row["codperfil"];
               $output["estado"] = $row["estados"];
    		
    				}
              echo json_encode($output);
	        } else {
                 //si no existe la categoria entonces no recorre el array
                $errors[]="el perfil  no existe";
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
      $perfil->asignar_modulo($modulo,$idperfil);
      $messages[]="Se asigno los modulos correctamente";
      //mensaje success
          if (isset($messages)) {
              echo exito($messages);
          }
          //fin de mensaje de error
   break;
        case "listar":
     $datos=$perfil->mostrar_perfiles();
      $rol=$usuario->listar_roles_por_usuario($_SESSION['id_usuario']);
      $valores=array();

      //Almacenamos los permisos marcados en el array
foreach($rol as $rows){

              $valores[]= $rows["codigo"];
          }
 	 $data= Array();

     foreach($datos as $row)
      {
        $sub_array = array();
        $est = '';
        
         $atrib = "btn btn-danger btn-md estado";
        if($row["estados"] == 1){
          $est = 'Habiltado';
            $atrib = '<span class="label bg-green">'.$est.'</span>';;
        }
        else{
          if($row["estados"] == 0){
            $est = 'deshabilitado';
            $atrib='<span class="label bg-red">'.$est.'</span>';
           
          } 
        }
        $sub_array[] = $row["codperfil"];
      $sub_array[] = $row["nombre"];
      $sub_array[] = $atrib;
     
     $boton_registrar='<a href="asignar_perfil.php?id='. $row["idperfil"] .'"><button type="button" class="btn btn-dark btn-md hint--top" aria-label="Asignar Perfiles "><i class="fa fa-plus-square"></i></button></a>&nbsp;';

          $boton_editar='<button type="button" onClick="mostrar('.$row["idperfil"].');"  id="'.$row["idperfil"].'" class="btn btn-primary btn-md update hint--top" aria-label="Editar Perfil" ><i class="fa fa-pencil-square-o"></i></button>&nbsp;';

          $boton_eliminar='<button type="button" onClick="eliminar('.$row["idperfil"].');"  id="'.$row["idperfil"].'" class="btn btn-danger btn-md hint--top" aria-label="Eliminar Perfil "><i class="fa fa-trash"></i></button>';

          ?>
          <?php  
          if(in_array("REPERM",$valores) and in_array("EDPERM",$valores)and in_array("ELPERM",$valores)){
                 $sub_array[]='<div class="cbtns">'.$boton_registrar.''.$boton_editar.''.$boton_eliminar.'</div>';
              }elseif (in_array("EDPERM",$valores) and in_array("ELPERM",$valores)) {
                 $sub_array[]='<div class="cbtns">'.$boton_editar.' '.$boton_eliminar.'</div>';

               } elseif(in_array("REPERM",$valores) and in_array("ELPERM",$valores)) {
                 $sub_array[]='<div class="cbtns">'.$boton_registrar.' '.$boton_eliminar.'</div>';

              } elseif (in_array("EDPERM",$valores) and in_array("REPERM",$valores)) {
                 $sub_array[]='<div class="cbtns">'.$boton_editar.' '.$boton_registrar.'</div>';

              }elseif (in_array("REPERM",$valores)) {
                 $sub_array[]='<div class="cbtns">'.$boton_registrar.'</div>';

                 

              }elseif(in_array("EDPERM",$valores)){
                       $sub_array[]='<div class="cbtns">'.$boton_editar.'</div>';
              }elseif(in_array("ELPERM",$valores)){
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

     case "eliminar_perfil":

  $datos= $perfil->get_perfil_por_id($_POST["idperfil"]);
  
     if(is_array($datos)==true and count($datos)>0){
          $perfil->deletes_perfil($_POST["idperfil"]);
          $messages[]=" El perfil se eliminó exitosamente";
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

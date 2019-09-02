<?php
 //llamo a la conexion de la base de datos
  require_once("../config/conexion.php");
  require_once("../modelos/partidas.php");
  require_once("mensajes.php");

//objeto de tipo partidas
  $partidas = new partidas();

   $id_partida=isset($_POST["id_partida"]);
   $nombrepartida=isset($_POST["nombrepartida"]);
   $responsable=isset($_POST["responsable"]);
   $id_usuario=isset($_POST["id_usuario"]);

      switch($_GET["op"]){
          case "guardaryeditar":

      $datos = $partidas->get_nombre_partidas($_POST["nombrepartida"]);
      
	       	   /*si el titulo no existe entonces lo registra
	           importante: se debe poner el $_POST sino no funciona*/
	          if(empty($_POST["id_partida"])){
	       	  /*verificamos si el partida existe en la base de datos, si ya existe un registro con la categoria entonces no se registra*/
			       	   if(is_array($datos)==true and count($datos)==0){
			       	   	  //no existe la categoria por lo tanto hacemos el registros
		 $partidas->registrar_partidas($nombrepartida,$responsable,$id_usuario);
			       	   	  $messages[]="La partida se registró correctamente";
			       	   } //cierre de validacion de $datos
			       	      /*si ya existes el titulo del partida entonces aparece el mensaje*/
				              else {
				              	  $errors[]="Existe un partida con el mismo nombre de partida";
				              }

			    }//cierre de empty

	            else {
	            	/*si ya existe entonces editamos el partida*/
	             $partidas-> editar_partidas($id_partida,$nombrepartida,$responsable,$id_usuario);
	            	  $messages[]="El partida se editó correctamente";
	            }
     //mensaje success
     if (isset($messages)){
  				echo exito($messages);
  			}
	 //fin success
	 //mensaje error
         if (isset($errors)){
           echo  error($errors);
			}
	 //fin mensaje error
     break;

      case 'mostrar':
	//selecciona del partida
  //el parametro id_partida se envia por AJAX cuando se edita la categoria
	$datos=$partidas->get_partidas_por_id($_POST["id_partida"]);
          // si existe el id del incidnete entonces recorre el array
	      if(is_array($datos)==true and count($datos)>0){
    				foreach($datos as $row)
    				{
              $output["id_partida"] = $row["id_partida"];
              $output["nombrepartida"] = $row["nombrepartida"];
              $output["responsable"] = $row["responsable"];
    				}
              echo json_encode($output);
	        } else {
                 //si no existe la categoria entonces no recorre el array
                $errors[]="La partida no existe";
	        }

    	 //mensaje error
             if (isset($errors)){
               echo  error($errors);
    			}
	        //fin de mensaje de error
	 break;
        case "listar":
     $datos=$partidas->get_partidas();
 	 $data= Array();

     foreach($datos as $row)
      {
        $sub_array = array();
      $sub_array[] = $row["nombrepartida"];
      $sub_array[] = $row["responsable"];
     $sub_array[] = '<button type="button" onClick="mostrar('.$row["id_partida"].');"  id="'.$row["id_partida"].'" class="btn btn-warning btn-md update"><i class="glyphicon glyphicon-edit"></i> Editar</button>';
     $sub_array[] = '<button type="button" onClick="eliminar('.$row["id_partida"].');"  id="'.$row["id_partida"].'" class="btn btn-danger btn-md"><i class="glyphicon glyphicon-edit"></i> Eliminar</button>';
      $data[] = $sub_array;
      }

      $results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);


     break;

     case "eliminar_partida":

  $datos= $partidas->get_partidas_por_id($_POST["id_partida"]);
     if(is_array($datos)==true and count($datos)>0){
          $partidas->eliminar_partida($_POST["id_partida"]);
          $messages[]="El registro de la partida se eliminó exitosamente";
     }else {
       $errors[]="No hay registro que borrar";
     }

     //mensaje success
     if (isset($messages)){
  	    echo exito($messages);
  			}
	 //fin success
	 //mensaje error
    if (isset($errors)){
    echo  error($errors);
			}
break;
}
?>

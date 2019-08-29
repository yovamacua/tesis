<?php
 //llamo a la conexion de la base de datos
  require_once("../config/conexion.php");
  require_once("../modelos/Incidentes.php");
  require_once("mensajes.php");

//objeto de tipo Incidentes
  $incidentes = new Incidentes();

   $id_incidente=isset($_POST["id_incidente"]);
   $titulo=isset($_POST["titulo"]);
   $descripcion=isset($_POST["descripcion"]);
   $fecha=isset($_POST["fecha"]);
   $id_usuario=isset($_POST["id_usuario"]);

      switch($_GET["op"]){
          case "guardaryeditar":

      $datos = $incidentes->get_nombre_incidentes($_POST["titulo"]);
	       	   /*si el titulo no existe entonces lo registra
	           importante: se debe poner el $_POST sino no funciona*/
	          if(empty($_POST["id_incidente"])){
	       	  /*verificamos si el incidente existe en la base de datos, si ya existe un registro con la categoria entonces no se registra*/
			       	   if(is_array($datos)==true and count($datos)==0){
			       	   	  //no existe la categoria por lo tanto hacemos el registros
		 $incidentes->registrar_incidentes($titulo,$descripcion,$fecha,$id_usuario);
			       	   	  $messages[]="El incidente se registró correctamente";
			       	   } //cierre de validacion de $datos
			       	      /*si ya existes el titulo del incidente entonces aparece el mensaje*/
				              else {
				              	  $errors[]="Existe un incidente con el mismo titulo";
				              }

			    }//cierre de empty

	            else {
	            	/*si ya existe entonces editamos el incidente*/
	             $incidentes-> editar_incidentes($id_incidente,$titulo,$descripcion,$fecha,$id_usuario);
	            	  $messages[]="El incidente se editó correctamente";
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
	//selecciona del incidente
  //el parametro id_incidente se envia por AJAX cuando se edita la categoria
	$datos=$incidentes->get_incidentes_por_id($_POST["id_incidente"]);
          // si existe el id del incidnete entonces recorre el array
	      if(is_array($datos)==true and count($datos)>0){
    				foreach($datos as $row)
    				{
              $output["id_incidente"] = $row["id_incidente"];
              $output["titulo"] = $row["titulo"];
              $output["descripcion"] = $row["descripcion"];
    					$output["fecha"] = $row["fecha"];
    				}
              echo json_encode($output);
	        } else {
                 //si no existe la categoria entonces no recorre el array
                $errors[]="El incidente no existe";
	        }

    	 //mensaje error
             if (isset($errors)){
               echo  error($errors);
    			}
	        //fin de mensaje de error
	 break;
        case "listar":
     $datos=$incidentes->get_incidentes();
 	 $data= Array();

     foreach($datos as $row)
      {
        $sub_array = array();
      $sub_array[] = $row["titulo"];
      $sub_array[] = $row["descripcion"];
      $sub_array[] = $row["fecha"];
     $sub_array[] = '<button type="button" onClick="mostrar('.$row["id_incidente"].');"  id="'.$row["id_incidente"].'" class="btn btn-warning btn-md update"><i class="glyphicon glyphicon-edit"></i> Editar</button>';
     $sub_array[] = '<button type="button" onClick="eliminar('.$row["id_incidente"].');"  id="'.$row["id_incidente"].'" class="btn btn-danger btn-md"><i class="glyphicon glyphicon-edit"></i> Eliminar</button>';
      $data[] = $sub_array;
      }

      $results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);


     break;

     case "eliminar_incidente":

  $datos= $incidentes->get_incidentes_por_id($_POST["id_incidente"]);
     if(is_array($datos)==true and count($datos)>0){
          $incidentes->eliminar_incidente($_POST["id_incidente"]);
          $messages[]="El registro del incidente se eliminó exitosamente";
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

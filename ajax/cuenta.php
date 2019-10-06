<?php
 //llamo a la conexion de la base de datos
  require_once("../config/conexion.php");
  require_once("../modelos/Cuenta.php");
  require_once("mensajes.php");

//objeto de tipo cuentas
  $cuentas = new cuentas();

   $id_cuenta=isset($_POST["id_cuenta"]);
   $nombrecuenta=isset($_POST["nombrecuenta"]);
   $id_partida=isset($_POST["id_partida"]);

      switch($_GET["op"]){
          case "guardaryeditar":

      $datos = $cuentas->get_nombre_cuentas($_POST["nombrecuenta"]);

	       	   /*si el titulo no existe entonces lo registra
	           importante: se debe poner el $_POST sino no funciona*/
	          if(empty($_POST["id_cuenta"])){
	       	  /*verificamos si el cuenta existe en la base de datos, si ya existe un registro con la categoria entonces no se registra*/
			       	   	  //no existe la categoria por lo tanto hacemos el registros
		    $cuentas->registrar_cuentas($nombrecuenta,$id_partida);
			       	   	  $messages[]="La cuenta se registró correctamente";
			      //cierre de validacion de $datos

			    }//cierre de empty

	            else {
	            	/*si ya existe entonces editamos el cuenta*/
	             $cuentas-> editar_cuentas($id_cuenta,$nombrecuenta,$id_partida);
	            	  $messages[]="El cuenta se editó correctamente";
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
	//selecciona del cuenta
  //el parametro id_cuenta se envia por AJAX cuando se edita la categoria
	$datos=$cuentas->get_cuentas_por_id($_POST["id_cuenta"]);
          // si existe el id del incidnete entonces recorre el array
	      if(is_array($datos)==true and count($datos)>0){
    				foreach($datos as $row)
    				{
              $output["id_cuenta"] = $row["id_cuenta"];
              $output["nombrecuenta"] = $row["nombrecuenta"];
    				}
              echo json_encode($output);
	        } else {
                 //si no existe la categoria entonces no recorre el array
                $errors[]="La cuenta no existe";
	        }

    	 //mensaje error
             if (isset($errors)){
               echo  error($errors);
    			}
	        //fin de mensaje de error
	 break;
  case "listar":
     $identificador = $_SESSION["seleccion_partida"];
     $datos=$cuentas->get_cuentas($identificador);
 	 $data= Array();

     foreach($datos as $row)
      {
        $sub_array = array();
      $sub_array[] = $row["nombrecuenta"];
      $sub_array[] = '<div class="cbtns"><a href="entrada.php?identificador='.$row["id_cuenta"].'&nombrecuenta='.$row["nombrecuenta"].'"><button type="button" class="btn btn-primary btn-md"><i class="glyphicon glyphicon-edit"></i> Agregar Detalle de Entrada</button></a></div>';
     $sub_array[] = '<div class="cbtns"><button type="button" onClick="mostrar('.$row["id_cuenta"].');"  id="'.$row["id_cuenta"].'" class="btn btn-primary btn-md update hint--top" aria-label="Editar"><i class="fa fa-pencil-square-o"></i> </button>&nbsp;<button type="button" onClick="eliminar('.$row["id_cuenta"].');"  id="'.$row["id_cuenta"].'" class="btn btn-danger btn-md hint--top" aria-label="Eliminar"><i class="fa fa-trash"></i></button></div>';
      $data[] = $sub_array;
      }

      $results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);


     break;

     case "eliminar_cuenta":

  $datos= $cuentas->get_cuentas_por_id($_POST["id_cuenta"]);
     if(is_array($datos)==true and count($datos)>0){
          $cuentas->eliminar_cuenta($_POST["id_cuenta"]);
          $messages[]="El registro de la cuenta se eliminó exitosamente";
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

<?php
 //llamo a la conexion de la base de datos
  require_once("../config/conexion.php");
  require_once("../modelos/Unidad.php");
  require_once("mensajes.php");
   require_once("../modelos/Roles.php");
  #valida que exista la sessión
if (!isset($_SESSION['id_usuario'])) {?>
        <script type="text/javascript">
        window.location="../vistas/home.php";
        </script>
    <?php
}



//objeto de tipo unidad
  $unidad = new Unidad();
   $usuario = new Roles();

   $id_unidad=isset($_POST["id_unidad"]);
   $nombre=isset($_POST["nombre"]);
   $descripcion=isset($_POST["descripcion"]);
   $id_usuario=isset($_POST["id_usuario"]);

      switch($_GET["op"]){
          case "guardaryeditar":
          if (!preg_match('/^[a-záéíóúñA-ZÁÉÍÓÚÑ\s]*$/', $_POST["nombre"]) or
            !preg_match('/^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9\s]*$/', $_POST["descripcion"])) 
        {
            $errors[] = "Formatos de Información no validos";
            echo error($errors);
        } else {

      $datos = $unidad->get_nombre_unidad($_POST["nombre"]);
	       	   /*si el titulo no existe entonces lo registra
	           importante: se debe poner el $_POST sino no funciona*/
	          if(empty($_POST["id_unidad"])){
	       	  /*verificamos si la unidad existe en la base de datos, si ya existe un registro con la unidad entonces no se registra*/
			       	   if(is_array($datos)==true and count($datos)==0){
			       	   	  //no existe la unidad por lo tanto hacemos el registros
		 $unidad->registrar_unidad($nombre,$descripcion,$id_usuario);
			       	   	  $messages[]="La unidad se registró correctamente";
			       	   } //cierre de validacion de $datos
			       	      /*si ya existes el titulo de la unidad entonces aparece el mensaje*/
				              else {
				              	  $errors[]="Existe una unidad con el mismo nombre";
				              }

			    }//cierre de empty

	            else {
	            	/*si ya existe entonces editamos el incidente*/
	             $unidad-> editar_unidad($id_unidad,$nombre,$descripcion,$id_usuario);
	            	  $messages[]="La unidad se editó correctamente";
	            }
            }
     //mensaje success
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
			
	 //fin success
     break;

      case 'mostrar':
	//selecciona la unidad
  //el parametro idunidad se envia por AJAX cuando se edita la unidad
	$datos=$unidad->get_unidad_por_id($_POST["id_unidad"]);
          // si existe el id del incidnete entonces recorre el array
	      if(is_array($datos)==true and count($datos)>0){
    				foreach($datos as $row)
    				{
              $output["id_unidad"] = $row["idunidad"];
              $output["nombre"] = $row["nombre"];
              $output["descripcion"] = $row["descripcion"];
    		
    				}
              echo json_encode($output);
	        } else {
                 //si no existe la unidad entonces no recorre el array
                $errors[]="la unidad no existe";
	        }

         //inicio de mensaje de error
				 //mensaje error
          if (isset($errors)) {
              echo error($errors);
          }
	        //fin de mensaje de error
	 break;
        case "listar":
     $datos=$unidad->get_unidad();
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
      $sub_array[] = $row["nombre"];
      $sub_array[] = $row["descripcion"];
     
                    $button_editar='<button type="button" onClick="mostrar('.$row["idunidad"].');"  id="'.$row["idunidad"].'" class="btn btn-primary btn-md update hint--top" aria-label="Editar unidad" ><i class="fa fa-pencil-square-o"></i></button>';

                          $button_eliminar=' <button type="button" onClick="eliminar('.$row["idunidad"].');"  id="'.$row["idunidad"].'" class="btn btn-danger btn-md hint--top" aria-label="Eliminar Unidad "><i class="fa fa-trash"></i></button></div>';
           ?>
         <?php  
          if(in_array("EDUNID",$valores) and in_array("ELUNID",$valores)){
                 $sub_array[]='<div class="cbtns">'.$button_editar.''.$button_eliminar.'</div>';
              } elseif (in_array("EDUNID",$valores)) {
                 $sub_array[]='<div class="cbtns">'.$button_editar.'</div>';
              }elseif(in_array("ELUNID",$valores)){
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

     case "eliminar_unidad":

  $datos= $unidad->get_unidad_por_id($_POST["id_unidad"]);
  
     if(is_array($datos)==true and count($datos)>0){
          $unidad->eliminar_unidad($_POST["id_unidad"]);
          $messages[]=" La unidad se eliminó exitosamente";
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
break;
}
?>

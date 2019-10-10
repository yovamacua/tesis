<?php
 //llamo a la conexion de la base de datos
  require_once("../config/conexion.php");
  require_once("../modelos/Capacitaciones.php");
  require_once("../modelos/DetalleCapacitados.php");

//objeto de tipo Capacitaciones y DetalleCapacitados
  $capacitaciones = new Capacitaciones();
  $detallecapacitados = new DetalleCapacitados();

  $id_capacitacion = isset($_POST["id_capacitacion"]);
  $fecha = isset($_POST["fecha"]);
  $nombreGrupo = isset($_POST["nombreGrupo"]);
  $cargo = isset($_POST["cargo"]);
  $encargado = isset($_POST["encargado"]);
  $id_usuario = isset($_POST["id_usuario"]);

  $id_detallecapacitados = isset($_POST["id_detallecapacitados"]);
  $nombres = isset($_POST["nombres"]);
  $apellidos = isset($_POST["apellidos"]);
  $contactos = isset($_POST["contactos"]);
  $procedencia = isset($_POST["procedencia"]);

      switch($_GET["op"]){
        case "guardaryeditar":

          $datos = $capacitaciones->get_capacitacion_por_id($_POST["id_capacitacion"]);
	       	   /*si el titulo no existe entonces lo registra
	           importante: se debe poner el $_POST sino no funciona*/
	          if(empty($_POST["id_capacitacion"])){ 
	       	  /*verificamos si la capacitacionexiste en la base de datos, si ya existe un registro con la capacitacion entonces no se registra*/
			       	    if(is_array($datos)==true and count($datos)==0){
			       	   	  //no existe la capacitacion por lo tanto hacemos el registros
		                    $capacitaciones->registrar_capacitacion($fecha, $nombreGrupo, $cargo, $encargado, $id_usuario);
			       	   	      $messages[] = "La capacitacion se registró correctamente";
			       	    } //cierre de validacion de $datos
			       	      /*si ya existes el titulo de la capacitacion entonces aparece el mensaje*/
				          else {
				              	  $errors[] = "Existe una capacitacion con el mismo nombre";
				              }

			      }//cierre de empty

	            else {
	            	  /*si ya existe entonces editamos la capacitacion*/
	                $capacitaciones-> editar_capacitacion($id_capacitacion, $fecha, $nombreGrupo, $cargo, $encargado, $id_usuario);
	            	  $messages[] = "La capacitacion se editó correctamente";
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

      //guardaryeditar detallecapacitados
      case 'guardaryeditardetalle':
    $datos = $detallecapacitados->get_detallecapacitados_por_id($_POST["id_detallecapacitados"]);
          /*si el titulo no existe entonces lo registra
          importante: se debe poner el $_POST sino no funciona*/
          if(empty($_POST["id_detallecapacitados"])){
            /*verificamos si el capacitado existe en la base de datos, si ya existe un registro con el capacitado entonces no se registra*/
          if(is_array($datos)==true and count($datos)==0){
                    //no existe el capacitado por lo tanto hacemos el registros
          $detallecapacitados->registrar_detallecapacitados($nombres, $apellidos, $contacto, $procedencia, $id_capacitacion);
                    
                    $messages[]= "El capacitado se registró correctamente";
          }else {
            
            $errors[]="Existe un capacitado con el mismo id";
        }

          }else {
                /*si ya existe entonces editamos el capacitado*/
               $detallecapacitados->editar_detallecapacitados($id_detallecapacitados, $nombres, $apellidos, $contacto, $procedencia, $id_capacitacion);

                  $messages[]="El capacitado se editó correctamente";
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
    }//fin success
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
      	//selecciona del incidente
        //el parametro id_incidente se envia por AJAX cuando se edita la capacitacion
	      $datos = $capacitaciones->get_capacitacion_por_id($_POST["id_capacitacion"]);
          // si existe el id del incidnete entonces recorre el array
	        if(is_array($datos)==true and count($datos)>0){
    				foreach($datos as $row)
    				{
              $output["fecha"] = $row["fecha"];
              $output["nombreGrupo"] = $row["nombreGrupo"];
              $output["cargo"] = $row["cargo"];
              $output["encargado"] = $row["encargado"];
              $output["id_capacitacion"] = $row["id_capacitacion"];
    				}
              echo json_encode($output);

	        } else {
             //si no existe la capacitacion entonces no recorre el array
              $errors[]="la capacitacion  no existe";
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

      //mostrar el detallecapacitados
      case 'mostrardetalle':
      # selecciona el id de el capacitado
      //el parametro id_detallecapacitados se envia por AJAX cuando se edita el capacitado
      $datos = $detallecapacitados->get_detallecapacitados_por_id($_POST["id_detallecapacitados"]);
      if(is_array($datos)==true and count($datos)>0){

        foreach ($datos as $row) {
        
          $output["nombres"] = $row["nombres"];
          $output["apellidos"] = $row["apellidos"];
          $output["contacto"] = $row["contacto"];
          $output["procedencia"] = $row["procedencia"];
          $output["id_detallecapacitados"] = $row["id_detallecapacitados"];
          $output["id_capacitacion"] = $row["id_capacitacion"];
        }
          echo json_encode($output);

      }else{
        //si no existe el registro no se recorre el array
        $errors[] = "No existe un capacitado con ese id";

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

      case "listar":
        $datos = $capacitaciones->get_capacitacion();
   	    $data = Array();
 
        foreach($datos as $row)
        {
          $sub_array = array();
          $sub_array[] = $row["id_capacitacion"];
          $sub_array[] = $row["fecha"];
          $sub_array[] = $row["nombreGrupo"];
          $sub_array[] = $row["cargo"];
          $sub_array[] = $row["encargado"];
          $sub_array[] = '<div class="cbtns">
          <button type="button" onClick="verdetalle();" class="btn btn-md btn-md update hint--top" aria-label="Ver Detalle" ><i class="fa fa-pencil-square-o"></i></button>
          <button type="button" onClick="mostrar('.$row["id_capacitacion"].');"  id="'.$row["id_capacitacion"].'" class="btn btn-primary btn-md update hint--top" aria-label="Editar Capacitacion" ><i class="fa fa-pencil-square-o"></i></button>
          <button type="button" onClick="eliminar('.$row["id_capacitacion"].');"  id="'.$row["id_capacitacion"].'" class="btn btn-danger btn-md hint--top" aria-label="Eliminar Capacitacion "><i class="glyphicon glyphicon-edit"></i></button></div>';
          $data[] = $sub_array;
        }

        $results = array(
   			"sEcho"=>1, //Información para el datatables
   			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
   			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
   			"aaData"=>$data);
 		    echo json_encode($results);

    break;

    //listar detallecapacitados
    case 'listardetalle':
      $datos=$detallecapacitados->get_detallecapacitados();
      $data= Array();

        foreach($datos as $row){
            $sub_array = array();

          $sub_array[] = $row["id_capacitacion"];
          $sub_array[] = $row["nombres"];
          $sub_array[] = $row["apellidos"];
          $sub_array[] = $row["contacto"];
          $sub_array[] = $row["procedencia"];
          $sub_array[] = '<div class="cbtns">
          <button type="button" onClick="mostrardetalle('.$row["id_detallecapacitados"].');"  id="'.$row["id_detallecapacitados"].'" class="btn btn-primary btn-md update hint--top" aria-label="Editar Capacitado" ><i class="fa fa-pencil-square-o"></i></button>
          <button type="button" onClick="eliminardetalle('.$row["id_detallecapacitados"].');"  id="'.$row["id_detallecapacitados"].'" class="btn btn-danger btn-md hint--top" aria-label="Eliminar Capacitado "><i class="glyphicon glyphicon-edit"></i></button></div>';
            $data[] = $sub_array;
          }

          $results = array(
          "sEcho"=>1, //Información para el datatables
          "iTotalRecords"=>count($data), //enviamos el total registros al datatable
          "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
          "aaData"=>$data);

          echo json_encode($results);
    break;

    case "eliminar_capacitaciones":

      $datos= $capacitaciones->get_capacitacion_por_id($_POST["id_capacitacion"]);
  
      if(is_array($datos)==true and count($datos)>0){
          $capacitaciones->eliminar_capacitados($_POST["id_capacitacion"]);
          $capacitaciones->eliminar_capacitacion($_POST["id_capacitacion"]);
          $messages[]=" La capacitacion se eliminó exitosamente";
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

    //eliminar detallecapacitados
    case "eliminar_detallecapacitados":

        $datos = $detallecapacitados->get_detallecapacitados_por_id($_POST["id_detallecapacitados"]);

        if(is_array($datos)==true and count($datos)>0){
              $detallecapacitados->eliminar_detallecapacitados($_POST["id_detallecapacitados"]);
              $messages[]="El registro del capacitado se eliminó exitosamente";
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

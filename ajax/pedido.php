<?php
 //llamo a la conexion de la base de datos
  require_once("../config/conexion.php");
  require_once("../modelos/Pedidos.php");
  require_once("../modelos/DetallePedidos.php");

  //objeto de tipo Pedidos y DetallePedidos
  $pedidos = new Pedidos();
  $detallepedidos = new DetallePedidos();

  $id_pedido = isset($_POST["id_pedido"]);
  $fecha = isset($_POST["fecha"]);
  $id_usuario = isset($_POST["id_usuario"]);

  $id_detallepedido = isset($_POST["id_detallepedido"]);
  $nombreInsumo = isset($_POST["nombreInsumo"]);
  $cantidad = isset($_POST["cantidad"]);
  $descripcion = isset($_POST["descripcion"]);
  $unidadMedida = isset($_POST["unidadMedida"]);

      switch($_GET["op"]){
        case "guardaryeditar":

          $datos = $pedidos->get_pedido_por_id($_POST["id_pedido"]);
	       	   /*si el titulo no existe entonces lo registra
	           importante: se debe poner el $_POST sino no funciona*/
	          if(empty($_POST["id_pedido"])){ 
	       	  /*verificamos si hay pedidos existes en la base de datos, si ya existe un registro con el pediod entonces no se registra*/
			       	    if(is_array($datos)==true and count($datos)==0){
			       	   	  //no existe pedido por lo tanto hacemos el registros
		                    $pedidos->registrar_pedido($id_usuario, $fecha);
			       	   	      $messages[] = "El pedido se registró correctamente";
			       	    } //cierre de validacion de $datos
			       	      /*si ya existes el titulo del pedido entonces aparece el mensaje*/
				          else {
				              	  $errors[] = "Existe un pedido con el mismo nombre";
				              }

			      }//cierre de empty

	            else {
	            	  /*si ya existe entonces editamos el pedido*/
	                $pedidos-> editar_pedido($id_pedido, $id_usuario, $fecha);
	            	  $messages[] = "El pedido se editó correctamente";
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

  //guardaryeditar detallepedido
  case 'guardaryeditardetalle':
    $datos = $detallepedidos->get_detallepedido_por_id($_POST["id_detallepedido"]);
          /*si el titulo no existe entonces lo registra
          importante: se debe poner el $_POST sino no funciona*/
          if(empty($_POST["id_detallepedido"])){
            /*verificamos si el capacitado existe en la base de datos, si ya existe un registro con el capacitado entonces no se registra*/
          if(is_array($datos)==true and count($datos)==0){
                    //no existe el capacitado por lo tanto hacemos el registros
          $detallepedidos->registrar_detallepedido($nombreInsumo, $cantidad, $descripcion, $unidadMedida, $id_pedido);
                    
                    $messages[]= "El insumo se registró correctamente";
          }else {
            
            $errors[]="Existe un insumo con el mismo id";
        }

          }else {
                /*si ya existe entonces editamos el capacitado*/
               $detallepedidos->editar_detallepedido($id_detallepedido, $nombreInsumo, $cantidad, $descripcion, $unidadMedida, $id_pedido);

                  $messages[]="El insumo se editó correctamente";
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
        //el parametro id_incidente se envia por AJAX cuando se edita el pedido
	      $datos = $pedidos->get_pedido_por_id($_POST["id_pedido"]);
        //$datos = $detallepedidos->get_detallepedido($_POST["id_pedido"]);
          // si existe el id del incidnete entonces recorre el array
	        if(is_array($datos)==true and count($datos)>0){
    			foreach($datos as $row)
    			{
                $output["id_usuario"] = $row["id_usuario"];
	              $output["fecha"] = date("d/m/Y", strtotime($row["fecha"]));
	              $output["id_pedido"] = $row["id_pedido"];
    			}
              echo json_encode($output);

	        } else {
             //si no existe el pedido entonces no recorre el array
              $errors[]="El pedido no existe";
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
      //el parametro id_detallecapacitados se envia por AJAX cuando se edita el pedidodetalle
      $datos = $detallepedidos->get_detallepedido_por_id($_POST["id_detallepedido"]);
      if(is_array($datos)==true and count($datos)>0){

        foreach ($datos as $row) {
        
          $output["nombreInsumo"] = $row["nombreInsumo"];
          $output["cantidad"] = $row["cantidad"];
          $output["descripcion"] = $row["descripcion"];
          $output["unidadMedida"] = $row["unidadMedida"];
          $output["id_detallepedido"] = $row["id_detallepedido"];
          $output["id_pedido"] = $row["id_pedido"];
        }
          echo json_encode($output);

      }else{
        //si no existe el registro no se recorre el array
        $errors[] = "No existe un pedido con ese id";

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
        $datos = $pedidos->get_pedido();
   	    $data = Array();
 
        foreach($datos as $row)
        {
          $sub_array = array();
          $sub_array[] = $row["id_pedido"];
          $sub_array[] = date("d/m/Y",strtotime($row["fecha"]));
          $sub_array[] = '<div class="cbtns">
          <button type="button" onClick="verdetalle('.$row["id_pedido"].');"  id="'.$row["id_pedido"].'" class="btn btn-md btn-md update hint--top" aria-label="Ver Detalle" ><i class="fa fa-pencil-square-o"></i></button>
          <button type="button" onClick="mostrar('.$row["id_pedido"].');"  id="'.$row["id_pedido"].'" class="btn btn-primary btn-md update hint--top" aria-label="Editar Pedido" ><i class="fa fa-pencil-square-o"></i></button>
          <button type="button" onClick="eliminar('.$row["id_pedido"].');"  id="'.$row["id_pedido"].'" class="btn btn-danger btn-md hint--top" aria-label="Eliminar Pedido "><i class="glyphicon glyphicon-edit"></i></button></div>';
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
      $datos = $detallepedidos->get_detallepedido($_POST["id_pedido"]);
      $data = Array();

        foreach($datos as $row){

          $sub_array = array();
          $sub_array[] = $row["id_pedido"];
          $sub_array[] = $row["nombreInsumo"];
          $sub_array[] = $row["cantidad"];
          $sub_array[] = $row["descripcion"];
          $sub_array[] = $row["unidadMedida"];
          $sub_array[] = '<div class="cbtns">
          <button type="button" onClick="mostrardetalle('.$row["id_detallepedido"].');"  id="'.$row["id_detallepedido"].'" class="btn btn-primary btn-md update hint--top" aria-label="Editar Capacitado" ><i class="fa fa-pencil-square-o"></i></button>
          <button type="button" onClick="eliminar_detallepedidos('.$row["id_detallepedido"].');"  id="'.$row["id_detallepedido"].'" class="btn btn-danger btn-md hint--top" aria-label="Eliminar Producto "><i class="glyphicon glyphicon-edit"></i></button></div>';
            $data[] = $sub_array;
          }
          
          $results = array(
          "sEcho"=>1, //Información para el datatables
          "iTotalRecords"=>count($data), //enviamos el total registros al datatable
          "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
          "aaData"=>$data);
          echo json_encode($results);
    break;

    case "eliminar_pedidos":

      $datos= $pedidos->get_pedido_por_id($_POST["id_pedido"]);
  
      if(is_array($datos)==true and count($datos)>0){
          $pedidos->eliminar_pedidos($_POST["id_pedido"]);
          $pedidos->eliminar_pedido($_POST["id_pedido"]);
          $messages[]="El pedido se eliminó exitosamente";
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

    //eliminar detallepedido
    case "eliminar_detallepedidos":

        $datos = $detallepedidos->get_detallepedido_por_id($_POST["id_detallepedido"]);

        if(is_array($datos)==true and count($datos)>0){
              $detallepedidos->eliminar_detallepedido($_POST["id_detallepedido"]);
              $messages[]="El registro se eliminó exitosamente";
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

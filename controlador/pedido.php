<?php
 //llamo a la conexion de la base de datos
  require_once("../config/conexion.php");
  require_once("../modelos/Pedidos.php");
  require_once("../modelos/DetallePedidos.php");
  require_once("../modelos/Roles.php");
  require_once "mensajes.php";

  //objeto de tipo Pedidos y DetallePedidos
  $pedidos = new Pedidos();
  $detallepedidos = new DetallePedidos();
   $usuario = new Roles();

  $id_pedido = isset($_POST["id_pedido"]);
  $fecha = isset($_POST["fecha"]);
  $id_usuario = isset($_POST["id_usuario"]);

  $id_detallepedido = isset($_POST["id_detallepedido"]);
  $nombreInsumo = isset($_POST["nombreInsumo"]);
  $cantidad = isset($_POST["cantidad"]);
  $descripcion = isset($_POST["descripcion"]);
  $id_uni = isset($_POST["id_uni"]);

  #valida que exista la sessión
  if (!isset($_SESSION['id_usuario'])) {?>
          <script type="text/javascript">
          window.location="../vistas/home.php";
          </script>
      <?php
  }

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

  //guardaryeditar detallepedido
  case 'guardaryeditardetalle':
      // se reciben las variables y se valida si el formato es correcto
        if (!preg_match('/^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9\s]*$/', $_POST["nombreInsumo"])or
            !preg_match('/^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9\s]*$/', $_POST["descripcion"])) 
        {
            $errors[] = "Formatos de Información no validos";
            echo error($errors);
        } else {
          $datos = $detallepedidos->get_detallepedido_por_id($_POST["id_detallepedido"]);
          /*si el titulo no existe entonces lo registra
          importante: se debe poner el $_POST sino no funciona*/
          if(empty($_POST["id_detallepedido"])){
            /*verificamos si el capacitado existe en la base de datos, si ya existe un registro con el capacitado entonces no se registra*/
            if(is_array($datos)==true and count($datos)==0){
              //no existe el capacitado por lo tanto hacemos el registros
              $detallepedidos->registrar_detallepedido($nombreInsumo, $cantidad, $descripcion, $id_pedido, $id_uni);
                    
                  $messages[]= "El insumo se registró correctamente";
            }else {
              $errors[]="Existe un insumo con el mismo id";
            }

          }else {
              /*si ya existe entonces editamos el capacitado*/
               $detallepedidos->editar_detallepedido($id_detallepedido, $nombreInsumo, $cantidad, $descripcion, $id_pedido, $id_uni);

                  $messages[]="El insumo se editó correctamente";
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
          //mensaje error
          if (isset($errors)) {
              echo error($errors);
          }
          //fin mensaje error
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
          $output["id_uni"] = $row["id_uni"];
          $output["id_detallepedido"] = $row["id_detallepedido"];
          $output["id_pedido"] = $row["id_pedido"];
        }
          echo json_encode($output);

      }else{
        //si no existe el registro no se recorre el array
        $errors[] = "No existe un pedido con ese id";

      }
      //mensaje error
      if (isset($errors)) {
          echo error($errors);
      }
      //fin mensaje error
    break;

      case "listar":
        $datos = $pedidos->get_pedido();
        $rol=$usuario->listar_roles_por_usuario($_SESSION['id_usuario']);
      $valores=array();

      //Almacenamos los permisos marcados en el array
foreach($rol as $rows){

              $valores[]= $rows["codigo"];
          }
   	    $data = Array();
 
        foreach($datos as $row)
        {
          $sub_array = array();
          $sub_array[] = $row["usuario"];
          $sub_array[] = $row["id_pedido"];
          $sub_array[] = date("d/m/Y",strtotime($row["fecha"]));

          $boton_registrar = '<div class="cbtns">
            <button type="button" onClick="verdetalle('.$row["id_pedido"].');"  id="'.$row["id_pedido"].'" class="btn btn-md btn-default update hint--top" aria-label="Agregar Detalle" ><i class="fa fa-plus"></i></button>&nbsp;';

          $boton_editar = '<button type="button" onClick="mostrar('.$row["id_pedido"].');"  id="'.$row["id_pedido"].'" class="btn btn-primary btn-md update hint--top" aria-label="Editar Pedido"><i class="fa fa-pencil-square-o"></i></button>&nbsp;';
  
          $boton_eliminar= '<button type="button" onClick="eliminar('.$row["id_pedido"].');"  id="'.$row["id_pedido"].'" class="btn btn-danger btn-md hint--top" aria-label="Eliminar Pedido"><i class="fa fa-trash"></i></button></div>';
            
       ?>
          <?php  
          if(in_array("REPEDI",$valores) and in_array("EDPEDI",$valores)and in_array("ELPEDI",$valores)){
                 $sub_array[]='<div class="cbtns">'.$boton_registrar.''.$boton_editar.''.$boton_eliminar.'</div>';
                 }elseif (in_array("EDPEDI",$valores) and in_array("ELPEDI",$valores)) {
                 $sub_array[]='<div class="cbtns">'.$boton_editar.' '.$boton_eliminar.'</div>';

               } elseif(in_array("REPEDI",$valores) and in_array("ELPEDI",$valores)) {
                 $sub_array[]='<div class="cbtns">'.$boton_registrar.' '.$boton_eliminar.'</div>';

              } elseif (in_array("EDPEDI",$valores) and in_array("REPEDI",$valores)) {
                 $sub_array[]='<div class="cbtns">'.$boton_editar.' '.$boton_registrar.'</div>';

              
              } elseif (in_array("REPEDI",$valores)) {
                 $sub_array[]='<div class="cbtns">'.$boton_registrar.'</div>';
              }elseif(in_array("EDPEDI",$valores)){
                       $sub_array[]='<div class="cbtns">'.$boton_editar.'</div>';
              }elseif(in_array("ELPEDI",$valores)){
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

    //listar detallecapacitados
    case 'listardetalle':
      $datos = $detallepedidos->get_detallepedido($_POST["id_pedido"]);
       $rol=$usuario->listar_roles_por_usuario($_SESSION['id_usuario']);
      $valores=array();

      //Almacenamos los permisos marcados en el array
foreach($rol as $rows){

              $valores[]= $rows["codigo"];
          }
      $data = Array();

        foreach($datos as $row){

          $sub_array = array();
          $sub_array[] = $row["nombreInsumo"];
          $sub_array[] = $row["cantidad"];
          $sub_array[] = $row["descripcion"];
          $sub_array[] = $row["nombre"];
        
            $boton_editar= '<button type="button" onClick="mostrardetalle('.$row["id_detallepedido"].');"  id="'.$row["id_detallepedido"].'" class="btn btn-primary btn-md update hint--top" aria-label="Editar Insumo"><i class="fa fa-pencil-square-o"></i></button>&nbsp;';

            $boton_eliminar= '<button type="button" onClick="eliminar('.$row["id_detallepedido"].');"  id="'.$row["id_detallepedido"].'" class="btn btn-danger btn-md hint--top" aria-label="Eliminar Insumo"><i class="fa fa-trash"></i></button>';
    
       ?>
          <?php  
          if(in_array("EDPEDI",$valores) and in_array("ELPEDI",$valores)){
                 $sub_array[]='<div class="cbtns">'.$boton_editar.''.$boton_eliminar.'</div>';
               }
            elseif (in_array("EDPEDI",$valores)) {
                 $sub_array[]='<div class="cbtns">'.$boton_editar.'</div>';
              }elseif(in_array("EDPEDI",$valores)){
                       $sub_array[]='<div class="cbtns">'.$boton_editar.'</div>';
              }elseif(in_array("ELPEDI",$valores)){
                  $sub_array[]='<div class="cbtns">'.$boton_eliminar.'</div>';

              }else{
                $sub_array[]='<div class="cbtns"></div>';
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

    case "eliminar_pedidos":

      $datos= $pedidos->get_pedido_por_id($_POST["id_pedido"]);
  
      if(is_array($datos)==true and count($datos)>0){
          $pedidos->eliminar_pedidos($_POST["id_pedido"]);
          $pedidos->eliminar_pedido($_POST["id_pedido"]);
          $messages[]="El pedido se eliminó exitosamente";
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

    //eliminar detallepedido
    case "eliminar_detallepedidos":

        $datos = $detallepedidos->get_detallepedido_por_id($_POST["id_detallepedido"]);

        if(is_array($datos)==true and count($datos)>0){
              $detallepedidos->eliminar_detallepedido($_POST["id_detallepedido"]);
              $messages[]="El registro se eliminó exitosamente";
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


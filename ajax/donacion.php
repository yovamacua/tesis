<?php 
  //llamar a la conexion de la base de datos
  require_once("../config/conexion.php");
 
  //llamar al modelo Donaciones
  require_once("../modelos/Donaciones.php");

  //Declaramos las variables de los valores que se envian por el formulario y que recibimos por ajax y decimos  que si existe el parametro que estamos recibiendo

  $donaciones = new Donaciones();
 
  $id_donacion = isset($_POST["id_donacion"]);
  $fecha = isset($_POST["fecha"]);
  $donante = isset($_POST["donante"]);
  $descripcion = isset($_POST["descripcion"]);
  $cantidad = isset($_POST["cantidad"]);
  $id_usuario=isset($_POST["id_usuario"]);
 
switch ($_GET["op"]) { 

  case 'guardaryeditar':
    $datos = $donaciones->get_donaciones_por_id($_POST["id_donacion"]);
          /*si el titulo no existe entonces lo registra
          importante: se debe poner el $_POST sino no funciona*/
          if(empty($_POST["id_donacion"])){
            /*verificamos si la donacion existe en la base de datos, si ya existe un registro con la donacion entonces no se registra*/
            if(is_array($datos)==true and count($datos)==0){
                      //no existe la donacion por lo tanto hacemos el registros
            $donaciones->registrar_donaciones($fecha, $donante, $descripcion, $cantidad, $id_usuario);
                      
                      $messages[]="La donación se registró correctamente";
            }else {
              
              $errors[]="Existe una donación con el mismo id";
            }

          }else {
                /*si ya existe entonces editamos la donacion*/
               $donaciones-> editar_donacion($id_donacion, $fecha, $donante, $descripcion, $cantidad, $id_usuario);

                  $messages[]="La donación se editó correctamente";
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
    break;
    
    case 'mostrar':
      # selecciona el id de la donacion
      //el parametro id_donacion se envia por AJAX cuando se edita la donacion
      $datos = $donaciones->get_donaciones_por_id($_POST["id_donacion"]);
      if(is_array($datos)==true and count($datos)>0){

        foreach ($datos as $row) {
        
          $output["fecha"] = $row["fecha"];
          $output["donante"] = $row["donante"];
          $output["descripcion"] = $row["descripcion"];
          $output["cantidad"] = $row["cantidad"];
          
        }
          echo json_encode($output);

      }else{
        //si no existe el registro no se recorre el array
        $errors[] = "No existe una donación con ese id";

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
 
    case 'listar':
      $datos=$donaciones->get_donaciones();
      $data= Array();

        foreach($datos as $row){
            $sub_array = array();
          
            $sub_array[] = $row["fecha"];
          $sub_array[] = $row["donante"];
          $sub_array[] = $row["descripcion"];
          $sub_array[] = $row["cantidad"];
          $sub_array[] = '<div class="cbtns">
          <button type="button" onClick="mostrar('.$row["id_donacion"].');"  id="'.$row["id_donacion"].'" class="btn btn-primary btn-md update hint--top" aria-label="Editar Donación" ><i class="fa fa-pencil-square-o"></i></button>
          <button type="button" onClick="eliminar('.$row["id_donacion"].');"  id="'.$row["id_donacion"].'" class="btn btn-danger btn-md hint--top" aria-label="Eliminar Donación "><i class="glyphicon glyphicon-edit"></i></button></div>';
            $data[] = $sub_array;
          }

          $results = array(
          "sEcho"=>1, //Información para el datatables
          "iTotalRecords"=>count($data), //enviamos el total registros al datatable
          "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
          "aaData"=>$data);

          echo json_encode($results);
    break;

    case "eliminar_donacion":

        $datos = $donaciones->get_donaciones_por_id($_POST["id_donacion"]);

        if(is_array($datos)==true and count($datos)>0){
              $donaciones->eliminar_donacion($_POST["id_donacion"]);
              $messages[]="El registro de la donación se eliminó exitosamente";
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
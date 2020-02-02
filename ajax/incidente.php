<?php
//llamo a la conexion de la base de datos
require_once "../config/conexion.php";
require_once "../modelos/Incidentes.php";
require_once("../modelos/Roles.php");
require_once "mensajes.php";

//objeto de tipo Incidentes
$incidentes = new Incidentes();
$usuario = new Roles();

$id_incidente = isset($_POST["id_incidente"]);
$titulo       = isset($_POST["titulo"]);
$descripcion  = isset($_POST["descripcion"]);
$fecha        = isset($_POST["fecha"]);
$id_usuario   = isset($_POST["id_usuario"]);

switch ($_GET["op"]) {
    case "guardaryeditar":

        // se reciben las variables y se valida si el formato es correcto
        if (!preg_match('/^[a-záéíóúñA-ZÁÉÍÓÚÑ\s]*$/', $_POST["titulo"]) or
            !preg_match('/^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9.:,¿?!¡\s]*$/', $_POST["descripcion"]) or $_POST["fecha"] == '') {
            $errors[] = "Formatos de Información no validos";
            echo error($errors);
        } else {

            $datos = $incidentes->get_nombre_incidentes($_POST["titulo"]);
            /*si el incidente no existe entonces lo registra*/
            if (empty($_POST["id_incidente"])) {
                $incidentes->registrar_incidentes($titulo, $descripcion, $fecha, $id_usuario);
                $messages[] = "El incidente se registró correctamente";
                //cierre de validacion
                /*si ya existes el titulo del incidente entonces aparece el mensaje*/
            } //cierre de empty

            else {
                /*si ya existe entonces editamos el incidente*/
                $incidentes->editar_incidentes($id_incidente, $titulo, $descripcion, $fecha, $id_usuario);
                $messages[] = "El incidente se editó correctamente";
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
        //el parametro id_incidente se envia por AJAX cuando se edita la categoria
        $datos = $incidentes->get_incidentes_por_id($_POST["id_incidente"]);
        // si existe el id del incidnete entonces recorre el array
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["id_incidente"] = $row["id_incidente"];
                $output["titulo"]       = $row["titulo"];
                $output["descripcion"]  = $row["descripcion"];
                $output["fecha"]        = date("d-m-Y",strtotime($row["fecha"]));
            }
            echo json_encode($output);
        } else {
            //si no existe la categoria entonces no recorre el array
            $errors[] = "El incidente no existe";
        }

        //mensaje error
        if (isset($errors)) {
            echo error($errors);
        }
        //fin de mensaje de error
        break;
    case "listar":
        $datos = $incidentes->get_incidentes();
        $rol=$usuario->listar_roles_por_usuario($_SESSION['id_usuario']);
      $valores=array();

      //Almacenamos los permisos marcados en el array
foreach($rol as $rows){

              $valores[]= $rows["codigo"];
          }
        $data  = array();

        foreach ($datos as $row) {
            $sub_array   = array();
            $sub_array[] = $row["titulo"];
            $sub_array[] = $row["descripcion"];
            $sub_array[] = $row["usuario"];
            $sub_array[] =  date("d/m/Y", strtotime($row["fecha"]));

                          $boton_editar='<div class="cbtns"><button type="button" onClick="mostrar(' . $row["id_incidente"] . ');"  id="' . $row["id_incidente"] . '" class="btn btn-primary btn-md update hint--top" aria-label="Editar"><i class="fa fa-pencil-square-o"></i></button>&nbsp';

                           $boton_eliminar='<button type="button" onClick="eliminar(' . $row["id_incidente"] . '); desvanecer()"  id="' . $row["id_incidente"] . '" class="btn btn-danger btn-md hint--top" aria-label="Eliminar"><i class="fa fa-trash"></i></button>

            </div>';
  ?>
          <?php  
          if(in_array("EDINCI",$valores) and in_array("ELINCI",$valores)){
                 $sub_array[]='<div class="cbtns">'.$boton_editar.''.$boton_eliminar.'</div>';
               }
            elseif (in_array("EDINC",$valores)) {
                 $sub_array[]='<div class="cbtns">'.$boton_editar.'</div>';
              }elseif(in_array("ELINC",$valores)){
                  $sub_array[]='<div class="cbtns">'.$boton_eliminar.'</div>';

              }else{
                $sub_array[]='<div class="cbtns badge bg-red-active"> No Acciones</div>';
              }
            
              
      ?>
         
          
      <?php    
            $data[] = $sub_array;
        }

        $results = array(
            "sEcho"                => 1, //Información para el datatables
            "iTotalRecords"        => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData"               => $data);
        echo json_encode($results);

        break;

    case "eliminar_incidente":

        $datos = $incidentes->get_incidentes_por_id($_POST["id_incidente"]);
        if (is_array($datos) == true and count($datos) > 0) {
            $incidentes->eliminar_incidente($_POST["id_incidente"]);
            $messages[] = "El registro del incidente se eliminó exitosamente";
        } else {
            $errors[] = "No hay registro que borrar";
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
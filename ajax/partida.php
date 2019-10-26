<?php
//llamo a la conexion de la base de datos
require_once "../config/conexion.php";
require_once "../modelos/partidas.php";
require_once "../modelos/Cuenta.php";
require_once "mensajes.php";

//objeto de tipo partidas
$partidas = new partidas();
$cuenta   = new cuentas();

$id_partida    = isset($_POST["id_partida"]);
$nombrepartida = isset($_POST["nombrepartida"]);
$responsable   = isset($_POST["responsable"]);
$id_usuario    = isset($_POST["id_usuario"]);

if (!isset($_SESSION['id_usuario'])) {?>
        <script type="text/javascript">
        window.location="../vistas/home.php";
        </script>
    <?php
}

switch ($_GET["op"]) {
    case "guardaryeditar":

        // se reciben las variables y se valida si el formato es correcto
        if (!preg_match('/^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9.:,¿?!¡\s]*$/', $_POST["nombrepartida"]) or
            !preg_match('/^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9.:,¿?!¡\s]*$/', $_POST["responsable"])) {
            $errors[] = "Formatos de Información no validos";
            echo error($errors);
        } else {

            $datos = $partidas->get_nombre_partidas($_POST["nombrepartida"]);

            /*si el titulo no existe entonces lo registra
            importante: se debe poner el $_POST sino no funciona*/
            if (empty($_POST["id_partida"])) {
                /*verificamos si existe en la base de datos, si ya existe un registro entonces no se registra*/

                //no existe  por lo tanto hacemos el registros
                $partidas->registrar_partidas($nombrepartida, $responsable, $id_usuario);
                $messages[] = "La partida se registró correctamente";
                //cierre de validacion de $datos
                /*si ya existes entonces aparece el mensaje*/
            } //cierre de empty

            else {
                /*si ya existe entonces editamos el partida*/
                $partidas->editar_partidas($id_partida, $nombrepartida, $responsable, $id_usuario);
                $messages[] = "El partida se editó correctamente";
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
        //selecciona del partida
        //el parametro id_partida se envia por AJAX cuando se edita la categoria
        $datos = $partidas->get_partidas_por_id($_POST["id_partida"]);
        // si existe el id del incidnete entonces recorre el array
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["id_partida"]    = $row["id_partida"];
                $output["nombrepartida"] = $row["nombrepartida"];
                $output["responsable"]   = $row["responsable"];
            }
            echo json_encode($output);
        } else {
            //si no existe la categoria entonces no recorre el array
            $errors[] = "La partida no existe";
        }

        //mensaje error
        if (isset($errors)) {
            echo error($errors);
        }
        //fin de mensaje de error
        break;
    case "listar":
        $iduse = $_SESSION["id_usuario"];
        $datos = $partidas->get_partidas($iduse);
        $data  = array();

        foreach ($datos as $row) {
            $sub_array   = array();
            $sub_array[] = $row["nombrepartida"];
            $sub_array[] = $row["responsable"];
            $sub_array[] = '<div class="cbtns">
            <a href="cuenta.php?id=' . $row["id_partida"] . '&partida=' . $row["nombrepartida"] . '"><button type="button" class="btn btn-primary btn-md"><i class="glyphicon glyphicon-edit"></i> Administrar Cuenta</button></a></div>';
            $sub_array[] = '
            <div class="cbtns"><button type="button" onClick="mostrar(' . $row["id_partida"] . ');"  id="' . $row["id_partida"] . '" class="btn btn-primary btn-md update hint--top" aria-label="Editar"><i class="fa fa-pencil-square-o"></i></button>&nbsp;

            <button type="button" onClick="eliminar(' . $row["id_partida"] . ');"  id="' . $row["id_partida"] . '" class="btn btn-danger btn-md hint--top" aria-label="Eliminar"><i class="fa fa-trash"></i></button>
            </div>';
            $data[] = $sub_array;
        }

        $results = array(
            "sEcho"                => 1, //Información para el datatables
            "iTotalRecords"        => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData"               => $data);
        echo json_encode($results);

        break;

    case "eliminar_partida":
        $cue = $cuenta->get_cuenta_por_id_partida($_POST["id_partida"]);

        if (is_array($cue) == true and count($cue) > 0) {
            //si existe el usuario en las tablas, no se elimina.
            $errors[] = "Esta partida no esta vacia, elimine todas la cuentas asociadas para eliminar la partida";
        } else {
            $datos = $partidas->get_partidas_por_id($_POST["id_partida"]);
            if (is_array($datos) == true and count($datos) > 0) {
                $partidas->eliminar_partida($_POST["id_partida"]);
                $messages[] = "El registro de la partida se eliminó exitosamente";
            } else {
                $errors[] = "No hay registro que borrar";
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
        break;
}

<?php

//llamar a la conexion de la base de datos
require_once "../config/conexion.php";

/*llamar a todo los modelos de tablas asociados al usuario
para verificar si el usuario tiene registros asociados en las tablas de la base de datos*/
require_once "../modelos/Incidentes.php";
require_once "../modelos/Partidas.php";

/*AGREGAR LAS TABLAS QUE FALTAN AL TERMINAR PROYECTO */

//llamar a el modelo Usuarios
require_once "../modelos/Usuarios.php";

require_once "mensajes.php";
//se crea un objeto de tipo usuario
$usuarios = new Usuarios();

//se declaran las variables de los valores que se envian por el formulario
//y se valida que no se esten recibiendo vacias

//este es el que se envia del formulario
$id_usuario = isset($_POST["id_usuario"]);

$nombre    = isset($_POST["nombre"]);
$apellido  = isset($_POST["apellido"]);
$email     = isset($_POST["email"]);
$cargo     = isset($_POST["cargo"]);
$usuario   = isset($_POST["usuario"]);
$password1 = isset($_POST["password1"]);
$password2 = isset($_POST["password2"]);
$estado = isset($_POST["estado"]);

// switch para seleccionar opcion segun parametro enviado en la url
switch ($_GET["op"]) {
    case "guardaryeditar":

// se reciben las variables y se valida si el formato es correcto
if (!preg_match('/^[a-záéíóúñA-ZÁÉÍÓÚÑ\s]*$/', $_POST["nombre"]) or
            !preg_match('/^[a-záéíóúñA-ZÁÉÍÓÚÑ\s]*$/', $_POST["apellido"]) or
            !preg_match('/^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9\s]*$/', $_POST["usuario"]) or
            $_POST["cargo"] < 0 or
            !preg_match('/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/', $_POST["email"]) or
            $_POST["estado"] < 0 or
            !preg_match('/^(?=.*\d)(?=.*[A-Za-z])(?=.*[!@#$%])[0-9A-Za-z!@#$%]{6,15}$/', $_POST["password1"]) or 
            !preg_match('/^(?=.*\d)(?=.*[A-Za-z])(?=.*[!@#$%])[0-9A-Za-z!@#$%]{6,15}$/', $_POST["password2"])) {
            $errors[] = "Formatos de Información no validos";
            echo error($errors);
        } else {
            /*verificamos si existe correo en la base de datos
            si ya existe un registro con esecorreo entonces no se registra el usuario*/

            $datos = $usuarios->get_correo_del_usuario($_POST["email"]);
            //validacion que los 2 password enviados sean iguales
            if ($password1 == $password2) {

                if (empty($_POST["id_usuario"])) {
                    /*si coincide password1 y password2 entonces verificamos si ya
                    existe el correo en la base de datos, si existe no se registra el usuario*/
                    if (is_array($datos) == true and count($datos) == 0) {
                        //no existe el usuario por lo tanto hacemos el registros
                        $usuarios->registrar_usuario($nombre, $apellido, $email, $cargo, $usuario, $password1, $password2, $estado);
                        /*si se registra el usuario aparece siguente mensaje*/
                        $messages[] = "El usuario se registró correctamente";
                    } else {
                        /*si NO se registra el usuario aparece siguente mensaje*/
                        $messages[] = "El correo ya esta registrado";
                    }
                } //cierre de la validacion empty que valida el id usuario no sea vacio
                else {
                    /*si ya existe entonces editamos el usuario*/
                    $usuarios->editar_usuario($id_usuario, $nombre, $apellido, $email, $cargo, $usuario, $password1, $password2, $estado);
                    /*si edita el usuario aparece siguente mensaje*/
                    $messages[] = "La informacion se actualizo correctamente";
                }
            } else {
                /*si las 2 constraseñas no coinciden, entonces se muestra el mensaje de error*/
                $errors[] = "El password no coincide";
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
            // fin validacion
        }
        //fin mensaje error
        // fin bloque de mensaje de notificacion
        break; // fin del primer caso

//inicio otro caso
    case "mostrar":
        //selecciona el id del usuario
        //el parametro id_usuario se envia por AJAX cuando se edita el usuario
        $datos = $usuarios->get_usuario_por_id($_POST["id_usuario"]);
        //validacion del id del usuario
        if (is_array($datos) == true and count($datos) > 0) {
            //recorriendo todas la posiciones del array
            foreach ($datos as $row) {
                //nombre cualquier / campo bd, trata de usar siempre los mismo en ambos lados
                $output["nombre"]    = $row["nombres"];
                $output["apellido"]  = $row["apellidos"];
                $output["correo"]    = $row["correo"];
                $output["cargo"]     = $row["cargo"];
                $output["usuario"]   = $row["usuario"];
                $output["password1"] = $row["password"];
                $output["password2"] = $row["password2"];
                $output["estado"]    = $row["estado"];
             }
            //devuelve datos de registro de usuario

            echo json_encode($output);
        } else {
            //si no existe el registro entonces no recorre el array
            $errors[] = "El usuario no existe";

        }
        //mensaje error
        if (isset($errors)) {
            echo error($errors);
        }
        //fin de mensaje de error
        // inicio caso
        break;
    case "activarydesactivar":
        //los parametros id_usuario y estado vienen por via ajax
        $datos = $usuarios->get_usuario_por_id($_POST["id_usuario"]);
        //valida el id del usuario
        if (is_array($datos) == true and count($datos) > 0) {
            //edita el estado del usuario
            $usuarios->editar_estado($_POST["id_usuario"], $_POST["est"]);
        }
        break;

//inicio caso
    case "listar":
        $datos = $usuarios->get_usuarios();
        //declaramos el array
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $est       = '';
            //imprimir palabra en vez de el numero 0 o 1
            $atrib = "btn btn-success btn-md estado";
            if ($row["estado"] == 0) {
                $est   = '<i class="fa fa-power-off" aria-hidden="true"></i>';
                $atrib = "btn btn-dark btn-md estado";
            } else {
                if ($row["estado"] == 1) {
                    $est = '<i class="fa fa-power-off" aria-hidden="true"></i>';

                }
            }

//imprimr la palabra en vez del numero
            if ($row["cargo"] == 1) {
                $cargo = "ADMINISTRADOR";
            } else {
                if ($row["cargo"] == 0) {
                    $cargo = "EMPLEADO";
                }
            }
            //campos de la tabla usuario
            $sub_array[] = $row["nombres"];
            $sub_array[] = $row["apellidos"];
            $sub_array[] = $row["usuario"];
            $sub_array[] = $row["correo"];
            $sub_array[] = $cargo;
            //se formate el la fecha, tipo y formato
            $sub_array[] = date("d-m-Y", strtotime($row["fecha_ingreso"]));
            //botones con valores de los campos en el id
            $sub_array[] = '<div class="cbtns"><button type="button" onClick="cambiarEstado(' . $row["id_usuario"] . ',' . $row["estado"] . ');" name="estado" id="' . $row["id_usuario"] . '" class="' . $atrib . ' hint--top" aria-label="Cambiar Estado">' . $est . '</button>

 <button type="button" onClick="mostrar(' . $row["id_usuario"] . ');"  id="' . $row["id_usuario"] . '" class="btn btn-primary btn-md update hint--top" aria-label="Editar Cuenta" ><i class="fa fa-pencil-square-o"></i></button>

<button type="button" onClick="pass(' . $row["id_usuario"] . ');"  id="' . $row["id_usuario"] . '" class="btn btn-warning btn-md hint--top" aria-label="Editar Contraseña" ><i class="fa fa-key"></i></button>


      <button type="button" onClick="eliminar(' . $row["id_usuario"] . ');"  id="' . $row["id_usuario"] . '" class="btn btn-danger btn-md hint--top" aria-label="Eliminar Cuenta "><i class="fa fa-trash"></i></button></div>';
            $data[] = $sub_array;
        }

        //"configuraciones" para el data table
        $results = array(
            "sEcho"                => 1, //Información para el datatables
            "iTotalRecords"        => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData"               => $data);
        echo json_encode($results);
        break;

    case "eliminar_usuario":

        //verificamos si el usuario existe en las tablas si existe entonces el usuario no se elimina,
        // si no existe entonces se puede eliminar el usuario
        $incidente = new Incidentes();
        $partida   = new Partidas();

        $inc = $incidente->get_incidente_por_id_usuario($_POST["id_usuario"]);
        $par = $partida->get_partida_por_id_usuario($_POST["id_usuario"]);

        if (
            is_array($inc) == true and count($inc) > 0 or
            is_array($par) == true and count($par) > 0
        ) {
            //si existe el usuario en las tablas, no se elimina.
            $errors[] = "El usuario existe en los registros, no se puede eliminar";
        } //fin

        else {
            $datos = $usuarios->get_usuario_por_id($_POST["id_usuario"]);
            //si el usuario no existe en las tablas de la bd y que existe en la tabla de usuario entonces se elimina
            if (is_array($datos) == true and count($datos) > 0) {
                $usuarios->eliminar_usuario($_POST["id_usuario"]);
                $messages[] = "El usuario se eliminó exitosamente";
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

}

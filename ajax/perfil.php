<?php

//llamo a la conexion de la base de datos
require_once "../config/conexion.php";
require_once "mensajes.php";
//llamo al modelo Perfil
require_once "../modelos/Perfil.php";
$perfil = new Perfil();
//declaramos las variables de los valores que se envian por el formulario y que recibimos por ajax y decimos que si existe el parametro que estamos recibiendo
//los valores vienen del atributo name de los campos del formulario
/*el valor id_usuario_perfil se carga en el campo hidden cuando se edita un registro*/

//declaracion de variables que vienen del formulario del perfil usuario
$id_usuario_perfil = isset($_POST["id_usuario_perfil"]);
$nombre_perfil     = isset($_POST["nombre_perfil"]);
$apellido_perfil   = isset($_POST["apellido_perfil"]);
$email_perfil      = isset($_POST["email_perfil"]);

$usuario_perfil   = isset($_POST["usuario_perfil"]);
$password1_perfil = isset($_POST["password1_perfil"]);
$password2_perfil = isset($_POST["password2_perfil"]);
$usuario_imagen   = isset($_POST["hidden_usuario_imagen"]);

if (!isset($_SESSION['id_usuario'])) {?>
        <script type="text/javascript">
        window.location="../vistas/home.php";
        </script>
    <?php
}

switch ($_GET["op"]) {

    case 'quitar_imagen':
        if (isset($_SESSION['id_usuario'])) {
            $datos = $perfil->quitar_imagen();
        }
        ?>
         <script type="text/javascript">
        window.location="../vistas/mi_perfil.php?m=2";
        </script>
        <?php
break;

    case 'mostrar_perfil':
        //selecciona el id del usuario
        $datos = $perfil->get_usuario_por_id($_POST["id_usuario_perfil"]);
        // si existe el id del usuario entonces recorre el array
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["nombre"]         = $row["nombres"];
                $output["apellido"]       = $row["apellidos"];
                $output["usuario_perfil"] = $row["usuario"];
                $output["password1"]      = $row["password"];
                $output["password2"]      = $row["password2"];
                $output["correo"]         = $row["correo"];
                if ($row["usuario_imagen"] != '') {
                    $output['usuario_imagen'] = '<img src="upload/' . $row["usuario_imagen"] . '" class="img-thumbnail" width="150" height="25" /><input type="hidden" name="hidden_usuario_imagen" value="' . $row["usuario_imagen"] . '" />';
                } else {
                    $output['usuario_imagen'] = '<input type="hidden" name="hidden_usuario_imagen" value="" />';
                }
            }
            echo json_encode($output);
        } else {
            //si no existe el registro entonces no recorre el array
            $errors[] = "El usuario no existe";
        }
        //inicio de mensaje de error
        if (isset($errors)) {
            echo error($errors);
        }
        //fin de mensaje de error
        break;

    case 'editar_perfil':

     if (!preg_match('/^[a-záéíóúñA-ZÁÉÍÓÚÑ\s]*$/', $_POST["nombre_perfil"]) or
            !preg_match('/^[a-záéíóúñA-ZÁÉÍÓÚÑ\s]*$/', $_POST["apellido_perfil"]) or
            !preg_match('/^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9\s]*$/', $_POST["usuario_perfil"]) or
            !preg_match('/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/', $_POST["email_perfil"]) or
            !preg_match('/^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9\s]*$/', $_POST["password1_perfil"]) or
            !preg_match('/^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9\s]*$/', $_POST["password2_perfil"])) 
     {
            $errors[] = "Formatos de Información no validos";
            echo error($errors);
    }else{

        //verificamos si el usuario existe en la base de datos, si ya existe un registro con la cedula, nombre o correo entonces no lo registra
        $datos = $perfil->get_usuario_nombre($_POST["email_perfil"]);

        //verificamos si el password1 coincide con el password2, si se cumple entonces verificamos si existe un registro con los datos enviados y en caso que no existe entonces se registra el usuario
        if ($_POST["password1_perfil"] == $_POST["password2_perfil"]) {
            if (is_array($datos) == true and count($datos) > 0) {
                //si ya existe entonces editamos el usuario y sus permisos

                $perfil->editar_perfil($id_usuario_perfil, $nombre_perfil, $apellido_perfil, $email_perfil, $usuario_perfil, $password1_perfil, $password2_perfil, $usuario_imagen);
                $_SESSION["nombre"] = $_POST["nombre_perfil"];
            } //cierre condicional $datos
        } //cierre de condicional del password
        else {?>
               <script type="text/javascript">
  bootbox.alert({
    message: "Fallo la actualización, intentelo de nuevo",
    callback: function () {
        location.reload();
    }
})
        </script>
        <?php
        }
    }
}
?>

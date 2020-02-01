<?php
//conexión a la base de datos
require_once "../config/conexion.php";

#valida que exista la sessión
if (!isset($_SESSION['id_usuario'])) {?>
        <script type="text/javascript">
        window.location="../vistas/home.php";
        </script>
    <?php
}

class Perfil extends Conectar
{
    //método para mostrar los datos de un registro a modificar
    public function get_usuario_por_id($id_usuario)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "Select * from usuarios as u inner join perfil p on p.idperfil = u.idperfiles where u.id_usuario=?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_usuario);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    function quitar_imagen()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $elimagen       = $_SESSION['id_usuario'];
        $sql            = "update usuarios set usuario_imagen=? where id_usuario=?";
        $sql            = $conectar->prepare($sql);
        $usuario_imagen = 'imagen_usuario_general.png';
        $sql->bindValue(1, $usuario_imagen);
        $sql->bindValue(2, $elimagen);
        $sql->execute();
        $_SESSION["imagen"] = $usuario_imagen;
        return $resultado   = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    function get_usuario_nombre($email)
    {
        $conectar = parent::conexion();
        $sql      = "select * from usuarios where correo=?";
        $sql      = $conectar->prepare($sql);
        $sql->bindValue(1, $email);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    function upload_image($user, $numero)
    {
        if (isset($_FILES["usuario_imagen"])) {
            $string  = $_FILES['usuario_imagen']['name'];
            $lastDot = strrpos($string, ".");
            $string  = str_replace(".", "", substr($string, 0, $lastDot)) . substr($string, $lastDot);

            $extension   = explode('.', $string);
            $new_name    = $user . $numero . "." . $extension[1];
            $destination = '../vistas/upload/' . $new_name;
            if (file_exists($destination)) {
                unlink($destination);
            }

            move_uploaded_file($_FILES['usuario_imagen']['tmp_name'], $destination);
            return $new_name;
        }
    }

    function editar_perfil($id_usuario_perfil, $nombre_perfil, $apellido_perfil, $email_perfil, $usuario_perfil, $password1_perfil, $password2_perfil, $usuario_imagen)
    {
        $conectar = parent::conexion();
        parent::set_names();

        require_once "Perfil.php";
        $subirimg = new Perfil();
        if ($_FILES["usuario_imagen"]["name"] != '' and
            round(intval($_FILES['usuario_imagen']['size']) / 1048576, 2) < 1) {
            $usuario_imagen = $subirimg->upload_image($_POST["nombre_perfil"], $_POST["id_usuario_perfil"]);
        } else {
            $usuario_imagen = $_POST["hidden_usuario_imagen"];
        }

        if ($_POST["password1_perfil"] == '123456axxxxx' and $_POST["password2_perfil"] == '123456axxxxx') {
            $sql = "update usuarios set nombres=?, apellidos=?,
          correo=?, usuario=?, usuario_imagen = ? where id_usuario=?";

            $sql = $conectar->prepare($sql);

            $sql->bindValue(1, substr($_POST["nombre_perfil"], 0, 50));
            $sql->bindValue(2, substr($_POST["apellido_perfil"], 0, 50));
            $sql->bindValue(3, substr($_POST["email_perfil"], 0, 100));
            $sql->bindValue(4, substr($_POST["usuario_perfil"], 0, 100));
            $sql->bindValue(5, $usuario_imagen);
            $sql->bindValue(6, $_POST["id_usuario_perfil"]);
            $_SESSION["imagen"] = $usuario_imagen;
            $sql->execute();
        } else {
            $sql = "update usuarios set nombres=?, apellidos=?,
          correo=?, usuario=?, password=?, password2=?, usuario_imagnen = ?  where id_usuario=?";

            $sql = $conectar->prepare($sql);

$encriptar1 = crypt($_POST["password1_perfil"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
$encriptar2 = crypt($_POST["password2_perfil"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

            $sql->bindValue(1, substr($_POST["nombre_perfil"], 0, 50));
            $sql->bindValue(2, substr($_POST["apellido_perfil"], 0, 50));
            $sql->bindValue(3, substr($_POST["email_perfil"], 0, 100));
            $sql->bindValue(4, substr($_POST["usuario_perfil"], 0, 100));
            $sql->bindValue(5, $encriptar1);
            $sql->bindValue(6, $encriptar2);
            $sql->bindValue(7, $usuario_imagen);
            $sql->bindValue(8, $_POST["id_usuario_perfil"]);
            $sql->execute();
        }
    }
}

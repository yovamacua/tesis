<?php
//conexión a la base de datos
require_once "../config/conexion.php";

class Perfil extends Conectar
{
    //método para mostrar los datos de un registro a modificar
    public function get_usuario_por_id($id_usuario)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "select * from usuarios where id_usuario=?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_usuario);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function quitar_imagen()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $elimagen = $_SESSION['id_usuario'];
        $sql      = "update usuarios set usuario_imagen=? where id_usuario=?";
        $sql      = $conectar->prepare($sql);
        $usuario_imagen = 'imagen_usuario_general.png';
        $sql->bindValue(1, $usuario_imagen);
        $sql->bindValue(2, $elimagen);
        $sql->execute();
        $_SESSION["imagen"] = $usuario_imagen;
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
    }

      public function get_usuario_nombre($email)
    {
        $conectar = parent::conexion();
        $sql      = "select * from usuarios where correo=?";
        $sql      = $conectar->prepare($sql);
        $sql->bindValue(1, $email);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function upload_image($user) {
            if(isset($_FILES["usuario_imagen"]))
            {

            $string = $_FILES['usuario_imagen']['name'];
            $lastDot = strrpos($string, ".");
            $string = str_replace(".", "", substr($string, 0, $lastDot)) . substr($string, $lastDot);

              $extension = explode('.', $string);
              $new_name = $user.".".$extension[1];
              $destination = '../vistas/upload/' . $new_name;
              if (file_exists($destination)) {
                unlink($destination);
              }
  
              move_uploaded_file($_FILES['usuario_imagen']['tmp_name'], $destination);
              return $new_name;
            }
          }

    public function editar_perfil($id_usuario_perfil, $nombre_perfil, $apellido_perfil, $email_perfil, $usuario_perfil, $password1_perfil, $password2_perfil,$usuario_imagen)
    {
        $conectar = parent::conexion();
        parent::set_names();

         require_once("Perfil.php");
            $subirimg = new Perfil();                
            $usuario_imagen = '';
            if($_FILES["usuario_imagen"]["name"] != '')
            {
              $usuario_imagen = $subirimg->upload_image($_POST["nombre_perfil"]);
            }else
             {          
            $usuario_imagen= $_POST["hidden_usuario_imagen"];
            }

        if ($_POST["password1_perfil"] == '@123456a' and $_POST["password2_perfil"] == '@123456a') {
            $sql = "update usuarios set nombres=?, apellidos=?,
          correo=?, usuario=?, usuario_imagen = ? where id_usuario=?";

            //echo $sql;

            $sql = $conectar->prepare($sql);

            $sql->bindValue(1, $_POST["nombre_perfil"]);
            $sql->bindValue(2, $_POST["apellido_perfil"]);
            $sql->bindValue(3, $_POST["email_perfil"]);
            $sql->bindValue(4, $_POST["usuario_perfil"]);
            $sql->bindValue(5, $usuario_imagen);
            $sql->bindValue(6, $_POST["id_usuario_perfil"]);
            $_SESSION["imagen"] = $usuario_imagen;
            $sql->execute();
        } else {
            $sql = "update usuarios set nombres=?, apellidos=?,
          correo=?, usuario=?, password=?, password2=?, usuario_imagnen = ?  where id_usuario=?";

            $sql = $conectar->prepare($sql);

            $sql->bindValue(1, $_POST["nombre_perfil"]);
            $sql->bindValue(2, $_POST["apellido_perfil"]);
            $sql->bindValue(3, $_POST["email_perfil"]);
            $sql->bindValue(4, $_POST["usuario_perfil"]);
            $sql->bindValue(5, sha1($_POST["password1_perfil"]));
            $sql->bindValue(6, sha1($_POST["password2_perfil"]));
            $sql->bindValue(7, $usuario_imagen);
            $sql->bindValue(8, $_POST["id_usuario_perfil"]);
            $sql->execute();
        }
    }
}

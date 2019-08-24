<?php

  //conexión a la base de datos
   require_once("../config/conexion.php");

   class Perfil extends Conectar{
           //método para mostrar los datos de un registro a modificar
        public function get_usuario_por_id($id_usuario){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="select * from usuarios where id_usuario=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_usuario);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_nombre($email){
          $conectar=parent::conexion();
          $sql= "select * from usuarios where correo=?";
          $sql=$conectar->prepare($sql);
          $sql->bindValue(1, $email);
          $sql->execute();
          return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
    }


       public function editar_perfil($id_usuario_perfil,$nombre_perfil,$apellido_perfil,$email_perfil,$usuario_perfil,$password1_perfil,$password2_perfil){
          $conectar=parent::conexion();
          $sql="update usuarios set

                 nombres=?,
                 apellidos=?,
                 correo=?,

                 usuario=?,
                 password=?,
                 password2=?
                 where
                 id_usuario=?
          ";

          //echo $sql;

          $sql=$conectar->prepare($sql);

          $sql->bindValue(1,$_POST["nombre_perfil"]);
          $sql->bindValue(2,$_POST["apellido_perfil"]);
          $sql->bindValue(3,$_POST["email_perfil"]);
          $sql->bindValue(4,$_POST["usuario_perfil"]);
          $sql->bindValue(5,$_POST["password1_perfil"]);
          $sql->bindValue(6,$_POST["password2_perfil"]);
          $sql->bindValue(7,$_POST["id_usuario_perfil"]);
          $sql->execute();
        }
   }
?>

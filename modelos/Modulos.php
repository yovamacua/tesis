<?php
require_once("../config/conexion.php");
class Modulos extends Conectar{
       //método para seleccionar registros

       public function mostrar_modulo(){
          $conectar=parent::conexion();
          parent::set_names();
          $sql="SELECT * FROM modulo";
          $sql=$conectar->prepare($sql);
          $sql->execute();
          return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
       }
       //método para mostrar los datos de un registro a modificar
        public function get_roles_por_id($idmodulo){

            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM modulo WHERE idmodulo=?;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $idperfil);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

         public function registar_modulo($nombre)
        {
         $conectar= parent::conexion();
           parent::set_names();

           $sql="insert into modulo
           values(null,?,?);";
          $sql=$conectar->prepare($sql);
          $sql->bindValue(1,$_POST["nombre"]);
          $sql->execute();
           }

        public function editar_modulo($nombre,$idperfil)
        {
        	 $conectar= parent::conexion();
           parent::set_names();
       $sql="update modulo SET nombre =?,
           WHERE idmodulo =?";
          $sql=$conectar->prepare($sql);
          $sql->bindValue(2,$_POST["nombre"]);
           $sql->bindValue(1,$_POST["idmodulo"]);
          $sql->execute();
     
        }
      
        public function deletes_modulo($idmodulo)
        {
        	$conectar= parent::conexion();
           parent::set_names();
        	  $sql="DELETE FROM modulo WHERE idmodulo = ?;";
          $sql=$conectar->prepare($sql);
          $sql->bindValue(1,$_POST["idmodulo"]);
           $sql->execute();
        }
        
}

?>
<?php

  require_once("../config/conexion.php");
   class Incidentes extends Conectar{
       //método para seleccionar registros

   	   public function get_incidentes(){
   	   	  $conectar=parent::conexion();
   	   	  parent::set_names();
   	   	  $sql="select * from incidentes";
   	   	  $sql=$conectar->prepare($sql);
   	   	  $sql->execute();
   	   	  return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
   	   }

   	    //método para mostrar los datos de un registro a modificar
        public function get_incidentes_por_id($id_incidente){

            $conectar= parent::conexion();
            parent::set_names();
            $sql="select * from incidentes where id_incidente=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_incidente);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        //método para insertar registros

        public function registrar_incidentes($titulo,$descripcion,$fecha,$id_usuario){
           $conectar= parent::conexion();
           parent::set_names();

           $sql="insert into incidentes
           values(null,?,?,?,?);";

          $sql=$conectar->prepare($sql);
          $sql->bindValue(1,$_POST["titulo"]);
          $sql->bindValue(2,$_POST["descripcion"]);
          $sql->bindValue(3,$_POST["fecha"]);
		      $sql->bindValue(4,$_POST["id_usuario"]);
		      $sql->execute();

        }

        public function editar_incidentes($id_incidente,$titulo,$descripcion,$fecha,$id_usuario){

        	$conectar=parent::conexion();
        	parent::set_names();

        	$sql="update incidentes set
            titulo=?,
            descripcion=?,
            fecha=?,
            id_usuario=?
            where
            id_incidente=?
        	";

        	  $sql=$conectar->prepare($sql);
		          $sql->bindValue(1,$_POST["titulo"]);
		          $sql->bindValue(2,$_POST["descripcion"]);
              $sql->bindValue(3,$_POST["fecha"]);
		          $sql->bindValue(4,$_POST["id_usuario"]);
		          $sql->bindValue(5,$_POST["id_incidente"]);
		          $sql->execute();

              //print_r($_POST);
        }


        public function get_nombre_incidentes($titulo){

           $conectar=parent::conexion();
          $sql="select * from incidentes where titulo=?";
           $sql=$conectar->prepare($sql);
           $sql->bindValue(1,$titulo);
           $sql->execute();
           return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
        }

        //método para eliminar un registro
        public function eliminar_incidente($id_incidente){
           $conectar=parent::conexion();
           $sql="delete from incidentes where id_incidente=?";
           $sql=$conectar->prepare($sql);
           $sql->bindValue(1,$id_incidente);
           $sql->execute();

           return $resultado=$sql->fetch();
        }
   }
?>

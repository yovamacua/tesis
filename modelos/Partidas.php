<?php

  require_once("../config/conexion.php");
   class partidas extends Conectar{
       //método para seleccionar registros

   	   public function get_partidas($iduse){
   	   	  $conectar=parent::conexion();
   	   	  parent::set_names();
   	   	  $sql="select * from partidas where id_usuario = ?";
   	   	  $sql=$conectar->prepare($sql);
          $sql->bindValue(1, $iduse);
   	   	  $sql->execute();
   	   	  return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
   	   }

   	    //método para mostrar los datos de un registro a modificar
        public function get_partidas_por_id($id_partida){

            $conectar= parent::conexion();
            parent::set_names();
            $sql="select * from partidas where id_partida=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_partida);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        //método para insertar registros

        public function registrar_partidas($nombrepartida,$responsable,$id_usuario){
           $conectar= parent::conexion();
           parent::set_names();

           $sql="insert into partidas
           values(null,?,?,?);";

          $sql=$conectar->prepare($sql);
          $sql->bindValue(1,$_POST["nombrepartida"]);
          $sql->bindValue(2,$_POST["responsable"]);
		      $sql->bindValue(3,$_POST["id_usuario"]);
		      $sql->execute();

        }

        public function editar_partidas($id_partida,$nombrepartida,$responsable,$id_usuario){

        	$conectar=parent::conexion();
        	parent::set_names();

        	$sql="update partidas set
            nombrepartida=?,
            responsable=?,
            id_usuario=?
            where
            id_partida=?
        	";

        	  $sql=$conectar->prepare($sql);
		          $sql->bindValue(1,$_POST["nombrepartida"]);
		          $sql->bindValue(2,$_POST["responsable"]);
		          $sql->bindValue(3,$_POST["id_usuario"]);
		          $sql->bindValue(4,$_POST["id_partida"]);
		          $sql->execute();

              //print_r($_POST);
        }


        public function get_nombre_partidas($nombrepartida){

           $conectar=parent::conexion();
          $sql="select * from partidas where nombrepartida=?";
           $sql=$conectar->prepare($sql);
           $sql->bindValue(1,$nombrepartida);
           $sql->execute();
           return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
        }

        //método para eliminar un registro
        public function eliminar_partida($id_partida){
           $conectar=parent::conexion();
           $sql="delete from partidas where id_partida=?";
           $sql=$conectar->prepare($sql);
           $sql->bindValue(1,$id_partida);
           $sql->execute();

           return $resultado=$sql->fetch();
        }

        public function get_partida_por_id_usuario($id_usuario){
          $conectar= parent::conexion();
          $sql="select * from partidas where id_usuario=?";
          $sql=$conectar->prepare($sql);
          $sql->bindValue(1, $id_usuario);
          $sql->execute();
          return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
        }

   }
?>

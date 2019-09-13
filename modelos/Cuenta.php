<?php

  require_once("../config/conexion.php");
   class cuentas extends Conectar{
       //método para seleccionar registros

   	   public function get_cuentas(){
   	   	  $conectar=parent::conexion();
   	   	  parent::set_names();
   	   	  $sql="select * from cuentas";
   	   	  $sql=$conectar->prepare($sql);
   	   	  $sql->execute();
   	   	  return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
   	   }

   	    //método para mostrar los datos de un registro a modificar
        public function get_cuentas_por_id($id_cuenta){

            $conectar= parent::conexion();
            parent::set_names();
            $sql="select * from cuentas where id_cuenta=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_cuenta);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        //método para insertar registros

        public function registrar_cuentas($nombrecuenta,$id_partida){
           $conectar= parent::conexion();
           parent::set_names();

           $sql="insert into cuentas
           values(null,?,?);";

          $sql=$conectar->prepare($sql);
          $sql->bindValue(1,$_POST["id_partida"]);
          $sql->bindValue(2,$_POST["nombrecuenta"]);

		      $sql->execute();

        }

        public function editar_cuentas($id_cuenta,$nombrecuenta,$id_partida){

        	$conectar=parent::conexion();
        	parent::set_names();

        	$sql="update cuentas set
            nombrecuenta=?,
            id_partida=?
            where
            id_cuenta=?
        	";

        	  $sql=$conectar->prepare($sql);
		          $sql->bindValue(1,$_POST["nombrecuenta"]);
		          $sql->bindValue(2,$_POST["id_partida"]);
		          $sql->bindValue(3,$_POST["id_cuenta"]);
		          $sql->execute();

              //print_r($_POST);
        }


        public function get_nombre_cuentas($nombrecuenta){

          $conectar=parent::conexion();
          $sql="select * from cuentas where nombrecuenta=?";
           $sql=$conectar->prepare($sql);
           $sql->bindValue(1,$nombrecuenta);
           $sql->execute();
           return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
        }

        //método para eliminar un registro
        public function eliminar_cuenta($id_cuenta){
           $conectar=parent::conexion();
           $sql="delete from cuentas where id_cuenta=?";
           $sql=$conectar->prepare($sql);
           $sql->bindValue(1,$id_cuenta);
           $sql->execute();

           return $resultado=$sql->fetch();
        }
   }
?>

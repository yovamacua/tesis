<?php

  require_once("../config/conexion.php");

 if (!isset($_SESSION['id_usuario'])) { ?>
        <script type="text/javascript">
        window.location="../vistas/home.php";
        </script>
    <?php
    }
  
   class cuentas extends Conectar{
       //método para seleccionar registros

   	   public function get_cuentas($identificador){
   	   	  $conectar=parent::conexion();
   	   	  parent::set_names();
   	   	  $sql="select * from cuentas where id_partida = ?";
   	   	  $sql=$conectar->prepare($sql);
          $sql->bindValue(1, $identificador);
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

        public function registrar_cuentas($nombrecuenta,$id_partida,$objetivo,$estrategia){
           $conectar= parent::conexion();
           parent::set_names();

           $sql="insert into cuentas
           values(null,?,?,?,?);";

          $sql=$conectar->prepare($sql);
          $sql->bindValue(1,$_POST["id_partida"]);
          $sql->bindValue(2,substr($_POST["nombrecuenta"], 0, 50));
          $sql->bindValue(3,substr($_POST["objetivo"], 0, 150));
          $sql->bindValue(4,substr($_POST["estrategia"], 0, 150));

		      $sql->execute();

        }

        public function editar_cuentas($id_cuenta,$nombrecuenta,$id_partida, $estrategia, $objetivo){
        	$conectar=parent::conexion();
        	parent::set_names();

        	$sql="update cuentas set nombrecuenta=?, objetivo=?, estrategia=?, id_partida=? where id_cuenta=?";

        	  $sql=$conectar->prepare($sql);
          $sql->bindValue(2,substr($_POST["nombrecuenta"], 0, 50));
          $sql->bindValue(3,substr($_POST["objetivo"], 0, 150));
          $sql->bindValue(4,substr($_POST["estrategia"], 0, 150));
		          $sql->bindValue(4,$_POST["id_partida"]);
		          $sql->bindValue(5,$_POST["id_cuenta"]);
		          $sql->execute();
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
        //elimina entradas asociadas a esa cuenta 
          $sql2="delete from entrada where id_cuenta=?";
           $sql2=$conectar->prepare($sql2);
           $sql2->bindValue(1,$id_cuenta);
           $sql2->execute();
           return $resultado=$sql->fetch();
        }

        public function get_cuenta_por_id_partida($id_partida){
          $conectar= parent::conexion();
          $sql="select * from cuentas where id_partida=?";
          $sql=$conectar->prepare($sql);
          $sql->bindValue(1, $id_partida);
          $sql->execute();
          return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
        }
   }
?>

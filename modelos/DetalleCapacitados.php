<?php
  require_once("../config/conexion.php");
  
    class DetalleCapacitados extends Conectar{

      //método para seleccionar registros
      public function get_detallecapacitados(){
        $conectar = parent::conexion();
        parent::set_names();

          $sql = "select * from detallecapacitados";
          $sql = $conectar->prepare($sql);
          //$sql->bindValue(1, $id_detallecapacitados);
          $sql->bindValue(1, $id_capacitacion);
          $sql->execute();
          return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
       }

      //método para mostrar los datos de un registro a modificar
      public function get_detallecapacitados_por_id($id_detallecapacitados){

          $conectar = parent::conexion();
          parent::set_names();

            $sql = "select * from detallecapacitados where id_detallecapacitados=?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id_detallecapacitados);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        //método para insertar registros
        public function registrar_detallecapacitados($nombres, $apellidos, $contacto, $procedencia, $id_capacitacion){
          $conectar = parent::conexion();
          parent::set_names();

            $sql = "insert into detallecapacitados values(null,?,?,?,?,?);";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1,$_POST["nombres"]);
            $sql->bindValue(2,$_POST["apellidos"]);
            $sql->bindValue(3,$_POST["contacto"]);
            $sql->bindValue(4,$_POST["procedencia"]);
            $sql->bindValue(5,$_POST["id_capacitacion"]);
            $sql->execute();

            //print_r($_POST);
        }

        // metodo para editar las categorias
        public function editar_detallecapacitados($id_detallecapacitados, $nombres, $apellidos, $contacto, $procedencia, $id_capacitacion){

          $conectar = parent::conexion();
          parent::set_names();

            $sql = "update detallecapacitados set
              nombres=?,
              apellidos=?,
              contacto=?,
              procedencia=?,
              id_capacitacion=?
              where
              id_detallecapacitados=?";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $_POST["nombres"]);
            $sql->bindValue(2, $_POST["apellidos"]);
            $sql->bindValue(3, $_POST["contacto"]);
            $sql->bindValue(4, $_POST["procedencia"]);
            $sql->bindValue(5, $_POST["id_capacitacion"]);
            $sql->bindValue(6, $_POST["id_detallecapacitados"]);
            $sql->execute();
        }

        //método para eliminar un registro
        public function eliminar_detallecapacitados($id_detallecapacitados){
          $conectar = parent::conexion();
          parent::set_names();

            $sql = "delete from detallecapacitados where id_detallecapacitados=?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id_detallecapacitados);
            $sql->execute();

            return $resultado = $sql->fetch();
        }
    }
?>
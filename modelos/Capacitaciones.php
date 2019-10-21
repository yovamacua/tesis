<?php
  require_once("../config/conexion.php");
  
    class Capacitaciones extends Conectar{

      //método para seleccionar registros
      public function get_capacitacion(){
        $conectar = parent::conexion();
        parent::set_names();

          $sql = "select * from capacitaciones";
          $sql = $conectar->prepare($sql);
          $sql->execute();
          return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
       }

      //método para mostrar los datos de un registro a modificar
      public function get_capacitacion_por_id($id_capacitacion){

          $conectar = parent::conexion();
          parent::set_names();

            $sql = "select * from capacitaciones where id_capacitacion=?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id_capacitacion);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        //método para insertar registros
        public function registrar_capacitacion($fecha, $nombreGrupo, $cargo, $encargado, $id_usuario){
          $conectar = parent::conexion();
          parent::set_names();

            $sql = "insert into capacitaciones values(null,?,?,?,?,?);";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1,$_POST["fecha"]);
            $sql->bindValue(2,$_POST["nombreGrupo"]);
            $sql->bindValue(3,$_POST["cargo"]);
            $sql->bindValue(4,$_POST["encargado"]);
            $sql->bindValue(5,$_POST["id_usuario"]);
            $sql->execute();

        }

        // metodo para editar las categorias
        public function editar_capacitacion($id_capacitacion, $fecha, $nombreGrupo, $cargo, $encargado, $id_usuario){

          $conectar = parent::conexion();
          parent::set_names();

            $sql = "update capacitaciones set
              fecha=?,
              nombreGrupo=?,
              cargo=?,
              encargado=?,
              id_usuario=?
              where
              id_capacitacion=?";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $_POST["fecha"]);
            $sql->bindValue(2, $_POST["nombreGrupo"]);
            $sql->bindValue(3, $_POST["cargo"]);
            $sql->bindValue(4, $_POST["encargado"]);
            $sql->bindValue(5, $_POST["id_usuario"]);
            $sql->bindValue(6, $_POST["id_capacitacion"]);
            $sql->execute();
        }

        //método para eliminar un registro
        public function eliminar_capacitacion($id_capacitacion){
          $conectar = parent::conexion();
          parent::set_names();

            $sql = "delete from capacitaciones where id_capacitacion=?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id_capacitacion);
            $sql->execute();

            return $resultado = $sql->fetch();
        }

        //método para eliminar un registro
        public function eliminar_capacitados($id_capacitacion){
          $conectar = parent::conexion();
          parent::set_names();

            //Sentencia para eliminar capacitados con ese id
            $sql = "delete dc from detallecapacitados dc 
            inner join capacitaciones c
            on dc.id_capacitacion = c.id_capacitacion
            where dc.id_capacitacion=?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id_capacitacion);
            $sql->execute();

            return $resultado = $sql->fetch();
        }


                /****** Bloque agregado ******/
          public function get_capacitaciones_por_id_usuario($id_usuario){
          $conectar= parent::conexion();
          $sql="select * from capacitaciones where id_usuario=?";
          $sql=$conectar->prepare($sql);
          $sql->bindValue(1, $id_usuario);
          $sql->execute();
          return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        /****** Fin bloque agregado ******/
    }
?>

  


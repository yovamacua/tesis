<?php
  require_once("../config/conexion.php");

  #valida que exista la sessión
  if (!isset($_SESSION['id_usuario'])) {?>
          <script type="text/javascript">
          window.location="../vistas/home.php";
          </script>
      <?php
  }
  
    class DetalleCapacitados extends Conectar{

      //método para seleccionar registros
      public function get_detallecapacitados($id_capacitacion){
        $conectar = parent::conexion();
        parent::set_names();

          $sql = "select * from detallecapacitados where id_capacitacion=?";
          $sql = $conectar->prepare($sql);
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
        public function registrar_detallecapacitados($nombres, $apellidos, $dui, $id_capacitacion){
          $conectar = parent::conexion();
          parent::set_names();

            $sql = "insert into detallecapacitados values(null,?,?,?,?);";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, substr($_POST["nombres"], 0, 45));
            $sql->bindValue(2, substr($_POST["apellidos"], 0, 45));
            $sql->bindValue(3, substr($_POST["dui"], 0, 45));
            $sql->bindValue(4, $_POST["id_capacitacion"]);
            $sql->execute();

        }
 
        // metodo para editar las categorias
        public function editar_detallecapacitados($id_detallecapacitados, $nombres, $apellidos, $dui, $id_capacitacion){

          $conectar = parent::conexion();
          parent::set_names();

            $sql = "update detallecapacitados set
              nombres=?,
              apellidos=?,
              dui=?,
              id_capacitacion=?
              where
              id_detallecapacitados=?";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, substr($_POST["nombres"], 0, 45));
            $sql->bindValue(2, substr($_POST["apellidos"], 0, 45));
            $sql->bindValue(3, substr($_POST["dui"], 0, 45));
            $sql->bindValue(4, $_POST["id_capacitacion"]);
            $sql->bindValue(5, $_POST["id_detallecapacitados"]);
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
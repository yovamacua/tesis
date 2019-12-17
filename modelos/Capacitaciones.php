<?php
  require_once("../config/conexion.php");

  #valida que exista la sessión
  if (!isset($_SESSION['id_usuario'])) {?>
          <script type="text/javascript">
          window.location="../vistas/home.php";
          </script>
      <?php
  }
  
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

            $date_inicial = $_POST["fecha"];
            $date = str_replace('/', '-', $date_inicial);
            $fecha = date("Y-m-d", strtotime($date));

            $sql = "insert into capacitaciones values(null,?,?,?,?,?);";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $fecha);
            $sql->bindValue(2, substr($_POST["nombreGrupo"], 0, 45));
            $sql->bindValue(3, substr($_POST["cargo"], 0, 45));
            $sql->bindValue(4, substr($_POST["encargado"], 0, 45));
            $sql->bindValue(5, $_POST["id_usuario"]);
            $sql->execute();
        
        }

        // metodo para editar las categorias
        public function editar_capacitacion($id_capacitacion, $fecha, $nombreGrupo, $cargo, $encargado, $id_usuario){

          $conectar = parent::conexion();
          parent::set_names();

            $date_inicial = $_POST["fecha"];
            $date = str_replace('/', '-', $date_inicial);
            $fecha = date("Y-m-d", strtotime($date));

            $sql = "update capacitaciones set
              fecha=?,
              nombreGrupo=?,
              cargo=?,
              encargado=?,
              id_usuario=?
              where
              id_capacitacion=?";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $fecha);
            $sql->bindValue(2, substr($_POST["nombreGrupo"], 0, 45));
            $sql->bindValue(3, substr($_POST["cargo"], 0, 45));
            $sql->bindValue(4, substr($_POST["encargado"], 0, 45));
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

  


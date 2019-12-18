<?php 
require_once("../config/conexion.php");
  #valida que exista la sessión
  if (!isset($_SESSION['id_usuario'])) {?>
          <script type="text/javascript">
          window.location="../vistas/home.php";
          </script>
      <?php
  }
  
    class Pedidos extends Conectar{

      //método para seleccionar registros
      public function get_pedido(){
        $conectar = parent::conexion();
        parent::set_names();

          $sql = "select p.id_pedido, p.fecha, u.usuario from pedidos p inner join usuarios u on p.id_usuario = u.id_usuario";
          $sql = $conectar->prepare($sql);
          $sql->execute();
          return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
       }

      //método para mostrar los datos de un registro a modificar
      public function get_pedido_por_id($id_pedido){

          $conectar = parent::conexion();
          parent::set_names();

            $sql = "select * from pedidos where id_pedido=?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id_pedido);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

        //método para insertar registros
        public function registrar_pedido($id_usuario, $fecha){
          $conectar = parent::conexion();
          parent::set_names();

            $date_inicial = $_POST["fecha"];
            $date = str_replace('/', '-', $date_inicial);
            $fecha = date("Y-m-d", strtotime($date));

            $sql = "insert into pedidos values(null,?,?);";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $_POST["id_usuario"]);
            $sql->bindValue(2, $fecha);
            $sql->execute();

        }

        // metodo para editar las categorias
        public function editar_pedido($id_pedido ,$id_usuario, $fecha){

          $conectar = parent::conexion();
          parent::set_names();

            $date_inicial = $_POST["fecha"];
            $date = str_replace('/', '-', $date_inicial);
            $fecha = date("Y-m-d", strtotime($date));

            $sql = "update pedidos set
              id_usuario=?,
              fecha=?
              where
              id_pedido=?";

            $sql = $conectar->prepare($sql); 
            $sql->bindValue(1, $_POST["id_usuario"]);
            $sql->bindValue(2, $fecha);
            $sql->bindValue(3, $_POST["id_pedido"]);
            $sql->execute();
            
        }

        //método para eliminar un registro
        public function eliminar_pedido($id_pedido){
          $conectar = parent::conexion();
          parent::set_names();

            $sql = "delete from pedidos where id_pedido=?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id_pedido);
            $sql->execute();

            return $resultado = $sql->fetch();
        }

        //método para eliminar un registro
        public function eliminar_pedidos($id_pedido){
          $conectar = parent::conexion();
          parent::set_names();

            $sql = "delete dp from detallepedidos dp 
            inner join pedidos p
            on dp.id_pedido = p.id_pedido
            where dp.id_pedido=?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id_pedido);
            $sql->execute();

            return $resultado = $sql->fetch();
        }

           #valida si hay registros asociados
          function get_pedidos_por_id_usuario($id_usuario)
          {
              $conectar = parent::conexion();
              $sql      = "select * from pedidos where id_usuario=?";
              $sql      = $conectar->prepare($sql);
              $sql->bindValue(1, $id_usuario);
              $sql->execute();
              return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
          }

      }
 ?>
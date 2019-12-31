<?php 
 require_once("../config/conexion.php");

  #valida que exista la sessión
  if (!isset($_SESSION['id_usuario'])) {?>
          <script type="text/javascript">
          window.location="../vistas/home.php";
          </script>
      <?php
  }
  
    class DetallePedidos extends Conectar{

      //método para obtener un detalle por el id de pedido (filtro)
      public function get_detallepedido($id_pedido){
        $conectar= parent::conexion();
        parent::set_names();
        
        $sql = "select dp.id_detallepedido, dp.nombreInsumo, dp.cantidad, dp.descripcion, dp.id_pedido, uni.nombre, dp.id_uni 
                from detallepedidos dp
                inner join unidad uni on dp.id_uni = uni.idunidad where id_pedido=?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_pedido);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
       }
       
      //método para mostrar los datos de un registro a modificar
      public function get_detallepedido_por_id($id_detallepedido){

          $conectar = parent::conexion();
          parent::set_names();

            $sql = "select * from detallepedidos where id_detallepedido=?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id_detallepedido);
            $sql->execute();
            return $resultado = $sql->fetchAll();
        }

      //método para mostrar los datos de un registro a modificar
      public function get_detallepedidos(){
          $conectar = parent::conexion();
          parent::set_names();

          $sql = "select * from detallepedidos";
          $sql = $conectar->prepare($sql);
          $sql->execute();
          return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        //método para insertar registros
        public function registrar_detallepedido($nombreInsumo, $cantidad, $descripcion, $id_pedido, $id_uni){
          $conectar = parent::conexion();
          parent::set_names();

            $sql = "insert into detallepedidos values(null,?,?,?,?,?);";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, substr($_POST["nombreInsumo"], 0, 45));
            $sql->bindValue(2, substr($_POST["cantidad"], 0, 4));
            $sql->bindValue(3, substr($_POST["descripcion"], 0, 100));
            $sql->bindValue(4, $_POST["id_pedido"]);
            $sql->bindValue(5, $_POST["id_uni"]);
            $sql->execute(); 

        }

        // metodo para editar el detallepedido
        public function editar_detallepedido($id_detallepedido, $nombreInsumo, $cantidad, $descripcion, $id_pedido, $id_uni){

          $conectar = parent::conexion();
          parent::set_names();

            $sql = "update detallepedidos set
              nombreInsumo=?,
              cantidad=?,
              descripcion=?,
              id_pedido=?,
              id_uni=?
              where
              id_detallepedido=?";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, substr($_POST["nombreInsumo"], 0, 45));
            $sql->bindValue(2, substr($_POST["cantidad"], 0, 4));
            $sql->bindValue(3, substr($_POST["descripcion"], 0, 100));
            $sql->bindValue(4, $_POST["id_pedido"]);
            $sql->bindValue(5, $_POST["id_uni"]);            
            $sql->bindValue(6, $_POST["id_detallepedido"]);
            $sql->execute();
        }

        //método para eliminar un registro
        public function eliminar_detallepedido($id_detallepedido){
          $conectar = parent::conexion();
          parent::set_names();

            $sql = "delete from detallepedidos where id_detallepedido=?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id_detallepedido);
            $sql->execute();

            return $resultado = $sql->fetch();
        }
    }
?>
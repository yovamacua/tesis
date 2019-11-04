<?php 
 require_once("../config/conexion.php");
  
    class DetallePedidos extends Conectar{

      //método para obtener un detalle por el id de pedido (filtro)
      public function get_detallepedido($id_pedido){
        $conectar= parent::conexion();
        parent::set_names();
        $sql="select * from detallepedidos where id_pedido=?";
      
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
        public function registrar_detallepedido($nombreInsumo, $cantidad, $descripcion, $unidadMedida, $id_pedido){
          $conectar = parent::conexion();
          parent::set_names();

            $sql = "insert into detallepedidos values(null,?,?,?,?,?);";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $_POST["nombreInsumo"]);
            $sql->bindValue(2, $_POST["cantidad"]);
            $sql->bindValue(3, $_POST["descripcion"]);
            $sql->bindValue(4, $_POST["unidadMedida"]);
            $sql->bindValue(5, $_POST["id_pedido"]);
            $sql->execute();

        }

        // metodo para editar el detallepedido
        public function editar_detallepedido($id_detallepedido, $nombreInsumo, $cantidad, $descripcion, $unidadMedida, $id_pedido){

          $conectar = parent::conexion();
          parent::set_names();

            $sql = "update detallepedidos set
              nombreInsumo=?,
              cantidad=?,
              descripcion=?,
              unidadMedida=?,
              id_pedido=?
              where
              id_detallepedido=?";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $_POST["nombreInsumo"]);
            $sql->bindValue(2, $_POST["cantidad"]);
            $sql->bindValue(3, $_POST["descripcion"]);
            $sql->bindValue(4, $_POST["unidadMedida"]);
            $sql->bindValue(5, $_POST["id_pedido"]);
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
<?php
#valida que exista la sessión
if (!isset($_SESSION['id_usuario'])) {?>
        <script type="text/javascript">
        window.location="../vistas/home.php";
        </script>
    <?php
}
  require_once("../config/conexion.php");
   class Categorias extends Conectar{
       //método para seleccionar registros

       public function get_categoria(){
          $conectar=parent::conexion();
          parent::set_names();
          $sql="select * from categorias";
          $sql=$conectar->prepare($sql);
          $sql->execute();
          return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
       }

        //método para mostrar los datos de un registro a modificar
        public function get_categorias_por_id($id_categoria){

            $conectar= parent::conexion();
            parent::set_names();
            $sql="select * from categorias where id_categoria=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_categoria);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        //método para insertar registros

        public function registrar_categoria($categoria,$descripcion,$id_usuario){
           $conectar= parent::conexion();
           parent::set_names();

           $sql="insert into categorias
           values(null,?,?,?);";

          $sql=$conectar->prepare($sql);
          $sql->bindValue(1,substr($_POST["categoria"], 0, 50));
          $sql->bindValue(2,substr($_POST["descripcion"], 0, 70));
          $sql->bindValue(3,$_POST["id_usuario"]);
          $sql->execute();

        }
        // metodo para editar las categorias

        public function editar_categoria($id_categoria,$categoria,$descripcion,$id_usuario){

          $conectar=parent::conexion();
          parent::set_names();

          $sql="update categorias set
            categoria=?,
            descripcion=?,
            id_usuarioscate=?
            where
            id_categoria=?
          ";

            $sql=$conectar->prepare($sql);
              $sql->bindValue(1,$_POST["categoria"]);
              $sql->bindValue(2,$_POST["descripcion"]);
              $sql->bindValue(3,$_POST["id_usuario"]);
              $sql->bindValue(4,$_POST["id_categoria"]);
              
              
              $sql->execute();

              //print_r($_POST);
        }

//método si la categoria existe en la base de datos
        public function get_nombre_categoria($titulo){

           $conectar=parent::conexion();
          $sql="select * from categoria where categoria=?";
           $sql=$conectar->prepare($sql);
           $sql->bindValue(1,$titulo);
           $sql->execute();
           return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
        }

        //método para eliminar un registro
        public function eliminar_categoria($id_categoria){
           $conectar=parent::conexion();
           $sql="delete from categorias where id_categoria=?";
           $sql=$conectar->prepare($sql);
           $sql->bindValue(1,$id_categoria);
           $sql->execute();

           return $resultado=$sql->fetch();
        }

                /****** Bloque agregado ******/

          public function get_categoria_por_id_usuario($id_usuario){
          $conectar= parent::conexion();
          $sql="select * from categorias where id_usuarioscate=?";
          $sql=$conectar->prepare($sql);
          $sql->bindValue(1, $id_usuario);
          $sql->execute();
          return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        /****** Fin bloque agregado ******/
   }
?>

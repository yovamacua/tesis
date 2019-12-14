<?php
#valida que exista la sessión
if (!isset($_SESSION['id_usuario'])) {?>
        <script type="text/javascript">
        window.location="../vistas/home.php";
        </script>
    <?php
}
  require_once("../config/conexion.php");
   class Unidad extends Conectar{
       //método para seleccionar registros

       public function get_unidad(){
          $conectar=parent::conexion();
          parent::set_names();
          $sql="select * from unidad";
          $sql=$conectar->prepare($sql);
          $sql->execute();
          return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
       }

        //método para mostrar los datos de un registro a modificar
        public function get_unidad_por_id($id_unidad){

            $conectar= parent::conexion();
            parent::set_names();
            $sql="select * from unidad where idunidad=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_unidad);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        //método para insertar registros

        public function registrar_unidad($nombre,$descripcion,$id_usuario){
           $conectar= parent::conexion();
           parent::set_names();

           $sql="insert into unidad
           values(null,?,?,?);";
     
          $sql=$conectar->prepare($sql);
         $sql->bindValue(1,substr($_POST["nombre"], 0, 45));
         $sql->bindValue(2,substr($_POST["descripcion"], 0, 50));
         $sql->bindValue(3,$_POST["id_usuario"]);
          
          $sql->execute();

        }
        // metodo para editar una unidad

        public function editar_unidad($id_unidad,$categoria,$descripcion,$id_usuario){

          $conectar=parent::conexion();
          parent::set_names();

          $sql="update unidad set
            nombre=?,
            descripcion=?,
            idusuariouni=?
            where
            idunidad=?
          ";

            $sql=$conectar->prepare($sql);
              $sql->bindValue(1,$_POST["nombre"]);
              $sql->bindValue(2,$_POST["descripcion"]);
              $sql->bindValue(3,$_POST["id_usuario"]);
              $sql->bindValue(4,$_POST["id_unidad"]);
              
              
              $sql->execute();

             // print_r($_POST);
        }

//método si el nombre existe en la base de datos
        public function get_nombre_unidad($titulo){

           $conectar=parent::conexion();
          $sql="select * from unidad where nombre=?";
           $sql=$conectar->prepare($sql);
           $sql->bindValue(1,$titulo);
           $sql->execute();
           return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
        }

        //método para eliminar un registro
        public function eliminar_unidad($id_unidad){
           $conectar=parent::conexion();
           $sql="delete from unidad where idunidad=?";
           $sql=$conectar->prepare($sql);
           $sql->bindValue(1,$id_unidad);
           $sql->execute();

           return $resultado=$sql->fetch();
        }

                /****** Bloque agregado ******/

          public function get_unidad_por_id_usuario($id_usuario){
          $conectar= parent::conexion();
          $sql="select * from unidad where id_usuariounida=?";
          $sql=$conectar->prepare($sql);
          $sql->bindValue(1, $id_usuario);
          $sql->execute();
          return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        /****** Fin bloque agregado ******/
   }

?>

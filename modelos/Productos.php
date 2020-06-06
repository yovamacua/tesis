 <?php
  
 if (!isset($_SESSION['id_usuario'])) {?>
        <script type="text/javascript">
        window.location="../vistas/inicio.php";
        </script>
    <?php
}
 //conexión a la base de datos

   require_once("../config/conexion.php");

   class Producto extends Conectar{

          
           //método para seleccionar registros

   	  public function get_productos(){

           $conectar= parent::conexion();
       
          $sql= "call getproductos();";

           $sql=$conectar->prepare($sql);

           $sql->execute();

           return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);

         
         }

         //funcion para obtener los productos en la vista perdidas
         public function getproductos(){

           $conectar = parent::conexion();
           $sql = "select * from producto";
           $sql = $conectar->prepare($sql);
           $sql->execute();
           return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC); 

         }
         //método para insertar registro de productos

        public function registrar_producto($producto,$precio_venta,$id_unidad,$id_categoria,$stock,$id_usuario){

try{
            $conectar=parent::conexion();
            parent::set_names();
           
          
          $sql="call registar_producto(?,?,?,?,?,?);";

            
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, substr($_POST["producto"], 0, 50), PDO::PARAM_STR);
            $sql->bindValue(2,substr($_POST["precio_venta"], 0, 4), PDO::PARAM_STR);
            $sql->bindValue(3, $_POST["id_unidad"],PDO::PARAM_INT);
            $sql->bindValue(4, $_POST["categoria"], PDO::PARAM_INT);
            $sql->bindValue(5, ($_POST["stock"]),PDO::PARAM_STR);
            $sql->bindValue(6, $_POST["id_usuario"],PDO::PARAM_INT);
             
           $sql->execute();
         }catch(PDOException $ex){

          echo $ex->getMessage();
         }

        }
        // metodo para consultar si existe el producto
        public function get_producto_nombre($producto){

              $conectar=parent::conexion();

              $sql= "select * from producto where producto=?";

              $sql=$conectar->prepare($sql);

              $sql->bindValue(1, $producto);
               $sql->execute();
              return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
        }
                // editar los productos
         public function editar_producto($producto,$precio_venta,$id_unidad,$id_usuario,$id_categoria,$id_producto,$stock,$stock1){
           
            try {
               $conectar=parent::conexion();
            parent::set_names();
         
          $sql="call editar_producto(?,?,?,?,?,?,?,?)";
           
             $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $_POST["producto"], PDO::PARAM_STR);
            $sql->bindValue(2, $_POST["precio_venta"], PDO::PARAM_STR);
            $sql->bindValue(3, $_POST["id_unidad"],PDO::PARAM_INT);
            $sql->bindValue(4, $_POST["id_usuario"],PDO::PARAM_INT);
            $sql->bindValue(5, $_POST["categoria"], PDO::PARAM_INT);
            $sql->bindValue(6, $_POST["id_producto"], PDO::PARAM_INT);
            $sql->bindValue(7, $_POST["stock"], PDO::PARAM_STR);
             $sql->bindValue(8, $_POST["stock1"], PDO::PARAM_STR);
               $sql->execute();
           
            
              
            } catch (PDOException $ex) {
              echo $ex->getMessage();
            }



         }
        //obtiene el registro por id despues de editar
      public function get_producto_por_id($id_producto){

      $conectar = parent::conexion();
      parent::set_names();
      //$producto =9;
      $sql = "call get_producto_por_id(?);"; 
      $sql = $conectar->prepare($sql);
      $sql-> bindValue(1, $_POST["id_producto"], PDO::PARAM_INT);
      $sql-> execute();

      return  $resultado = $sql->fetchAll();
    
    }
   // metodo eliminar producto
     public function eliminar_producto($id_producto){
           $conectar=parent::conexion();
           $sql="delete from producto where id_producto=?;";
           $sql=$conectar->prepare($sql);
           $sql->bindValue(1,$id_producto);
           $sql->execute();

           return $resultado=$sql->fetch();
        }

        /****** Bloque agregado ******/

          public function get_producto_por_id_usuario($id_usuario){
          $conectar= parent::conexion();
          $sql="select * from producto where id_usuario=?";
          $sql=$conectar->prepare($sql);
          $sql->bindValue(1, $id_usuario);
          $sql->execute();
          return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        /****** Fin bloque agregado ******/

       }
    


          


?>
      <?php 
      require_once("../config/conexion.php");
      if (!isset($_SESSION['id_usuario'])) {?>
             <script type="text/javascript">
             window.location="../vistas/home.php";
             </script>
         <?php
     }

      Class InforCajas extends Conectar {

     public function getProductos(){


     	      $conectar=parent::conexion();
               parent::set_names();
               $sql="select count(producto) as producto from producto;";
               $sql=$conectar->prepare($sql);
               $sql->execute();
               return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
               //$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
           // echo json_encode($resultado);
     }
     public function getIncidentes()
     {
     	  $conectar=parent::conexion();
               parent::set_names();
               $sql="select  count(*) as incidentes from incidentes
               where YEAR(fecha)=YEAR(curdate())  group by YEAR(fecha);";
               $sql=$conectar->prepare($sql);
               $sql->execute();
            return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
     }

     public function getDonaciones()
     {
     	      $conectar=parent::conexion();
               parent::set_names();
               $sql="select  count(*) as donaciones from donaciones
               where YEAR(fecha)=YEAR(curdate())  group by YEAR(fecha);";
               $sql=$conectar->prepare($sql);
               $sql->execute();
               return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
     }
     public function getVentas()
     {
     	     $conectar=parent::conexion();
               parent::set_names();
               $sql="select  count(*) as ventas from ventas
               where YEAR(fechaventa)=YEAR(curdate()) and estado ='1' group by YEAR(fechaventa)";
               $sql=$conectar->prepare($sql);
               $sql->execute();
               return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);

      }
     }

     ?>
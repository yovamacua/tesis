<?php


 //conexión a la base de datos

   require_once("../config/conexion.php");

   class Ventas extends Conectar{


           //método para seleccionar registros

   	  public function getventas(){

           $conectar= parent::conexion();

          $sql= " call getventas();";

           $sql=$conectar->prepare($sql);

           $sql->execute();

           return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);

         // $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
         //  echo json_encode($resultado);

         }
         //metodo para anular venta
      public function anularventa($idventas,$estado){


        $conectar = parent::conexion();
      parent::set_names();
            //parametro est se envia por via ajax
        if($_POST["estado"]=="0"){ $estado=1; }
          else { $estado=0;}

      $sql = "update ventas set estado=? where idventas=?;";
      $sql = $conectar->prepare($sql);
      $sql-> bindValue(1, $estado);
      $sql-> bindValue(2, $idventas);
      $sql-> execute();
      $this->retornoventa($idventas);
}
public function retornoventa($idventas){
// iniciamos la actualizacion del stock por la devulocion de la venta
  $conectar = parent::conexion();
      parent::set_names();
      $sql1 ="select d.id_producto, d.cantidad from detalleventas as d where id_ventas=?";
      $sql1 = $conectar->prepare($sql1);
      $sql1-> bindValue(1, $idventas);
      $sql1->execute();
      $resultado = $sql1->fetchAll(PDO::FETCH_ASSOC);
     // se recorre  la tabla
      foreach ($resultado as $row) {

        $id_producto=$row["id_producto"];
        //selecciona la cantidad vendida
         $cantidad_venta=$row["cantidad"];

      //validacion si el id_producto existe
      if(isset($id_producto)==true){

        $sql2="select  stock from kardex where id_producto1=?;";
        $sql2=$conectar->prepare($sql2);

        $sql2->bindValue(1, $id_producto);
        $sql2->execute();
$resultado1=$sql2->fetchAll(PDO::FETCH_ASSOC);
      
// se recorre la tabla
        foreach ($resultado1 as  $row2) {
          $stock=$row2["stock"];
          // se realiza la sumatoria al stock de la devolucion
          $cantidad_actual= $stock + $cantidad_venta;
        }
      }
      //se actualiza el sctok del inventario
      $sql3="update kardex set stock=? where id_producto1=?;";
      $sql3=$conectar->prepare($sql3);
      $sql3->bindValue(1,$cantidad_actual);
      $sql3->bindValue(2,$id_producto);
      $sql3->execute();
       return $resultado=$sql3->fetch();
      }
    }

       //obtiene el registro por id despues de editar
      public function get_venta_por_id($idventas){

      $conectar = parent::conexion();
      parent::set_names();
      $sql = "select idventas from ventas where idventas=?;";
      $sql = $conectar->prepare($sql);
      $sql-> bindValue(1, $_POST["idventas"], PDO::PARAM_INT);
     $sql-> execute();

      return  $resultado = $sql->fetchAll();
      //$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
          //echo json_encode($resultado);
    }
    public function registro_ventas($total_pagar,$numero_venta,$id_usuario,$id_producto, $cantidad,$precio_venta){
      try{

            $conectar=parent::conexion();
            parent::set_names();

          $estado=1;
          /*$total_pagar=23.50;
          $numero_venta='002-0015';
          $id_usuario=1;*/
          $sql="call registrar_venta(curdate(),?,?,?,?);";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $_POST["total_pagar"], PDO::PARAM_STR);
            $sql->bindValue(2, $estado);
            $sql->bindValue(3, $_POST["numero_venta"], PDO::PARAM_STR);
            $sql->bindValue(4, $_POST["id_usuario"], PDO::PARAM_INT);
            $sql->execute();
             $resultado =$sql->fetchAll();
         foreach($resultado as $row){

                 $id_venta=$output["@id"]=$row["@id"];
           }
 $array_id_producto=$_POST['id_producto'];
  $array_cantidad=$_POST['cantidad'];
  $array_precio_venta=$_POST['precio_venta'];
//Obtenemos cada clave y su valor para poder contar la cantidad de datos e ingresarlos acorde a cada clave
//Si falta algún dato, "matamos" el proceso
if (empty($array_id_producto) OR empty($array_cantidad) OR empty($array_precio_venta)) {
die('Uno o más campos están vacíos');
};


foreach ($array_id_producto as $clave=>$id_producto) {
  $cantidad = $array_cantidad[$clave];
  $precio_venta = $array_precio_venta[$clave];


            $sql="call registrar_detalleventas(?,?,?,?);";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_producto, PDO::PARAM_STR);
            $sql->bindValue(2, $cantidad, PDO::PARAM_INT);
            $sql->bindValue(3, $precio_venta,PDO::PARAM_STR);
            $sql->bindValue(4, $id_venta,PDO::PARAM_INT);
            $sql->execute();
          }


         }catch(PDOException $ex){

          echo $ex->getMessage();
         }
         $this-> registrar_detalleventas($id);
     }


     //consultar de venta por fecha
     public function lista_busca_registros_fecha($fecha_inicial, $fecha_final){
      $conectar= parent::conexion();

            $date_inicial = $_POST["fecha_inicial"];
            $date = str_replace('/', '-', $date_inicial);
            $fecha_inicial = date("Y-m-d", strtotime($date));

              $date_final = $_POST["fecha_final"];
              $date = str_replace('/', '-', $date_final);
              $fecha_final = date("Y-m-d", strtotime($date));

       $sql= "select v.idventas, concat(u.nombres, u.apellidos) as vendedor,v.total_pagar, v.numero_venta, v.fechaventa, v.estado from ventas v inner join usuarios u on v.id_usuario= u.id_usuario
              where v.fechaventa>=? and v.fechaventa<=?;";


            $sql = $conectar->prepare($sql);
            $sql->bindValue(1,$fecha_inicial);
            $sql->bindValue(2,$fecha_final);
            $sql->execute();
            return $result = $sql->fetchAll(PDO::FETCH_ASSOC);

       }
      //lista por registro por mes
       public function lista_busca_registros_fecha_mes($mes, $ano){

          $conectar= parent::conexion();


          //variables que vienen por POST VIA AJAX
             $mes=$_POST["mes"];
             $ano=$_POST["ano"];



           $fecha= ($ano."-".$mes."%");


          $sql= "select v.idventas,concat(u.nombres, u.apellidos) as vendedor,v.total_pagar, v.numero_venta, v.fechaventa, v.estado from ventas v inner join usuarios u on v.id_usuario= u.id_usuario
            WHERE fechaventa like ?;";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1,$fecha);
            $sql->execute();
            return $result = $sql->fetchAll(PDO::FETCH_ASSOC);


        }

    }
  //$venta = new Ventas();
   //$venta-> get_venta_por_id();
   //$venta ->anularventa();*/
         /* $total_pagar=45.00;

          $numero_venta='002-007';
          $id_usuario=1;

            $precio_venta= 10;
            $id_producto=13;  */

/*$id=34;
$estado=0;
  $venta-> anularventa($id,$estado);*/

   ?>

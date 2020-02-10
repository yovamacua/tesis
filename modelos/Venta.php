<?php

if (!isset($_SESSION['id_usuario'])) {?>
        <script type="text/javascript">
        window.location="../vistas/home.php";
        </script>
    <?php
}
 //c
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
    // metodo para registrar las ventas realizada
    public function registro_ventas($total_pagar,$numero_venta,$id_usuario,$id_producto, $cantidad,$precio_venta, $fecha){
      try{

            $conectar=parent::conexion();
            parent::set_names();

          $estado=1;
          $date_inicial = $_POST["fecha"];
            $date = str_replace('/', '-', $date_inicial);
            $fecha= date("Y-m-d", strtotime($date));
          $sql="call registrar_venta(?,?,?,?,?);";

            $sql=$conectar->prepare($sql);
             $sql->bindValue(1, $fecha);
            $sql->bindValue(2, $_POST["total_pagar"], PDO::PARAM_STR);
            $sql->bindValue(3, $estado);
            $sql->bindValue(4, $_POST["numero_venta"], PDO::PARAM_STR);
            $sql->bindValue(5, $_POST["id_usuario"], PDO::PARAM_INT);
            $sql->execute();
             $resultado =$sql->fetchAll();
         
            
             // for  que permite recuperar el ultimo id insertado
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
  

     }


     //consultar de venta por fecha
     public function lista_busca_registros_fecha($fecha_inicial, $fecha_final){
      $conectar= parent::conexion();
        parent::set_names();

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
            parent::set_names();


          //variables que vienen por POST VIA AJAX
             $mes=$_POST["mes"];
             $ano=$_POST["ano"];



           $fecha= ($ano."-".$mes."%");


          $sql= "select v.idventas,concat(u.nombres,' ' , u.apellidos) as vendedor,v.total_pagar, v.numero_venta, v.fechaventa, v.estado from ventas v inner join usuarios u on v.id_usuario= u.id_usuario
            WHERE fechaventa like ?;";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1,$fecha);
            $sql->execute();
            return $result = $sql->fetchAll(PDO::FETCH_ASSOC);


        }
        public function Mostrar($idventas)
        {
           $conectar= parent::conexion();
            parent::set_names();
            $sql="select v.idventas,concat(u.nombres,' ', u.apellidos) as vendedor , date(v.fechaventa) as fecha,v.numero_venta 
            from ventas as v 
               inner join usuarios as u on v.id_usuario=u.id_usuario where idventas=?;";
             $sql =$conectar->prepare($sql);
             $sql->bindValue(1,$idventas);
             $sql->execute();
             return $resultado =$sql->fetchAll(PDO::FETCH_ASSOC);

        }

        public function listardetalle($idventas)
        {
          $conectar= parent::conexion();
          parent::set_names();
          $sql="select d.id_detalle,p.producto , d.cantidad, d.precio_venta , d.id_ventas,(d.cantidad * d.precio_venta) as subtotal from detalleventas as d
           inner join producto as p on p.id_producto=d.id_producto 
             where d.id_ventas=?;";
        $sql= $conectar->prepare($sql);
        $sql->bindValue(1,$idventas);
        $sql->execute();
            return $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
// reportes de ventas 

        public function get_ventas_reporte_general()
        {
          $conectar=parent::conexion();
           parent::set_names();

           $sql="SELECT MONTHname(fechaventa) as mes, MONTH(fechaventa) as numero_mes, YEAR(fechaventa) as año, SUM(total_pagar) as total_venta
        FROM ventas where estado='1' GROUP BY YEAR(fechaventa) desc, MONTH(fechaventa) desc, MONTHname(fechaventa) desc;";
        $sql=$conectar->prepare($sql);
        $sql->execute();
        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
        }

        // SUMA EL TOTAL DE VENTAS POR AÑOS

      public function suma_ventas_total_ano()
      {
        $conectar=parent::conexion();
           parent::set_names();
           $sql="SELECT YEAR(fechaventa) as año,SUM(total_pagar) as total_venta_año FROM ventas where estado='1' GROUP BY YEAR(fechaventa) desc;";
           $sql=$conectar->prepare($sql);
           $sql->execute();
           return $resultado=$sql->fetchAll();
          /* $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
          echo json_encode($resultado);*/
      }
      // SUMA TOTAL DE VENTAS POR AÑOS PARA LA GRAFICAS

      public function suma_ventas_total_grafica()
      {
       $conectar=parent::conexion();
           parent::set_names();
           $sql="SELECT YEAR(fechaventa) as año,SUM(total_pagar) as total_venta_año FROM ventas where estado='1' GROUP BY YEAR(fechaventa) desc;";
           $sql=$conectar->prepare($sql);
           $sql->execute();
            $resultado=$sql->fetchAll();

            // recorre el array y se imprime
            foreach ($resultado as $row) {
              $año= $output["año"]=$row["año"];
              $total= $output["total_venta_año"]=$row["total_venta_año"];

              echo $grafica= "{name:'".$año."', y:".$total."},";
            }
      }
        // SUMA TOTAL DE VENTAS CANCELADA POR AÑOS PARA LA GRAFICAS

        public function suma_ventas_cancelada_total_grafica()
        {
          $conectar=parent::conexion();
           parent::set_names();
           $sql="SELECT YEAR(fechaventa) as año,SUM(total_pagar) as total_venta_año FROM ventas where estado='0' GROUP BY YEAR(fechaventa) desc;";
            $sql=$conectar->prepare($sql);
           $sql->execute();

           $resultado= $sql->fetchAll();

           //recorrer el array y se imprime
           foreach($resultado as $row){

            $año=$output["año"]=$row["año"];
            $total=$output["total_venta_año"]=$row["total_venta_año"];
            echo $grafica= "{name:'".$año."', y:".$total."},";
           }
 

        }
        // SUMA TOTAL DE VENTAS POR MES PARA LA GRAFICAS

       public  function sumas_ventas_anio_mes_grafica($fecha)
        {
         $conectar=parent::conexion();
           parent::set_names();
            //se usa para traducir el mes en la grafica
       //imprime la fecha por separado ejemplo: dia, mes y año
          $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
          //SI EXISTE EL ENVIO POST ENTONCES SE MUESTRA LA FECHA SELECCIONADA
        if(isset($_POST["year"])){

          $fecha=$_POST["year"];

          $sql="SELECT YEAR(fechaventa) as año, MONTHname(fechaventa) as mes, SUM(total_pagar) as total_venta_mes FROM ventas 
        WHERE YEAR(fechaventa)=? and estado ='1'
        GROUP BY MONTHname(fechaventa) desc;";

           $sql=$conectar->prepare($sql);
           $sql->bindValue(1,$fecha);
            $sql->execute();
          

           $resultado= $sql->fetchAll();
        // recorre el array y se imprime
        foreach ($resultado as $row){

          $año=$output["mes"]=$meses[date("n", strtotime($row["mes"]))-1];
          $total=$output["total_venta_mes"]=$row["total_venta_mes"];
         echo $grafica= "{name:'".$año."', y:".$total."},";
        }
        }else{
         //sino se envia el POST, entonces se mostraria los datos del año actual cuando se abra la pagina por primera vez
         $fecha_inicial=date("Y");

         $sql="SELECT YEAR(fechaventa) as año, MONTHname(fechaventa) as mes, SUM(total_pagar) as total_venta_mes FROM ventas 
        WHERE YEAR(fechaventa)=? and estado ='1' 
        GROUP BY MONTHname(fechaventa) desc;";
         $sql=$conectar->prepare($sql);
           $sql->bindValue(1,$fecha_inicial);
           $sql->execute();

           $resultado= $sql->fetchAll();
           foreach($resultado as $row){

            $año=$output["mes"]=$meses[date("n", strtotime($row["mes"]))-1];
          $total=$output["total_venta_mes"]=$row["total_venta_mes"];
         echo $grafica= "{name:'".$año."', y:".$total."},";
           }
        } // cierre del else

    }


   public function get_year_ventas(){

        $conectar=parent::conexion();

          $sql="select year(fechaventa) as fecha from ventas group by year(fechaventa) asc";
          

          $sql=$conectar->prepare($sql);
          $sql->execute();
          return $resultado= $sql->fetchAll();


     }
     public function get_ventas_mensual($fecha){


        $conectar=parent::conexion();
      
      if(isset($_POST["year"])){

          $fecha=$_POST["year"];

        $sql="select MONTHname(fechaventa) as mes, MONTH(fechaventa) as numero_mes, YEAR(fechaventa) as año, SUM(total_pagar) as total_venta
        from ventas where YEAR(fechaventa)=? and estado='1' group by MONTHname(fechaventa) desc;";
          
            
          $sql=$conectar->prepare($sql);
          $sql->bindValue(1,$fecha);
          $sql->execute();
         return $resultado= $sql->fetchAll();
          /*$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
          echo json_encode($resultado);*/


        } else {

          //sino se envia el POST, entonces se mostraria los datos del año actual cuando se abra la pagina por primera vez

          $fecha_inicial=date("Y");

             $sql="select MONTHname(fechaventa) as mes, MONTH(fechaventa) as numero_mes, YEAR(fechaventa) as año, SUM(total_pagar) as total_venta
        from ventas where YEAR(fechaventa)=? and estado='1' group by MONTHname(fechaventa) desc, YEAR(fechaventa) desc;";
          

         $sql=$conectar->prepare($sql);
          $sql->bindValue(1,$fecha_inicial);
          $sql->execute();
            return $resultado= $sql->fetchAll();



        }
     }
  // ventas anual actual
      public function get_ventas_anio_actual(){

        $conectar=parent::conexion();
        parent::set_names();

        $sql="SELECT YEAR(fechaventa) as año, MONTHname(fechaventa) as mes, SUM(total_pagar) as total_venta_mes FROM ventas
        WHERE YEAR(fechaventa)=YEAR(CURDATE()) 
        and estado='1' GROUP BY MONTHname(fechaventa) desc, YEAR(fechaventa) desc;";

        $sql=$conectar->prepare($sql);
        $sql->execute();
        return $resultado=$sql->fetchAll();

    }
 //metodo de llanado para grafica
    public function get_ventas_anio_actual_grafica(){

       $conectar=parent::conexion();
       parent::set_names();

        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
       
       $sql="SELECT  MONTHname(fechaventa) as mes, SUM(total_pagar) as total_venta_mes FROM ventas
        WHERE YEAR(fechaventa)=YEAR(CURDATE()) and estado='1' GROUP BY MONTHname(fechaventa) desc";
           
           $sql=$conectar->prepare($sql);
           $sql->execute();

           $resultado= $sql->fetchAll();
             
             //recorro el array y lo imprimo
           foreach($resultado as $row){


          $mes= $output["mes"]=$meses[date("n", strtotime($row["mes"]))-1];
          $total = $output["total_venta_mes"]=$row["total_venta_mes"];

         echo $grafica= "{name:'".$mes."', y:".$total."},";

           }
 
    }

        /****** Bloque agregado ******/

          public function get_venta_por_id_usuario($id_usuario){
          $conectar= parent::conexion();
          $sql="select * from ventas where id_usuario=?";
          $sql=$conectar->prepare($sql);
          $sql->bindValue(1, $id_usuario);
          $sql->execute();
          return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        /****** Fin bloque agregado ******/


// metodo para obtener el valor del numero de venta
    public function numeroventa(){

       $conectar=parent::conexion();
        parent::set_names();

     
        $sql="select numero_venta from ventas;";

        $sql=$conectar->prepare($sql);

        $sql->execute();
        $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
          foreach($resultado as $k=>$v){

            $numero_venta["numero_venta"]=$v["numero_venta"];

          }

                      
                    if(empty($numero_venta["numero_venta"]))
                    {
                      echo'<input type="text" class="form-control" id="numero_venta" name="numero_venta" placeholder="Número" style="width:50%;" value="NV00001" />';
                    }else{
                        $num     = substr($numero_venta["numero_venta"] , 2);
                        $dig     = $num + 1;
                        $fact = str_pad($dig, 5, "0", STR_PAD_LEFT);
                       // echo '<script>location.reload()</script>';
                        echo '<input type="text" class="form-control" id="numero_venta" name="numero_venta" placeholder="Número"  style="width:50%;"  value="NV'.$fact.'" readonly/>';
                        
                    }
     
        }

  }
?>
